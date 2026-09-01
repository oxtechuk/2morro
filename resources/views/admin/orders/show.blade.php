@extends('admin.layouts.layout')

@section('title', 'طلب #' . $order->order_number . ' | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-1">طلب شراء: #{{ $order->order_number }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">الطلبات</a></li>
                        <li class="breadcrumb-item active" aria-current="page">طلب #{{ $order->order_number }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="btn btn-light border fw-bold fs-7">
                    <i class="bi bi-printer me-1"></i> طباعة الفاتورة
                </a>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary fw-bold fs-7">
                    العودة للقائمة
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Column 1: Order Details & Products -->
        <div class="col-lg-8 col-md-12 mb-4">
            
            <!-- Items ordered -->
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0 fw-bold"><i class="bi bi-basket3 text-primary me-2"></i>المنتجات المطلوبة</h5></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 fs-7">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">المنتج</th>
                                    <th>النوع</th>
                                    <th class="text-center">السعر</th>
                                    <th class="text-center">الكمية</th>
                                    <th class="text-end pe-4">الإجمالي الفرعي</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-3">
                                                @if($item->product && is_array($item->product->images) && !empty($item->product->images))
                                                    <img src="{{ asset('storage/' . $item->product->images[0]) }}" class="rounded object-fit-cover border" style="width: 48px; height: 48px;" alt="{{ $item->product_name }}">
                                                @else
                                                    <div class="rounded bg-light text-secondary d-flex align-items-center justify-content-center border" style="width: 48px; height: 48px;">
                                                        <i class="bi bi-box-seam fs-5"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    @if($item->product)
                                                        <a href="{{ route('admin.products.show', $item->product->id) }}" class="fw-bold text-dark text-decoration-none hover-primary">
                                                            {{ $item->product_name }}
                                                        </a>
                                                    @else
                                                        <span class="fw-bold text-dark">{{ $item->product_name }}</span>
                                                    @endif
                                                    <small class="text-muted d-block fs-8">رمز SKU: {{ $item->product->sku ?? 'بدون رمز' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $typeLabel = match($item->type) {
                                                    'digital' => 'تحميل فوري (PDF)',
                                                    'course' => 'كورس تعليمي',
                                                    'session' => 'جلسة تواصل',
                                                    default => 'أداة مادية',
                                                };
                                                $typeBadge = match($item->type) {
                                                    'digital' => 'bg-info-subtle text-info',
                                                    default => 'bg-secondary-subtle text-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $typeBadge }} fs-8 fw-semibold">{{ $typeLabel }}</span>
                                        </td>
                                        <td class="text-center fw-bold">{{ number_format($item->price, 2) }} ج.م</td>
                                        <td class="text-center fw-semibold">{{ $item->quantity }}</td>
                                        <td class="text-end pe-4 fw-black text-primary">{{ number_format($item->price * $item->quantity, 2) }} ج.م</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Totals & Customer Shipping details -->
            <div class="row">
                <div class="col-md-6 col-sm-12 mb-4 mb-md-0">
                    <div class="card h-100">
                        <div class="card-header"><h5 class="mb-0 fw-bold"><i class="bi bi-geo-alt text-danger me-2"></i>معلومات الشحن والتسليم</h5></div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush fs-7 ps-0">
                                <li class="list-group-item d-flex justify-content-between py-2.5">
                                    <span class="text-muted">الاسم المستلم:</span>
                                    <span class="fw-bold text-dark">{{ $order->customer_name }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between py-2.5">
                                    <span class="text-muted">رقم الهاتف:</span>
                                    <span class="fw-bold text-dark">{{ $order->customer_phone }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between py-2.5">
                                    <span class="text-muted">البريد الإلكتروني:</span>
                                    <span class="fw-bold text-dark">{{ $order->customer_email }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between py-2.5">
                                    <span class="text-muted">المحافظة:</span>
                                    <span class="fw-bold text-dark">{{ $order->shipping_governorate }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between py-2.5">
                                    <span class="text-muted">العنوان بالكامل:</span>
                                    <span class="fw-bold text-dark-emphasis text-end" style="max-width: 60%">{{ $order->shipping_address }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="card h-100">
                        <div class="card-header"><h5 class="mb-0 fw-bold"><i class="bi bi-cash text-success me-2"></i>ملخص الحسابات المالية</h5></div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush fs-7 ps-0">
                                <li class="list-group-item d-flex justify-content-between py-2.5">
                                    <span class="text-muted">الإجمالي الفرعي:</span>
                                    <span class="fw-semibold">{{ number_format($order->subtotal, 2) }} ج.م</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between py-2.5">
                                    <span class="text-muted">رسوم الشحن والتوصيل:</span>
                                    <span class="fw-semibold">{{ number_format($order->shipping_fee, 2) }} ج.م</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between py-2.5">
                                    <span class="text-muted">الخصم المطبق:</span>
                                    <span class="fw-semibold text-danger">-{{ number_format($order->discount_total, 2) }} ج.م</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between py-3 border-top border-2">
                                    <span class="fw-black text-dark-emphasis">المبلغ الإجمالي النهائي:</span>
                                    <span class="fw-black fs-5 text-primary">{{ number_format($order->total, 2) }} ج.م</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Column 2: Order actions & Screenshot -->
        <div class="col-lg-4 col-md-12 mb-4">
            
            <!-- Update Status Panel -->
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0 fw-bold"><i class="bi bi-gear-fill text-secondary me-2"></i>تعديل حالة الطلب</h5></div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        <!-- Shipping Status -->
                        <div class="mb-3">
                            <label class="form-label fs-8 fw-semibold text-muted">حالة الشحن والتسليم</label>
                            <select name="status" class="form-select bg-light fs-7">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>معلق (قيد المراجعة)</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>تم التوصيل والإنهاء</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>ملغي</option>
                            </select>
                        </div>

                        <!-- Payment Status -->
                        <div class="mb-3">
                            <label class="form-label fs-8 fw-semibold text-muted">حالة الدفع</label>
                            <select name="payment_status" class="form-select bg-light fs-7">
                                <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>معلق (لم يتم التأكيد)</option>
                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>مدفوع (تم التحقق والتأكيد)</option>
                            </select>
                        </div>

                        <!-- Order Notes -->
                        <div class="mb-3">
                            <label class="form-label fs-8 fw-semibold text-muted">ملاحظات إضافية على الطلب</label>
                            <textarea name="notes" rows="3" class="form-control bg-light fs-7" placeholder="اكتب أي ملاحظات للشحن أو المتابعة مع العميل...">{{ $order->notes }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold fs-7">
                            تحديث وحفظ البيانات
                        </button>
                    </form>
                </div>
            </div>

            <!-- InstaPay / Wallet Payment screenshot details -->
            @if($order->payment_method !== 'cod')
                <div class="card">
                    <div class="card-header bg-info-subtle"><h5 class="mb-0 fw-bold text-info-emphasis"><i class="bi bi-shield-lock-fill me-2"></i>إثبات التحويل المالي</h5></div>
                    <div class="card-body text-center">
                        <div class="mb-2 fs-7 text-muted">
                            العميل اختار الدفع عبر: 
                            <span class="fw-bold text-dark">
                                @if($order->payment_method === 'instapay')
                                    تطبيق InstaPay
                                @elseif($order->payment_method === 'bank')
                                    التحويل البنكي (IBAN)
                                @else
                                    المحافظ الإلكترونية
                                @endif
                            </span>
                        </div>
                        
                        @if($order->payment_screenshot)
                            <div class="position-relative border rounded p-2 mb-3 bg-light d-inline-block" style="max-width: 100%">
                                <img src="{{ asset('storage/' . $order->payment_screenshot) }}" class="img-fluid rounded border object-fit-cover" style="max-height: 180px; width: auto; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#screenshotModal" alt="إثبات التحويل">
                                <div class="fs-9 text-muted mt-1">اضغط على الصورة للتكبير</div>
                            </div>
                            <button type="button" class="btn btn-outline-info w-100 fw-bold fs-7" data-bs-toggle="modal" data-bs-target="#screenshotModal">
                                <i class="bi bi-zoom-in me-1"></i> معاينة إثبات التحويل
                            </button>
                        @else
                            <div class="text-danger py-3 fs-7 fw-semibold">
                                <i class="bi bi-x-octagon fs-4 d-block mb-1"></i> لم يرفع العميل صورة إثبات الدفع!
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

<!-- Modal for Payment Screenshot Preview -->
@if($order->payment_screenshot)
    <div class="modal fade" id="screenshotModal" tabindex="-1" aria-labelledby="screenshotModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="screenshotModalLabel">معاينة إثبات التحويل المرفوع</h5>
                    <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-3 bg-dark-subtle">
                    <img src="{{ asset('storage/' . $order->payment_screenshot) }}" class="img-fluid rounded border shadow" style="max-height: 75vh;" alt="صورة التحويل المالي الكاملة">
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">إغلاق المعاينة</button>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection
