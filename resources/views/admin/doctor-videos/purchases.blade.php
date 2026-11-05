@extends('admin.layouts.layout')

@section('title', 'سجل مبيعات واشتراكات الشروحات | شروحات الدكتور')

@section('content')
<div class="container-fluid p-0">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1 text-dark d-flex align-items-center gap-2">
                <i class="bi bi-wallet2 text-primary"></i>
                <span>سجل مبيعات واشتراكات شروحات الدكتور المدفوعة</span>
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 fs-8">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.doctor-videos.index') }}">شروحات الدكتور</a></li>
                    <li class="breadcrumb-item active" aria-current="page">سجل المبيعات</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.doctor-videos.index') }}" class="btn btn-outline-secondary rounded-3 fs-7 fw-bold">
                <i class="bi bi-arrow-right me-1"></i> العودة لقائمة الفيديوهات
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-7 fw-bold">إجمالي إيرادات مبيعات الشروحات</span>
                        <h2 class="fw-black text-success mb-0 mt-1">{{ number_format($totalRevenue, 2) }} <small class="fs-6 text-muted">ج.م</small></h2>
                    </div>
                    <span class="p-3 rounded-4 bg-success bg-opacity-10 text-success">
                        <i class="bi bi-cash-stack fs-2"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-7 fw-bold">إجمالي أولياء الأمور المشتركين</span>
                        <h2 class="fw-black text-primary mb-0 mt-1">{{ number_format($totalSubscribers) }} <small class="fs-6 text-muted">مشترك</small></h2>
                    </div>
                    <span class="p-3 rounded-4 bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-people-fill fs-2"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Purchases Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-0">
            <h6 class="fw-bold mb-0 text-dark">
                <span>كافة عمليات شراء واشتراك الفيديوهات</span>
                <span class="badge bg-light text-primary rounded-pill px-2.5 py-1 ms-2">{{ $purchases->total() }} عملية</span>
            </h6>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted fs-7 text-nowrap">
                    <tr>
                        <th class="ps-4">المشتري (ولي الأمر)</th>
                        <th>الشرح / الفيديو المشترى</th>
                        <th>المبلغ المدفوع</th>
                        <th>رقم الطلب / المرجع</th>
                        <th>تاريخ الشراء</th>
                        <th class="text-end pe-4">الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchases as $item)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark fs-7">{{ $item->user_name }}</div>
                                <div class="text-muted fs-8 font-monospace">{{ $item->user_phone ?? $item->user_email }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark fs-7 text-truncate" style="max-width: 320px;">
                                    {{ $item->video_title }}
                                </div>
                            </td>
                            <td>
                                <span class="fw-black text-success fs-7">{{ number_format((float)($item->price_paid ?? 0), 2) }} ج.م</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark font-monospace px-2 py-1 fs-8">
                                    {{ $item->order_number ?? '#' . $item->order_id ?? 'مباشر' }}
                                </span>
                            </td>
                            <td class="text-muted fs-8 font-monospace">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:i') }}
                            </td>
                            <td class="text-end pe-4">
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1 fs-8 fw-bold">
                                    <i class="bi bi-check-circle-fill me-1"></i> مفعّل مدى الحياة
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-wallet2 display-4 text-muted text-opacity-50 mb-3 d-block"></i>
                                <h5>لا توجد مشتريات مسجلة حتى الآن</h5>
                                <p class="fs-7 text-muted">بمجرد قيام أولياء الأمور بشراء الفيديوهات المدفوعة، ستظهر بياناتهم ومبالغ الدفع هنا تلقائياً.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($purchases->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $purchases->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
