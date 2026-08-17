@extends('admin.layouts.layout')

@section('title', 'ملف العميل: ' . $user->name . ' | لوحة التحكم')

@section('styles')
<style>
    /* Custom CRM Timeline Styling */
    .timeline {
        position: relative;
        padding-right: 20px;
        list-style: none;
        margin: 0;
    }
    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        right: 9px;
        width: 2px;
        background-color: #e2e8f0;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 24px;
    }
    .timeline-badge {
        position: absolute;
        top: 3px;
        right: -20px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #cbd5e1;
        border: 4px solid #ffffff;
        z-index: 1;
    }
    .timeline-badge.bg-call { background-color: #0ea5e9; }
    .timeline-badge.bg-whatsapp { background-color: #22c55e; }
    .timeline-badge.bg-email { background-color: #6366f1; }
    .timeline-badge.bg-system { background-color: #64748b; }
    .timeline-badge.bg-note { background-color: #f59e0b; }

    .timeline-card {
        margin-right: 15px;
        border: 1px solid #f1f5f9;
        background-color: #f8fafc;
        border-radius: 8px;
    }

    [data-bs-theme="dark"] .timeline::before {
        background-color: #4b5563;
    }
    [data-bs-theme="dark"] .timeline-card {
        border-color: #374151;
        background-color: #1f2937;
    }
    [data-bs-theme="dark"] .timeline-badge {
        border-color: #111827;
    }
</style>
@endsection

@section('content')
<div class="container-fluid p-0">
    <!-- Breadcrumbs -->
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold mb-1">ملف العميل الشامل</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.crm.index') }}">إدارة العملاء CRM</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Customer Profile Header Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center g-3">
                <div class="col-md-auto col-sm-12 text-center">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold mx-auto" style="width: 80px; height: 80px; font-size: 2.2rem;">
                        {{ mb_substr($user->name, 0, 1) }}
                    </div>
                </div>
                <div class="col-md col-sm-12 text-center text-md-start">
                    <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-2"><i class="bi bi-envelope me-1"></i>{{ $user->email }}</p>
                    <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2">
                        <span class="badge bg-primary-subtle text-primary py-2 px-3 fw-semibold">
                            شريحة العميل: {{ $user->profile->segment_label }}
                        </span>
                        <span class="badge bg-secondary-subtle text-secondary py-2 px-3 fw-semibold">
                            تاريخ التسجيل: {{ $user->created_at->format('Y/m/d') }}
                        </span>
                    </div>
                </div>
                
                <!-- Quick edit segment -->
                <div class="col-md-auto col-sm-12 text-center">
                    <form action="{{ route('admin.crm.updateSegment', $user->id) }}" method="POST" class="d-flex align-items-center justify-content-center gap-2">
                        @csrf
                        <select name="segment" class="form-select form-select-sm" style="width: 170px;">
                            @foreach(\App\Models\CustomerProfile::$segments as $key => $label)
                                <option value="{{ $key }}" {{ $user->profile->segment === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary fw-bold">تحديث الشريحة</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column: Notes & Timeline -->
        <div class="col-lg-6 col-md-12 mb-4">
            <!-- Add Note Form -->
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square text-primary me-2"></i>تسجيل تواصل جديد</h5></div>
                <div class="card-body">
                    <form action="{{ route('admin.crm.storeNote', $user->id) }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6 col-sm-12">
                                <label class="form-label fw-semibold fs-7">قناة التواصل</label>
                                <select name="type" class="form-select" required>
                                    <option value="note">إضافة ملاحظة سريعة</option>
                                    <option value="call">مكالمة تليفونية مع العميل</option>
                                    <option value="whatsapp">محادثة واتساب</option>
                                    <option value="email">إرسال بريد إلكتروني</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold fs-7">تفاصيل الملاحظة / ملخص الاتصال</label>
                                <textarea name="details" class="form-control" rows="3" placeholder="اكتب تفاصيل الاتصال أو حالة العميل الحالية..." required></textarea>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-plus-circle me-1"></i>حفظ السجل</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Notes Timeline -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history text-secondary me-2"></i>سجل الاتصال والتفاعل (CRM)</h5>
                </div>
                <div class="card-body">
                    @if($crmLogs->isNotEmpty())
                        <ul class="timeline">
                            @foreach($crmLogs as $log)
                                <li class="timeline-item">
                                    @php
                                        $badgeBg = match($log->type) {
                                            'call' => 'bg-call',
                                            'whatsapp' => 'bg-whatsapp',
                                            'email' => 'bg-email',
                                            'system' => 'bg-system',
                                            default => 'bg-note'
                                        };
                                    @endphp
                                    <div class="timeline-badge {{ $badgeBg }}"></div>
                                    <div class="card timeline-card">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-secondary-subtle text-secondary fw-semibold">
                                                    {{ $log->type_label }}
                                                </span>
                                                <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-2 fs-7 text-dark-emphasis">{{ $log->details }}</p>
                                            <div class="text-end">
                                                <small class="text-muted fs-8">بواسطة: {{ $log->admin->name ?? 'النظام التلقائي' }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-chat-left-text fs-2 d-block mb-2"></i> لا يوجد سجل تواصل مسجل للعميل بعد.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Orders & Downloads -->
        <div class="col-lg-6 col-md-12 mb-4">
            
            <!-- Digital Downloads Worksheet Access -->
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0 fw-bold"><i class="bi bi-file-earmark-pdf text-success me-2"></i>تراخيص تحميل الشيتات الرقمية للعميل</h5></div>
                <div class="card-body p-0">
                    @if($downloads->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle mb-0 fs-7">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">الملف الرقمي</th>
                                        <th class="text-center">مرات التحميل</th>
                                        <th>تاريخ الصلاحية</th>
                                        <th class="pe-3 text-end">إجراءات الإدارة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($downloads as $download)
                                        <tr>
                                            <td class="ps-3 fw-bold">
                                                {{ $download->product->name ?? 'ملف رقمي غير موجود' }}
                                                <small class="d-block text-muted-50 fw-normal">رمز التوكن: {{ mb_substr($download->token, 0, 8) }}...</small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary rounded-pill">
                                                    {{ $download->download_count }} / {{ $download->max_downloads ?? 'بلا حد' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($download->expires_at)
                                                    @if($download->expires_at->isPast())
                                                        <span class="text-danger fw-semibold" title="{{ $download->expires_at }}"><i class="bi bi-x-circle me-1"></i>منتهي الصلاحية</span>
                                                    @else
                                                        <span class="text-success fw-semibold" title="{{ $download->expires_at }}">{{ $download->expires_at->format('Y/m/d') }}</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">مفتوح الصلاحية</span>
                                                @endif
                                            </td>
                                            <td class="pe-3 text-end">
                                                <!-- Action Buttons Form -->
                                                <form action="{{ route('admin.crm.resetDownload', ['user' => $user->id, 'download' => $download->id]) }}" method="POST" class="d-inline-flex gap-1">
                                                    @csrf
                                                    <button type="submit" name="action" value="reset_count" class="btn btn-xs btn-outline-warning" title="تصفير عدد التحميلات">
                                                        <i class="bi bi-arrow-clockwise"></i> تصفير
                                                    </button>
                                                    <button type="submit" name="action" value="add_downloads" class="btn btn-xs btn-outline-info" title="إضافة +5 مرات تحميل">
                                                        <i class="bi bi-plus-lg"></i> +5 تحميلات
                                                    </button>
                                                    <button type="submit" name="action" value="extend_time" class="btn btn-xs btn-outline-success" title="تمديد الصلاحية 30 يوماً">
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
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-file-earmark-lock fs-2 d-block mb-2"></i> لا يمتلك العميل أي تراخيص تحميل شيتات رقمية حالياً.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Customer Orders History -->
            <div class="card">
                <div class="card-header"><h5 class="mb-0 fw-bold"><i class="bi bi-cart3 text-info me-2"></i>سجل طلبات الشراء للعميل</h5></div>
                <div class="card-body p-0">
                    @if($orders->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle mb-0 fs-7">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">رقم الطلب</th>
                                        <th>تاريخ الشراء</th>
                                        <th>حالة الطلب</th>
                                        <th>حالة الدفع</th>
                                        <th class="pe-3 text-end">القيمة الإجمالية</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="ps-3 fw-bold text-primary">#{{ $order->order_number }}</td>
                                            <td>{{ $order->created_at->format('Y/m/d') }}</td>
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
                                                    <span class="badge bg-success-subtle text-success">مدفوع</span>
                                                @else
                                                    <span class="badge bg-warning-subtle text-warning">معلق</span>
                                                @endif
                                            </td>
                                            <td class="pe-3 text-end fw-bold">
                                                {{ number_format($order->total, 2) }} ج.م
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-cart-x fs-2 d-block mb-2"></i> لم يقم العميل بأي عمليات شراء سابقة بعد.
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
