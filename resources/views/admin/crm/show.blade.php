@extends('admin.layouts.layout')

@section('title', 'ملف العميل: ' . ($user->name ?? 'عميل') . ' | لوحة التحكم')

@push('css')
<style>
    /* Modern CRM Customer Profile Styling */
    .crm-card {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        background: #fff;
        margin-bottom: 24px;
        overflow: hidden;
    }
    .crm-card-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 16px 20px;
        font-weight: 700;
        font-size: 1.05rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .crm-stat-card {
        border-radius: 12px;
        padding: 18px 20px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .crm-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.08);
    }
    .crm-stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    /* Timeline */
    .crm-timeline {
        position: relative;
        padding-right: 25px;
        list-style: none;
        margin: 0;
    }
    .crm-timeline::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        right: 11px;
        width: 2px;
        background-color: #e2e8f0;
    }
    .crm-timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    .crm-timeline-badge {
        position: absolute;
        top: 4px;
        right: -25px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: #cbd5e1;
        border: 3px solid #ffffff;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        color: #fff;
    }
    .crm-timeline-badge.bg-call { background-color: #0284c7; }
    .crm-timeline-badge.bg-whatsapp { background-color: #16a34a; }
    .crm-timeline-badge.bg-email { background-color: #6366f1; }
    .crm-timeline-badge.bg-system { background-color: #64748b; }
    .crm-timeline-badge.bg-note { background-color: #d97706; }

    .crm-timeline-content {
        margin-right: 12px;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        border-radius: 10px;
        padding: 14px 16px;
    }

    .nav-tabs .nav-link {
        font-weight: 600;
        color: #64748b;
        border: none;
        border-bottom: 3px solid transparent;
        padding: 12px 18px;
    }
    .nav-tabs .nav-link.active {
        color: #0284c7;
        background: transparent;
        border-bottom-color: #0284c7;
    }
    .badge-subtle-primary { background: #e0f2fe; color: #0369a1; }
    .badge-subtle-success { background: #dcfce7; color: #15803d; }
    .badge-subtle-warning { background: #fef3c7; color: #b45309; }
    .badge-subtle-danger { background: #fee2e2; color: #b91c1c; }
    .badge-subtle-info { background: #e0e7ff; color: #4338ca; }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">

    <!-- Header & Breadcrumbs -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-1">ملف العميل: {{ $user->name ?? 'عميل' }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.crm.index') }}">سجل العملاء (CRM)</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $user->name ?? ('عميل #' . $user->id) }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-white text-dark border px-3 py-2 fs-7 fw-normal shadow-xs">
                    معرف العميل: <strong class="text-primary font-monospace">#{{ $user->id }}</strong>
                </span>
                <a href="{{ route('admin.crm.index') }}" class="btn btn-secondary fw-bold fs-7">
                    <i class="bi bi-arrow-right me-1"></i> العودة لقائمة العملاء
                </a>
            </div>
        </div>
    </div>

    <!-- 1. Customer Main Profile Card -->
    <div class="crm-card">
        <div class="card-body p-4">
            <div class="row align-items-center g-3">
                
                <!-- Avatar & Initials -->
                <div class="col-md-auto col-12 text-center">
                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold mx-auto shadow-sm" 
                         style="width: 86px; height: 86px; font-size: 2.2rem; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
                        {{ mb_substr($user->name ?? 'ع', 0, 1) }}
                    </div>
                </div>

                <!-- Info Details -->
                <div class="col-md col-12 text-center text-md-start">
                    <div class="d-flex flex-wrap align-items-center gap-2 justify-content-center justify-content-md-start mb-1">
                        <h3 class="fw-bold mb-0 text-dark">{{ $user->name }}</h3>
                        <span class="badge badge-subtle-primary py-1 px-2.5 rounded-pill fw-bold">
                            {{ $user->customerProfile?->segment_label ?? ($user->profile?->segment_label ?? 'ولي أمر') }}
                        </span>
                        @if($user->role)
                            <span class="badge bg-secondary-subtle text-secondary py-1 px-2 rounded-pill font-monospace">
                                {{ $user->role }}
                            </span>
                        @endif
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-3 text-muted justify-content-center justify-content-md-start mb-2 fs-7">
                        @if($user->email)
                            <span><i class="bi bi-envelope me-1 text-primary"></i>{{ $user->email }}</span>
                        @endif
                        @if($user->phone)
                            <span><i class="bi bi-telephone me-1 text-success"></i><span dir="ltr">{{ $user->phone }}</span></span>
                        @endif
                        <span><i class="bi bi-calendar-check me-1 text-secondary"></i>تاريخ التسجيل: {{ $user->created_at?->format('Y/m/d') ?? '--' }}</span>
                    </div>

                    <!-- Direct Communication Buttons -->
                    <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                        @php
                            $phoneRaw = $user->phone ?? '';
                            $cleanPhone = preg_replace('/[^0-9]/', '', $phoneRaw);
                            if (str_starts_with($cleanPhone, '01')) {
                                $cleanPhone = '20' . substr($cleanPhone, 1);
                            }
                        @endphp

                        @if(!empty($cleanPhone))
                            <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="btn btn-sm btn-success rounded-pill px-3 fw-bold d-flex align-items-center gap-1.5 shadow-xs">
                                <i class="bi bi-whatsapp"></i>
                                <span>محادثة واتساب</span>
                            </a>
                            <a href="tel:{{ $phoneRaw }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold d-flex align-items-center gap-1.5">
                                <i class="bi bi-telephone-outbound"></i>
                                <span>اتصال هاتفي</span>
                            </a>
                        @endif

                        @if(!empty($user->email))
                            <a href="mailto:{{ $user->email }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold d-flex align-items-center gap-1.5">
                                <i class="bi bi-envelope-at"></i>
                                <span>إرسال بريد</span>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Quick Segment Update Form -->
                <div class="col-md-auto col-12 text-center border-start-md ps-md-4 pt-3 pt-md-0">
                    <form action="{{ route('admin.crm.updateSegment', $user->id) }}" method="POST" class="d-flex flex-column align-items-center align-items-md-end gap-2">
                        @csrf
                        <label class="form-label fs-8 text-muted fw-bold mb-0">تغيير شريحة العميل (CRM)</label>
                        <div class="d-flex gap-1.5">
                            <select name="segment" class="form-select form-select-sm" style="min-width: 160px;">
                                @php
                                    $currentSegment = $user->customerProfile?->segment ?? ($user->profile?->segment ?? 'parent');
                                @endphp
                                @foreach(\App\Models\CustomerProfile::$segments as $key => $label)
                                    <option value="{{ $key }}" {{ $currentSegment === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary fw-bold px-2.5">
                                حفظ
                            </button>
                        </div>
                        @if($user->profile?->last_contacted_at)
                            <small class="text-muted fs-8">
                                آخر تواصل: {{ $user->profile->last_contacted_at->diffForHumans() }}
                            </small>
                        @endif
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- 2. KPIs Counters Strip -->
    <div class="row g-3 mb-4">
        
        <!-- Bookings KPI -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="crm-stat-card">
                <div class="crm-stat-icon" style="background: #e0f2fe; color: #0284c7;">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0 text-dark">{{ $bookings->count() }}</h3>
                    <div class="text-muted fs-7">حجوزات الاستشارات والجلسات</div>
                </div>
            </div>
        </div>

        <!-- Orders KPI -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="crm-stat-card">
                <div class="crm-stat-icon" style="background: #dcfce7; color: #16a34a;">
                    <i class="bi bi-bag-check"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0 text-dark">{{ $orders->count() }}</h3>
                    <div class="text-muted fs-7">طلبات شراء من المتجر</div>
                </div>
            </div>
        </div>

        <!-- Total Spend KPI -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="crm-stat-card">
                <div class="crm-stat-icon" style="background: #fef3c7; color: #d97706;">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    @php
                        $totalPaidOrders = $orders->where('payment_status', 'paid')->sum('total');
                        $totalBookingsPrice = $bookings->where('payment_status', 'paid')->sum('price');
                    @endphp
                    <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalPaidOrders + $totalBookingsPrice, 0) }} <small class="fs-8 text-muted">ج.م</small></h3>
                    <div class="text-muted fs-7">إجمالي مدفوعات العميل</div>
                </div>
            </div>
        </div>

        <!-- Digital Downloads KPI -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="crm-stat-card">
                <div class="crm-stat-icon" style="background: #f3e8ff; color: #9333ea;">
                    <i class="bi bi-file-earmark-arrow-down"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0 text-dark">{{ $downloads->count() }}</h3>
                    <div class="text-muted fs-7">تراخيص الشيتات والملفات</div>
                </div>
            </div>
        </div>

    </div>

    <!-- 3. Comprehensive Tabs Section (Bookings, Orders, Downloads, Contact Logs) -->
    <div class="crm-card">
        <div class="card-header bg-white border-bottom p-0">
            <ul class="nav nav-tabs px-3" id="crmTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active d-flex align-items-center gap-1.5" id="bookings-tab" data-bs-toggle="tab" data-bs-target="#tab-bookings" type="button" role="tab">
                        <i class="bi bi-calendar2-week text-primary"></i>
                        <span>حجوزات الاستشارات والجلسات</span>
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-2 py-0.5 fs-8">{{ $bookings->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link d-flex align-items-center gap-1.5" id="orders-tab" data-bs-toggle="tab" data-bs-target="#tab-orders" type="button" role="tab">
                        <i class="bi bi-bag-check text-success"></i>
                        <span>طلبات الشراء من المتجر</span>
                        <span class="badge bg-success-subtle text-success rounded-pill px-2 py-0.5 fs-8">{{ $orders->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link d-flex align-items-center gap-1.5" id="downloads-tab" data-bs-toggle="tab" data-bs-target="#tab-downloads" type="button" role="tab">
                        <i class="bi bi-file-earmark-pdf text-info"></i>
                        <span>الشيتات والتراخيص الرقمية</span>
                        <span class="badge bg-info-subtle text-info rounded-pill px-2 py-0.5 fs-8">{{ $downloads->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link d-flex align-items-center gap-1.5" id="notes-tab" data-bs-toggle="tab" data-bs-target="#tab-notes" type="button" role="tab">
                        <i class="bi bi-chat-square-text text-warning"></i>
                        <span>سجل التواصل والملاحظات (CRM)</span>
                        <span class="badge bg-warning-subtle text-warning rounded-pill px-2 py-0.5 fs-8">{{ $crmLogs->count() }}</span>
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4">
            <div class="tab-content" id="crmTabsContent">

                <!-- TAB 1: CONSULTATION BOOKINGS -->
                <div class="tab-pane fade show active" id="tab-bookings" role="tabpanel" aria-labelledby="bookings-tab">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-journal-medical me-2 text-primary"></i>جلسات واستشارات العميل</h5>
                        @if(Route::has('admin.bookings.create'))
                            <a href="{{ route('admin.bookings.create') }}" class="btn btn-sm btn-outline-primary fw-bold rounded-pill">
                                <i class="bi bi-plus-circle me-1"></i> حجز جلسة جديدة
                            </a>
                        @endif
                    </div>

                    @if($bookings->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light fs-7">
                                    <tr>
                                        <th class="ps-3">رقم الحجز</th>
                                        <th>نوع الخدمة والاستشارة</th>
                                        <th>الفرع والصيغة</th>
                                        <th>الطفل / العمر</th>
                                        <th>التاريخ والموعد</th>
                                        <th>السعر والدفع</th>
                                        <th>الحالة</th>
                                        <th class="pe-3 text-end">إجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td class="ps-3 fw-bold text-primary">
                                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-decoration-none">
                                                    #{{ $booking->booking_number }}
                                                </a>
                                            </td>
                                            <td class="fw-semibold">
                                                {{ $booking->service_type_label }}
                                            </td>
                                            <td>
                                                <div class="fs-7 text-dark">{{ $booking->branch_label }}</div>
                                                <small class="badge bg-light text-muted border">{{ $booking->session_format_label }}</small>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-dark">{{ $booking->child_name ?: 'غير محدد' }}</span>
                                                @if($booking->child_age)
                                                    <span class="text-muted fs-8">({{ $booking->child_age }} سنة)</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-bold fs-7">{{ $booking->booking_date?->format('Y/m/d') }}</div>
                                                <small class="text-muted fs-8"><i class="bi bi-clock me-1"></i>{{ $booking->booking_time }}</small>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark">{{ number_format($booking->price, 0) }} ج.م</div>
                                                @if($booking->payment_status === 'paid')
                                                    <span class="badge badge-subtle-success fs-8">مدفوع</span>
                                                @elseif($booking->payment_status === 'pending')
                                                    <span class="badge badge-subtle-warning fs-8">معلق</span>
                                                @else
                                                    <span class="badge bg-light text-muted border fs-8">{{ $booking->payment_status_label }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($booking->status === 'confirmed')
                                                    <span class="badge bg-success">مؤكد</span>
                                                @elseif($booking->status === 'completed')
                                                    <span class="badge bg-primary">مكتمل</span>
                                                @elseif($booking->status === 'cancelled')
                                                    <span class="badge bg-danger">ملغي</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">قيد الانتظار</span>
                                                @endif
                                            </td>
                                            <td class="pe-3 text-end">
                                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-primary fw-bold px-2.5 py-1" style="font-size: 0.8rem;">
                                                    <i class="bi bi-eye me-1"></i> التفاصيل
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted border rounded-3 bg-light">
                            <i class="bi bi-calendar-x fs-1 d-block mb-2 text-secondary"></i>
                            <h6 class="fw-bold">لا يوجد حجوزات استشارات مسجلة للعميل حتى الآن</h6>
                            <p class="fs-7 text-muted mb-0">يمكنك تسجيل موعد جديد للعميل عبر قسم الحجوزات أو عندما يقوم بالحجز عبر الموقع.</p>
                        </div>
                    @endif
                </div>

                <!-- TAB 2: STORE ORDERS -->
                <div class="tab-pane fade" id="tab-orders" role="tabpanel" aria-labelledby="orders-tab">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-cart3 me-2 text-success"></i>سجل طلبات الشراء من المتجر</h5>
                        <span class="badge bg-light text-dark border px-3 py-1.5">إجمالي الطلبات: {{ $orders->count() }}</span>
                    </div>

                    @if($orders->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light fs-7">
                                    <tr>
                                        <th class="ps-3">رقم الطلب</th>
                                        <th>تاريخ الشراء</th>
                                        <th>المنتجات والعناصر</th>
                                        <th>حالة الطلب</th>
                                        <th>حالة الدفع</th>
                                        <th>الإجمالي</th>
                                        <th class="pe-3 text-end">إجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="ps-3 fw-bold text-primary">
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-decoration-none">
                                                    #{{ $order->order_number }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="fw-bold fs-7">{{ $order->created_at?->format('Y/m/d') }}</div>
                                                <small class="text-muted fs-8">{{ $order->created_at?->diffForHumans() }}</small>
                                            </td>
                                            <td>
                                                @if($order->orderProducts && $order->orderProducts->isNotEmpty())
                                                    <div class="fs-7 text-dark fw-medium">
                                                        {{ $order->orderProducts->first()->product->name ?? 'منتج' }}
                                                        @if($order->orderProducts->count() > 1)
                                                            <span class="badge bg-light text-muted border">+{{ $order->orderProducts->count() - 1 }} منتجات أخرى</span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-muted fs-8">طلب متجر</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($order->status === 'delivered')
                                                    <span class="badge bg-success">تم التوصيل</span>
                                                @elseif($order->status === 'shipped')
                                                    <span class="badge bg-info">تم الشحن</span>
                                                @elseif($order->status === 'cancelled')
                                                    <span class="badge bg-danger">ملغي</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">تحت الإجراء</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($order->payment_status === 'paid')
                                                    <span class="badge badge-subtle-success fs-8">مدفوع</span>
                                                @else
                                                    <span class="badge badge-subtle-warning fs-8">معلق</span>
                                                @endif
                                            </td>
                                            <td class="fw-bold text-dark">
                                                {{ number_format($order->total, 2) }} ج.م
                                            </td>
                                            <td class="pe-3 text-end">
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary fw-bold px-2.5 py-1" style="font-size: 0.8rem;">
                                                    <i class="bi bi-eye me-1"></i> عرض الطلب
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted border rounded-3 bg-light">
                            <i class="bi bi-cart-x fs-1 d-block mb-2 text-secondary"></i>
                            <h6 class="fw-bold">لم يقم العميل بأي عمليات شراء منتجات حتى الآن</h6>
                        </div>
                    @endif
                </div>

                <!-- TAB 3: DIGITAL DOWNLOADS -->
                <div class="tab-pane fade" id="tab-downloads" role="tabpanel" aria-labelledby="downloads-tab">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-file-earmark-pdf me-2 text-info"></i>تراخيص تحميل الشيتات والملفات الرقمية</h5>
                        <span class="badge bg-light text-dark border px-3 py-1.5">عدد التراخيص: {{ $downloads->count() }}</span>
                    </div>

                    @if($downloads->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light fs-7">
                                    <tr>
                                        <th class="ps-3">الملف / الشيت الرقمي</th>
                                        <th class="text-center">مرات التحميل</th>
                                        <th>الصلاحية</th>
                                        <th class="pe-3 text-end">إجراءات تمديد وتحكم</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($downloads as $download)
                                        <tr>
                                            <td class="ps-3 fw-bold text-dark">
                                                {{ $download->product->name ?? 'شيت تدريبي رقمي' }}
                                                <small class="d-block text-muted font-monospace fs-8">رمز التحقق: {{ mb_substr($download->token, 0, 10) }}...</small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-1 fw-bold fs-7">
                                                    {{ $download->download_count }} / {{ $download->max_downloads ?? 'بلا حد' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($download->expires_at)
                                                    @if($download->expires_at->isPast())
                                                        <span class="badge badge-subtle-danger"><i class="bi bi-x-circle me-1"></i>منتهي ({{ $download->expires_at->format('Y/m/d') }})</span>
                                                    @else
                                                        <span class="badge badge-subtle-success"><i class="bi bi-check2-circle me-1"></i>صالح حتى {{ $download->expires_at->format('Y/m/d') }}</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-light text-dark border">مفتوح الصلاحية</span>
                                                @endif
                                            </td>
                                            <td class="pe-3 text-end">
                                                <form action="{{ route('admin.crm.resetDownload', ['user' => $user->id, 'download' => $download->id]) }}" method="POST" class="d-inline-flex gap-1">
                                                    @csrf
                                                    <button type="submit" name="action" value="reset_count" class="btn btn-sm btn-outline-warning py-1 px-2 fs-8 fw-bold" title="تصفير عداد التحميل">
                                                        <i class="bi bi-arrow-clockwise"></i> تصفير
                                                    </button>
                                                    <button type="submit" name="action" value="add_downloads" class="btn btn-sm btn-outline-info py-1 px-2 fs-8 fw-bold" title="إضافة +5 مرات تحميل">
                                                        <i class="bi bi-plus-lg"></i> +5 تحميلات
                                                    </button>
                                                    <button type="submit" name="action" value="extend_time" class="btn btn-sm btn-outline-success py-1 px-2 fs-8 fw-bold" title="تمديد الصلاحية 30 يوماً">
                                                        <i class="bi bi-calendar-plus"></i> +30 يوم
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted border rounded-3 bg-light">
                            <i class="bi bi-file-earmark-lock fs-1 d-block mb-2 text-secondary"></i>
                            <h6 class="fw-bold">لا يمتلك العميل أي تراخيص شيتات رقمية حالياً</h6>
                        </div>
                    @endif
                </div>

                <!-- TAB 4: CRM NOTES & TIMELINE -->
                <div class="tab-pane fade" id="tab-notes" role="tabpanel" aria-labelledby="notes-tab">
                    <div class="row g-4">
                        
                        <!-- Add Note Form -->
                        <div class="col-lg-5 col-12">
                            <div class="card border border-light-subtle rounded-3 p-3 bg-light">
                                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-pencil-square me-2 text-primary"></i>تسجيل ملاحظة أو اتصال جديد</h6>
                                <form action="{{ route('admin.crm.storeNote', $user->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label fs-7 fw-bold">وسيلة التواصل</label>
                                        <select name="type" class="form-select form-select-sm" required>
                                            <option value="note">ملاحظة سريعة</option>
                                            <option value="call">مكالمة تليفونية مع العميل</option>
                                            <option value="whatsapp">محادثة واتساب</option>
                                            <option value="email">إرسال بريد إلكتروني</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fs-7 fw-bold">التفاصيل والملخص</label>
                                        <textarea name="details" class="form-control form-control-sm" rows="4" placeholder="اكتب تفاصيل الاتصال، متطلبات العميل، حالة الطفل، أو أي ملاحظة مهمة..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm fw-bold w-100 py-2">
                                        <i class="bi bi-plus-circle me-1"></i> حفظ الملاحظة في السجل
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Timeline History -->
                        <div class="col-lg-7 col-12">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-clock-history me-2 text-secondary"></i>سجل التفاعل والتواصل التاريخي</h6>
                            @if($crmLogs->isNotEmpty())
                                <ul class="crm-timeline">
                                    @foreach($crmLogs as $log)
                                        <li class="crm-timeline-item">
                                            @php
                                                $badgeClass = match($log->type) {
                                                    'call' => 'bg-call',
                                                    'whatsapp' => 'bg-whatsapp',
                                                    'email' => 'bg-email',
                                                    'system' => 'bg-system',
                                                    default => 'bg-note'
                                                };
                                                $iconClass = match($log->type) {
                                                    'call' => 'bi-telephone',
                                                    'whatsapp' => 'bi-whatsapp',
                                                    'email' => 'bi-envelope',
                                                    'system' => 'bi-gear',
                                                    default => 'bi-pencil'
                                                };
                                            @endphp
                                            <div class="crm-timeline-badge {{ $badgeClass }}">
                                                <i class="bi {{ $iconClass }}"></i>
                                            </div>
                                            <div class="crm-timeline-content">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="badge bg-secondary-subtle text-secondary fw-bold fs-8">
                                                        {{ $log->type_label }}
                                                    </span>
                                                    <small class="text-muted fs-8">{{ $log->created_at?->diffForHumans() }}</small>
                                                </div>
                                                <p class="mb-2 fs-7 text-dark">{{ $log->details }}</p>
                                                <div class="text-end">
                                                    <small class="text-muted fs-8">
                                                        <i class="bi bi-person me-1"></i>بواسطة: {{ $log->admin->name ?? 'النظام التلقائي' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center py-5 text-muted border rounded-3 bg-light">
                                    <i class="bi bi-chat-left-dots fs-1 d-block mb-2 text-secondary"></i>
                                    <h6 class="fw-bold">لا يوجد سجل تواصل مسجل للعميل حتى الآن</h6>
                                    <p class="fs-7 text-muted mb-0">يمكنك تسجيل أول ملاحظة أو مكالمة عبر النموذج الجانبي.</p>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
