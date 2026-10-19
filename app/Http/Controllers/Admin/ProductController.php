<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\AgeGroup;
use App\Models\Skill;
use App\Models\Need;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Events\ProductApproveEvent;
use App\Http\Controllers\Controller;
use App\Repositories\ShopRepository;
use Illuminate\Support\Facades\Storage;
use App\Repositories\NotificationRepository;

class ProductController extends Controller
{
    /**
     * Display a listing of the products using the 2morro custom dashboard view.
     */
    public function index(Request $request)
    {
        // Support viewing template dashboard version if explicitly requested
        if ($request->query('template') === '1') {
            $status = $request->status;
            $shop = $request->shop;
            $approve = $request->approve;
            $category = $request->category;
            $brand = $request->brand;
            $search = $request->search;

            $products = Product::when($status == '1', function ($query) {
                return $query->where('is_approve', false)->where('is_new', false);
            })->when($status == '0', function ($query) {
                return $query->where('is_approve', false)->where('is_new', true);
            })->when($approve, function ($query) {
                return $query->where('is_approve', true)->where('is_active', true);
            })->when($shop, function ($query) use ($shop) {
                return $query->where('shop_id', $shop);
            })->when($brand, function ($query) use ($brand) {
                return $query->where('brand_id', $brand);
            })->when($category, function ($query) use ($category) {
                return $query->whereHas('categories', function ($query) use ($category) {
                    return $query->where('category_id', $category);
                });
            })->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%$search%");
            })->paginate(20);

            $shops = \Illuminate\Support\Facades\Schema::hasTable('shops')
                ? ShopRepository::query()->isActive()->get()
                : collect();

            $brands = Brand::where('is_active', '1')->get();
            $categories = Category::active()->get();

            return view('admin.product.index', compact('products', 'shops', 'brands', 'categories'));
        }

        // Default 2morro Original Dashboard View
        $query = Product::with(['categories', 'ageGroups', 'skills', 'needs'])->latest('id');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $products = $query->paginate(20)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $product = new Product();
        $categories = Category::all();
        $ageGroups = AgeGroup::all();
        $skills = Skill::all();
        $needs = Need::all();

        return view('admin.products.form', compact('product', 'categories', 'ageGroups', 'skills', 'needs'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:190',
            'slug' => 'nullable|string|max:190|unique:products,slug',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'type' => 'required|string|in:physical,digital,course,session',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'sku' => 'nullable|string|max:100',
            'barcode' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'whats_included' => 'nullable|string',
            'suitable_for' => 'nullable|string',
            'benefits' => 'nullable|string',
            'how_to_use' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'main_image' => 'nullable|image|max:5120',
            'gallery_images.*' => 'nullable|image|max:5120',
            'digital_file' => 'nullable|file|max:51200',
            'categories' => 'nullable|array',
            'age_groups' => 'nullable|array',
            'skills' => 'nullable|array',
            'needs' => 'nullable|array',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']) ?: ('product-' . time());
        }

        if (!empty($validated['benefits'])) {
            $validated['benefits'] = array_values(array_filter(array_map('trim', explode("\n", $validated['benefits']))));
        }
        if (!empty($validated['how_to_use'])) {
            $validated['how_to_use'] = array_values(array_filter(array_map('trim', explode("\n", $validated['how_to_use']))));
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['stock'] = $validated['stock'] ?? 0;

        $images = [];
        $mainFile = $request->file('image') ?: $request->file('main_image');
        if ($mainFile) {
            $path = $mainFile->store('products', 'public');
            $images[] = $path;
        }
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $img) {
                $path = $img->store('products', 'public');
                $images[] = $path;
            }
        }
        if (!empty($images)) {
            $validated['images'] = $images;
        }

        if ($request->hasFile('digital_file')) {
            $path = $request->file('digital_file')->store('digital_products', 'public');
            $validated['digital_file'] = $path;
        }

        $product = Product::create($validated);

        if (!empty($validated['categories'])) {
            $product->categories()->sync($validated['categories']);
        }
        if (!empty($validated['age_groups'])) {
            $product->ageGroups()->sync($validated['age_groups']);
        }
        if (!empty($validated['skills'])) {
            $product->skills()->sync($validated['skills']);
        }
        if (!empty($validated['needs'])) {
            $product->needs()->sync($validated['needs']);
        }

        return redirect()->route('admin.products.index')->with('success', 'تم إضافة المنتج بنجاح!');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['categories', 'ageGroups', 'skills', 'needs']);

        $orderItems = \App\Models\OrderItem::where('product_id', $product->id)->get();
        $totalSalesCount = $orderItems->sum('quantity');
        $totalRevenue = $orderItems->sum(function ($item) {
            return ($item->price ?? 0) * ($item->quantity ?? 1);
        });

        $orderIds = $orderItems->pluck('order_id')->unique();
        $recentOrders = \App\Models\Order::whereIn('id', $orderIds)->latest()->take(10)->get();

        $downloadLicenses = \App\Models\Download::with(['user', 'order'])
            ->where('product_id', $product->id)
            ->latest()
            ->get();

        return view('admin.products.show', compact('product', 'totalSalesCount', 'totalRevenue', 'recentOrders', 'downloadLicenses'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $product->load(['categories', 'ageGroups', 'skills', 'needs']);
        $categories = Category::all();
        $ageGroups = AgeGroup::all();
        $skills = Skill::all();
        $needs = Need::all();

        $benefitsText = is_array($product->benefits) ? implode("\n", $product->benefits) : ($product->benefits ?? '');
        $howToUseText = is_array($product->how_to_use) ? implode("\n", $product->how_to_use) : ($product->how_to_use ?? '');

        return view('admin.products.form', compact('product', 'categories', 'ageGroups', 'skills', 'needs', 'benefitsText', 'howToUseText'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:190',
            'slug' => 'nullable|string|max:190|unique:products,slug,' . $product->id,
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'type' => 'required|string|in:physical,digital,course,session',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'sku' => 'nullable|string|max:100',
            'barcode' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'whats_included' => 'nullable|string',
            'suitable_for' => 'nullable|string',
            'benefits' => 'nullable|string',
            'how_to_use' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'main_image' => 'nullable|image|max:5120',
            'gallery_images.*' => 'nullable|image|max:5120',
            'delete_image' => 'nullable|boolean',
            'digital_file' => 'nullable|file|max:51200',
            'categories' => 'nullable|array',
            'age_groups' => 'nullable|array',
            'skills' => 'nullable|array',
            'needs' => 'nullable|array',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']) ?: ('product-' . time());
        }

        if (isset($validated['benefits'])) {
            $validated['benefits'] = array_values(array_filter(array_map('trim', explode("\n", $validated['benefits']))));
        }
        if (isset($validated['how_to_use'])) {
            $validated['how_to_use'] = array_values(array_filter(array_map('trim', explode("\n", $validated['how_to_use']))));
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['stock'] = $validated['stock'] ?? 0;

        $images = is_array($product->images) ? $product->images : [];

        // Handle deleting current image
        if ($request->boolean('delete_image')) {
            if (!empty($images)) {
                foreach ($images as $oldImg) {
                    if (Storage::disk('public')->exists($oldImg)) {
                        Storage::disk('public')->delete($oldImg);
                    }
                }
                $images = [];
            }
        }

        // Handle uploading/replacing main image
        $mainFile = $request->file('image') ?: $request->file('main_image');
        if ($mainFile) {
            if (!empty($images) && isset($images[0]) && Storage::disk('public')->exists($images[0])) {
                Storage::disk('public')->delete($images[0]);
            }
            $path = $mainFile->store('products', 'public');
            if (!empty($images)) {
                $images[0] = $path;
            } else {
                $images[] = $path;
            }
        }
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $img) {
                $path = $img->store('products', 'public');
                $images[] = $path;
            }
        }
        $validated['images'] = array_values($images);

        if ($request->hasFile('digital_file')) {
            $path = $request->file('digital_file')->store('digital_products', 'public');
            $validated['digital_file'] = $path;
        }

        $product->update($validated);

        if (isset($validated['categories'])) {
            $product->categories()->sync($validated['categories']);
        }
        if (isset($validated['age_groups'])) {
            $product->ageGroups()->sync($validated['age_groups']);
        }
        if (isset($validated['skills'])) {
            $product->skills()->sync($validated['skills']);
        }
        if (isset($validated['needs'])) {
            $product->needs()->sync($validated['needs']);
        }

        return redirect()->route('admin.products.index')->with('success', 'تم تحديث بيانات المنتج بنجاح!');
    }

    /**
     * Approve the product.
     */
    public function approve(Product $product)
    {
        $product->update([
            'is_approve' => true,
            'is_new' => false,
            'is_active' => true,
        ]);

        return back()->withSuccess(__('Product approved successfully'));
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $product->categories()->detach();
        $product->skills()->detach();
        $product->needs()->detach();
        $product->ageGroups()->detach();

        if (is_array($product->images)) {
            foreach ($product->images as $img) {
                if (Storage::disk('public')->exists($img)) {
                    Storage::disk('public')->delete($img);
                }
            }
        }
        if ($product->digital_file_path && Storage::disk('public')->exists($product->digital_file_path)) {
            Storage::disk('public')->delete($product->digital_file_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'تم حذف المنتج بنجاح.');
    }
}
