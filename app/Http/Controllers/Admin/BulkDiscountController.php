<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class BulkDiscountController extends Controller
{
    /**
     * Display the bulk discounts management dashboard.
     */
    public function index()
    {
        $categories = Category::withCount(['products' => function ($q) {
            $q->where('is_active', true);
        }])->get();

        $discountedProducts = Product::whereNotNull('sale_price')
            ->where('sale_price', '>', 0)
            ->whereRaw('sale_price < price')
            ->with('categories')
            ->latest('updated_at')
            ->paginate(15);

        $totalDiscountedCount = Product::whereNotNull('sale_price')
            ->where('sale_price', '>', 0)
            ->whereRaw('sale_price < price')
            ->count();

        return view('admin.discounts.index', compact('categories', 'discountedProducts', 'totalDiscountedCount'));
    }

    /**
     * Apply percentage discount to an entire category or all products.
     */
    public function applyCategory(Request $request)
    {
        $request->validate([
            'category_id' => 'required|string',
            'percentage' => 'required|numeric|min:1|max:99',
            'badge' => 'nullable|string|max:50',
        ]);

        $percentage = (float) $request->percentage;
        $badge = $request->badge ?: "خصم {$percentage}%";

        if ($request->category_id === 'all') {
            $products = Product::where('is_active', true)->where('price', '>', 0)->get();
        } else {
            $categoryId = (int) $request->category_id;
            $products = Product::where('is_active', true)
                ->where('price', '>', 0)
                ->whereHas('categories', function ($q) use ($categoryId) {
                    $q->where('categories.id', $categoryId);
                })
                ->get();
        }

        $count = 0;
        foreach ($products as $product) {
            $discountAmount = ($product->price * $percentage) / 100.0;
            $salePrice = round($product->price - $discountAmount, 2);
            if ($salePrice > 0 && $salePrice < $product->price) {
                $product->update([
                    'sale_price' => $salePrice,
                    'badge' => $badge,
                ]);
                $count++;
            }
        }

        return redirect()->route('admin.discounts.index')->with('success', "تم تطبيق خصم {$percentage}% بنجاح على {$count} منتج.");
    }

    /**
     * Reset/clear discounts for an entire category or all products.
     */
    public function resetCategory(Request $request)
    {
        $request->validate([
            'category_id' => 'required|string',
        ]);

        if ($request->category_id === 'all') {
            $products = Product::whereNotNull('sale_price')->get();
        } else {
            $categoryId = (int) $request->category_id;
            $products = Product::whereNotNull('sale_price')
                ->whereHas('categories', function ($q) use ($categoryId) {
                    $q->where('categories.id', $categoryId);
                })
                ->get();
        }

        $count = 0;
        foreach ($products as $product) {
            $product->update([
                'sale_price' => null,
                'badge' => null,
            ]);
            $count++;
        }

        return redirect()->route('admin.discounts.index')->with('success', "تم إلغاء العروض واستعادة الأسعار الأصلية لـ {$count} منتج.");
    }

    /**
     * Reset single product discount.
     */
    public function resetProduct(Product $product)
    {
        $product->update([
            'sale_price' => null,
            'badge' => null,
        ]);

        return back()->with('success', "تم إرجاع سعر المنتج [{$product->name}] إلى السعر الأصلي.");
    }
}
