<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // List all orders with filters
    public function index(Request $request)
    {
        $query = Order::query()->latest();

        // Search filter (order number, name, phone, email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Payment status filter
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Payment method filter
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    // Show single order details
    public function show(Order $order)
    {
        $order->load(['items.product', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    // Update order status, payment status and notes
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,shipped,delivered,cancelled',
            'payment_status' => 'required|in:paid,pending',
            'notes' => 'nullable|string',
        ]);

        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'notes' => $request->notes,
        ]);

        // If the order status is updated to delivered and payment is paid, we can activate/ensure digital downloads are active
        // Our system already creates downloads in CheckoutController. If payment was verified, they are valid.
        
        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'تم تحديث حالة الطلب والبيانات بنجاح.');
    }

    // Show print-friendly invoice
    public function invoice(Order $order)
    {
        $order->load(['items.product']);
        return view('admin.orders.invoice', compact('order'));
    }
}
