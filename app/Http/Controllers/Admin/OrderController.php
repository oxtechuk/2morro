<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Roles;
use App\Models\Shop;
use App\Models\User;
use App\Models\Order;
use App\Models\Driver;
use App\Models\CrmLog;
use App\Models\SMSConfig;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use App\Models\GeneraleSetting;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Services\NotificationServices;
use App\Repositories\NotificationRepository;

class OrderController extends Controller
{
    /**
     * Display orders list using 2morro custom dashboard view.
     */
    public function index(Request $request, $status = null)
    {
        // Support viewing template dashboard version if explicitly requested
        if ($request->query('template') === '1') {
            $status = $status ?? $request->status;
            if ($status) {
                $status = str_replace('_', ' ', $status);
            }
            $paymentStatus = $request->payment_status;
            $search = $request->search;

            $generaleSetting = GeneraleSetting::first();
            $businessModel = $generaleSetting?->shop_type ?? 'single';
            $shop = $request->shop_id ?? null;
            if ($businessModel == 'single') {
                $shop = User::role(Roles::ROOT->value)->first()?->shop?->id;
            }
            $orders = OrderRepository::query()
                ->when($shop, fn($query) => $query->where('shop_id', $shop))
                ->when($paymentStatus, fn($query) => $query->where('payment_status', $paymentStatus))
                ->when($search, fn($query) => $query->filter(['search' => $search]))
                ->when($status, fn($query) => $query->where('order_status', $status))
                ->latest('id')
                ->paginate(20);

            $orderStatuses = OrderStatus::cases();
            $paymentStatus = PaymentStatus::cases();
            $shops = Schema::hasTable('shops') ? Shop::isActive()->get() : collect();
            return view('admin.order.index', compact('orders', 'orderStatuses', 'paymentStatus', 'shops', 'businessModel'));
        }

        // Default 2morro Original Dashboard Orders View
        $query = Order::with('items')->latest('id');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        $filterStatus = $status ?? $request->status;
        if (!empty($filterStatus)) {
            $query->where('status', $filterStatus);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $orders = $query->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the order details using 2morro custom view.
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show order invoice using 2morro invoice layout.
     */
    public function invoice(Order $order)
    {
        $order->load(['items.product', 'user']);
        return view('admin.orders.invoice', compact('order'));
    }

    /**
     * Update the order status and notes from 2morro dashboard.
     */
    public function statusChange(Order $order, Request $request)
    {
        $validated = $request->validate([
            'status' => 'nullable|string|max:50',
            'payment_status' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        if (!empty($validated['status'])) {
            $order->status = $validated['status'];
            if (Schema::hasColumn('orders', 'order_status')) {
                $order->order_status = $validated['status'];
            }
        }

        if (!empty($validated['payment_status'])) {
            $order->payment_status = $validated['payment_status'];
        }

        if (isset($validated['notes'])) {
            $order->notes = $validated['notes'];
        }

        $order->save();

        if ($order->user_id) {
            CrmLog::create([
                'user_id' => $order->user_id,
                'admin_id' => Auth::id(),
                'type' => 'order',
                'details' => 'تم تحديث حالة الطلب #' . $order->order_number . ' إلى [' . ($order->status ?? 'قيد المراجعة') . '] والدفع [' . ($order->payment_status ?? 'معلق') . ']',
            ]);
        }

        return redirect()->back()->with('success', 'تم تحديث حالة وبيانات الطلب بنجاح!');
    }

    /**
     * Update the payment status toggle.
     */
    public function paymentStatusToggle(Order $order)
    {
        $current = $order->payment_status;
        $order->payment_status = ($current === 'paid') ? 'pending' : 'paid';
        $order->save();

        return back()->with('success', 'تم تعديل حالة الدفع بنجاح');
    }
}
