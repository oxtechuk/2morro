<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of coupons.
     */
    public function index()
    {
        $coupons = Coupon::with(['categories', 'products'])
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total' => Coupon::count(),
            'active' => Coupon::where('is_active', true)->count(),
            'total_used' => (int) Coupon::sum('total_used'),
            'total_savings' => (float) \App\Models\Order::sum('discount_total'),
        ];

        return view('admin.coupon.index', compact('coupons', 'stats'));
    }

    /**
     * Show the form for creating a new coupon.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->select('id', 'name', 'price')->get();

        return view('admin.coupon.create', compact('categories', 'products'));
    }

    /**
     * Store a newly created coupon in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:coupons,code'],
            'discount_type' => ['required', 'in:percentage,fixed'],
            'discount' => ['required', 'numeric', 'min:0.01'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'max_discount_amount' => ['nullable', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'expired_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'limit_for_user' => ['nullable', 'integer', 'min:1'],
            'total_usage_limit' => ['nullable', 'integer', 'min:1'],
            'applies_to' => ['required', 'in:all,category,product'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
            'products' => ['nullable', 'array'],
            'products.*' => ['exists:products,id'],
        ], [
            'code.required' => 'رمز كود الخصم مطلوب.',
            'code.unique' => 'كود الخصم هذا مستخدم بالفعل.',
            'discount.required' => 'قيمة الخصم مطلوبة.',
            'expired_date.after_or_equal' => 'تاريخ الانتهاء يجب أن يكون مساوياً أو بعد تاريخ البداية.',
        ]);

        $coupon = Coupon::create([
            'code' => strtoupper(trim($validated['code'])),
            'discount_type' => $validated['discount_type'],
            'discount' => $validated['discount'],
            'min_order_amount' => $validated['min_order_amount'] ?? 0.00,
            'max_discount_amount' => $validated['max_discount_amount'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'expired_date' => $validated['expired_date'] ?? null,
            'limit_for_user' => $validated['limit_for_user'] ?? 1,
            'total_usage_limit' => $validated['total_usage_limit'] ?? null,
            'applies_to' => $validated['applies_to'],
            'is_active' => true,
        ]);

        if ($validated['applies_to'] === 'category' && !empty($validated['categories'])) {
            $coupon->categories()->sync($validated['categories']);
        } elseif ($validated['applies_to'] === 'product' && !empty($validated['products'])) {
            $coupon->products()->sync($validated['products']);
        }

        return redirect()->route('admin.coupon.index')->with('success', 'تم إنشاء كود الخصم بنجاح.');
    }

    /**
     * Show the form for editing the specified coupon.
     */
    public function edit(Coupon $coupon)
    {
        $coupon->load(['categories', 'products']);
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->select('id', 'name', 'price')->get();

        return view('admin.coupon.edit', compact('coupon', 'categories', 'products'));
    }

    /**
     * Update the specified coupon in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:coupons,code,' . $coupon->id],
            'discount_type' => ['required', 'in:percentage,fixed'],
            'discount' => ['required', 'numeric', 'min:0.01'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'max_discount_amount' => ['nullable', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'expired_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'limit_for_user' => ['nullable', 'integer', 'min:1'],
            'total_usage_limit' => ['nullable', 'integer', 'min:1'],
            'applies_to' => ['required', 'in:all,category,product'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
            'products' => ['nullable', 'array'],
            'products.*' => ['exists:products,id'],
        ], [
            'code.required' => 'رمز كود الخصم مطلوب.',
            'code.unique' => 'كود الخصم هذا مستخدم بالفعل.',
            'discount.required' => 'قيمة الخصم مطلوبة.',
            'expired_date.after_or_equal' => 'تاريخ الانتهاء يجب أن يكون مساوياً أو بعد تاريخ البداية.',
        ]);

        $coupon->update([
            'code' => strtoupper(trim($validated['code'])),
            'discount_type' => $validated['discount_type'],
            'discount' => $validated['discount'],
            'min_order_amount' => $validated['min_order_amount'] ?? 0.00,
            'max_discount_amount' => $validated['max_discount_amount'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'expired_date' => $validated['expired_date'] ?? null,
            'limit_for_user' => $validated['limit_for_user'] ?? 1,
            'total_usage_limit' => $validated['total_usage_limit'] ?? null,
            'applies_to' => $validated['applies_to'],
        ]);

        if ($validated['applies_to'] === 'category') {
            $coupon->categories()->sync($validated['categories'] ?? []);
            $coupon->products()->detach();
        } elseif ($validated['applies_to'] === 'product') {
            $coupon->products()->sync($validated['products'] ?? []);
            $coupon->categories()->detach();
        } else {
            $coupon->categories()->detach();
            $coupon->products()->detach();
        }

        return redirect()->route('admin.coupon.index')->with('success', 'تم تعديل كود الخصم بنجاح.');
    }

    /**
     * Remove the specified coupon from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return back()->with('success', 'تم حذف كود الخصم بنجاح.');
    }

    /**
     * Toggle active status.
     */
    public function statusToggle(Coupon $coupon)
    {
        $coupon->update([
            'is_active' => !$coupon->is_active,
        ]);

        return back()->with('success', 'تم تغيير حالة تفعيل كود الخصم بنجاح.');
    }
}
