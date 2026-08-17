@extends('admin.layouts.layout')

@section('title', 'إدارة الطلبات | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-1">إدارة الطلبات</h4>
                <p class="text-muted mb-0 fs-7">عرض ومعالجة كافة طلبات الشراء للعملاء وتأكيد الدفعات.</p>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3">
                <!-- Search Input -->
                <div class="col-lg-4 col-md-12">
                    <label class="form-label fs-8 fw-semibold text-muted">البحث العام</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-light border-start-0 fs-7" placeholder="رقم الطلب، اسم العميل، رقم الهاتف...">
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <label class="form-label fs-8 fw-semibold text-muted">حالة الشحن</label>
                    <select name="status" class="form-select bg-light fs-7">
                        <option value="">كل الحالات</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>معلق (قيد المراجعة)</option>
                        <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                        <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>تم التوصيل</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>ملغي</option>
                    </select>
                </div>

                <!-- Payment Status Filter -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <label class="form-label fs-8 fw-semibold text-muted">حالة الدفع</label>
                    <select name="payment_status" class="form-select bg-light fs-7">
                        <option value="">كل الحالات</option>
                        <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>مدفوع</option>
                        <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>معلق</option>
                    </select>
                </div>

                <!-- Payment Method Filter -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <label class="form-label fs-8 fw-semibold text-muted">طريقة الدفع</label>
                    <select name="payment_method" class="form-select bg-light fs-7">
                        <option value="">كل الطرق</option>
                        <option value="cod" {{ request('payment_method') === 'cod' ? 'selected' : '' }}>الدفع عند الاستلام</option>
                        <option value="instapay" {{ request('payment_method') === 'instapay' ? 'selected' : '' }}>انستاباي (InstaPay)</option>
                        <option value="wallet" {{ request('payment_method') === 'wallet' ? 'selected' : '' }}>محفظة إلكترونية</option>
                    </select>
                </div>

                <!-- Filter Actions -->
                <div class="col-lg-2 col-md-12 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold fs-7">تصفية</button>
                    @if(request()->anyFilled(['search', 'status', 'payment_status', 'payment_method']))
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-light border w-100 fw-bold fs-7">تصفير</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table Card -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0 fs-7">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">رقم الطلب</th>
                            <th>العميل</th>
                            <th>طريقة الدفع</th>
                            <th>حالة الدفع</th>
                            <th>حالة الشحن</th>
                            <th>إجمالي المبلغ</th>
                            <th>تاريخ الطلب</th>
                            <th class="pe-4 text-end">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="ps-4">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="fw-bold text-primary text-decoration-none">
                                        #{{ $order->order_number }}
                                    </a>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $order->customer_name }}</div>
                                    <small class="text-muted d-block fs-8"><i class="bi bi-telephone me-1"></i>{{ $order->customer_phone }}</small>
                                </td>
                                <td>
                                    @php
                                        $methodLabel = match($order->payment_method) {
                                            'cod' => 'الدفع عند الاستلام',
                                            'instapay' => 'انستاباي',
                                            'wallet' => 'محفظة إلكترونية',
                                            default => 'غير محدد',
                                        };
                                        $methodIcon = match($order->payment_method) {
                                            'cod' => 'bi-truck',
                                            'instapay' => 'bi-phone-flip',
                                            'wallet' => 'bi-wallet2',
                                            default => 'bi-question-circle',
                                        };
                                    @endphp
                                    <span class="text-secondary"><i class="bi {{ $methodIcon }} me-1"></i>{{ $methodLabel }}</span>
                                </td>
                                <td>
                                    @if($order->payment_status === 'paid')
                                        <span class="badge bg-success-subtle text-success"><i class="bi bi-patch-check-fill me-1"></i>مدفوع</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning"><i class="bi bi-hourglass-split me-1"></i>معلق</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($order->status) {
                                            'delivered' => 'bg-success text-white',
                                            'shipped' => 'bg-info text-white',
                                            'cancelled' => 'bg-danger text-white',
                                            default => 'bg-warning text-dark',
                                        };
                                        $statusText = match($order->status) {
                                            'delivered' => 'تم التوصيل',
                                            'shipped' => 'تم الشحن',
                                            'cancelled' => 'ملغي',
                                            default => 'قيد المراجعة',
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }} fw-semibold">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="fw-bold text-dark">{{ number_format($order->total, 2) }} ج.م</td>
                                <td class="text-muted">{{ $order->created_at->format('Y/m/d h:i A') }}</td>
                                <td class="pe-4 text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-xs btn-outline-primary" title="معاينة الطلب والتأكيد">
                                            <i class="bi bi-eye"></i> معاينة
                                        </a>
                                        <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="btn btn-xs btn-outline-secondary" title="طباعة الفاتورة">
                                            <i class="bi bi-printer"></i> فاتورة
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-cart-x fs-1 d-block mb-3 opacity-55"></i> لا توجد طلبات تطابق معايير البحث.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
