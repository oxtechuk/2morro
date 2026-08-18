<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\AgeGroup;
use App\Models\Skill;
use App\Models\Need;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with(['categories']);

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Category Filter
        if ($request->filled('category')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // Type Filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['categories', 'ageGroups', 'skills', 'needs']);

        // 1. Calculate stats (only paid orders count)
        $totalSalesCount = \App\Models\OrderItem::where('product_id', $product->id)
            ->whereHas('order', function($q) {
                $q->where('payment_status', 'paid');
            })->sum('quantity');

        $totalRevenue = \App\Models\OrderItem::where('product_id', $product->id)
            ->whereHas('order', function($q) {
                $q->where('payment_status', 'paid');
            })->select(\Illuminate\Support\Facades\DB::raw('SUM(price * quantity) as total'))
            ->first()->total ?? 0;

        // 2. Recent orders of this product
        $recentOrders = \App\Models\Order::whereHas('items', function($q) use ($product) {
            $q->where('product_id', $product->id);
        })->latest()->take(10)->get();

        // 3. Digital specific: download licenses list
        $downloadLicenses = [];
        if ($product->type === 'digital') {
            $downloadLicenses = \App\Models\Download::where('product_id', $product->id)
                ->with(['user', 'order'])
                ->latest()
                ->get();
        }

        return view('admin.products.show', compact('product', 'totalSalesCount', 'totalRevenue', 'recentOrders', 'downloadLicenses'));
    }

    public function create()
    {
        $product = new Product(); // Empty model for form reuse
        $categories = Category::all();
        $ageGroups = AgeGroup::all();
        $skills = Skill::all();
        $needs = Need::all();

        return view('admin.products.form', compact('product', 'categories', 'ageGroups', 'skills', 'needs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'type' => 'required|in:physical,digital,course,session',
            'stock' => 'required|integer|min:0',
            'video_url' => 'nullable|url',
            'badge' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'digital_file' => 'nullable|file|mimes:pdf,zip,rar|max:15360', // max 15MB
            'digital_download_limit' => 'nullable|integer|min:1',
            'digital_expiry_days' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'name', 'description', 'short_description', 'price', 'sale_price', 
            'sku', 'type', 'stock', 'video_url', 'badge', 'whats_included', 'suitable_for'
        ]);

        $data['slug'] = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        // Convert new-line separated inputs to arrays
        if ($request->filled('benefits')) {
            $data['benefits'] = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->benefits))));
        } else {
            $data['benefits'] = [];
        }

        if ($request->filled('how_to_use')) {
            $data['how_to_use'] = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->how_to_use))));
        } else {
            $data['how_to_use'] = [];
        }

        // Handle Primary Image Upload
        // Handle Primary Image Upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::random(40) . '.' . ($file->getClientOriginalExtension() ?: 'jpg');
            $file->move(storage_path('app/public/products'), $filename);
            $data['images'] = ['products/' . $filename];
        } else {
            $data['images'] = [];
        }

        // Handle Digital File Upload
        if ($request->type === 'digital' && $request->hasFile('digital_file')) {
            $file = $request->file('digital_file');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
            
            // Store inside private folder
            $file->move(storage_path('app/private/private_downloads'), $filename);
            
            $data['digital_file_path'] = 'private_downloads/' . $filename;
            $data['digital_file_name'] = $file->getClientOriginalName();
            $data['digital_download_limit'] = $request->digital_download_limit;
            $data['digital_expiry_days'] = $request->digital_expiry_days;
        }

        // Create Product
        $product = Product::create($data);

        // Sync Relationships
        $product->categories()->sync($request->input('categories', []));
        $product->ageGroups()->sync($request->input('age_groups', []));
        $product->skills()->sync($request->input('skills', []));
        $product->needs()->sync($request->input('needs', []));

        return redirect()->route('admin.products.index')->with('success', 'تم إضافة المنتج بنجاح.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $ageGroups = AgeGroup::all();
        $skills = Skill::all();
        $needs = Need::all();

        // Format array values back to text area strings (with line breaks)
        $benefitsText = is_array($product->benefits) ? implode("\n", $product->benefits) : '';
        $howToUseText = is_array($product->how_to_use) ? implode("\n", $product->how_to_use) : '';

        return view('admin.products.form', compact('product', 'categories', 'ageGroups', 'skills', 'needs', 'benefitsText', 'howToUseText'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'type' => 'required|in:physical,digital,course,session',
            'stock' => 'required|integer|min:0',
            'video_url' => 'nullable|url',
            'badge' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'digital_file' => 'nullable|file|mimes:pdf,zip,rar|max:15360', // max 15MB
            'digital_download_limit' => 'nullable|integer|min:1',
            'digital_expiry_days' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'name', 'description', 'short_description', 'price', 'sale_price', 
            'sku', 'type', 'stock', 'video_url', 'badge', 'whats_included', 'suitable_for'
        ]);

        $data['slug'] = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        // Convert new-line separated inputs to arrays
        if ($request->filled('benefits')) {
            $data['benefits'] = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->benefits))));
        } else {
            $data['benefits'] = [];
        }

        if ($request->filled('how_to_use')) {
            $data['how_to_use'] = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->how_to_use))));
        } else {
            $data['how_to_use'] = [];
        }

        // Handle Primary Image Upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::random(40) . '.' . ($file->getClientOriginalExtension() ?: 'jpg');
            $file->move(storage_path('app/public/products'), $filename);
            $data['images'] = ['products/' . $filename];
        }

        // Handle Digital File Upload
        if ($request->type === 'digital') {
            if ($request->hasFile('digital_file')) {
                $file = $request->file('digital_file');
                $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
                $file->move(storage_path('app/private/private_downloads'), $filename);
                
                $data['digital_file_path'] = 'private_downloads/' . $filename;
                $data['digital_file_name'] = $file->getClientOriginalName();
            }
            
            $data['digital_download_limit'] = $request->digital_download_limit;
            $data['digital_expiry_days'] = $request->digital_expiry_days;
        } else {
            // If type changed from digital to physical, clear digital settings
            $data['digital_file_path'] = null;
            $data['digital_file_name'] = null;
            $data['digital_download_limit'] = null;
            $data['digital_expiry_days'] = null;
        }

        // Update Product
        $product->update($data);

        // Sync Relationships
        $product->categories()->sync($request->input('categories', []));
        $product->ageGroups()->sync($request->input('age_groups', []));
        $product->skills()->sync($request->input('skills', []));
        $product->needs()->sync($request->input('needs', []));

        return redirect()->route('admin.products.index')->with('success', 'تم تحديث المنتج بنجاح.');
    }

    public function destroy(Product $product)
    {
        // Delete images
        if (is_array($product->images) && !empty($product->images)) {
            foreach ($product->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        // Delete digital file
        if ($product->digital_file_path) {
            Storage::disk('local')->delete($product->digital_file_path);
        }

        // Detach relations
        $product->categories()->detach();
        $product->ageGroups()->detach();
        $product->skills()->detach();
        $product->needs()->detach();

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'تم حذف المنتج بنجاح.');
    }
}
