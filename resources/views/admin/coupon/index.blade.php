@extends('admin.layouts.layout')

@section('title', 'أكواد الخصم والبروموكود | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">
    
    <!-- Page Header & Actions -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-ticket-perforated-fill text-primary me-2"></i> إدارة أكواد الخصم والبروموكود
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">أكواد الخصم</li>
                    </ol>
                </nav>
            </div>
            
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.discounts.index') }}" class="btn btn-outline-danger fw-semibold d-inline-flex align-items-center gap-1.5 shadow-xs">
                    <i class="bi bi-percent fs-6"></i>
                    <span>العروض والخصومات الجماعية</span>
                </a>
                <a href="{{ route('admin.coupon.create') }}" class="btn btn-primary fw-bold d-inline-flex align-items-center gap-1.5 shadow-sm">
                    <i class="bi bi-plus-circle fs-6"></i>
                    <span>إنشاء كود خصم جديد</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-xs mb-4 d-flex align-items-center justify-content-between" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                <span class="fw-semibold">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-xs mb-4 d-flex align-items-center justify-content-between" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
                <span class="fw-semibold">{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- KPI Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-xs rounded-3 p-3 h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fw-semibold small">إجمالي الكوبونات</span>
                    <div class="w-10 h-10 rounded-2 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="bi bi-ticket-perforated fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-black mb-0 text-dark">{{ $stats['total'] ?? $coupons->total() }}</h3>
                <span class="text-muted small mt-1">كود مسجل بالمنظومة</span>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-xs rounded-3 p-3 h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fw-semibold small">الكوبونات النشطة</span>
                    <div class="w-10 h-10 rounded-2 bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="bi bi-check2-circle fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-black mb-0 text-success">{{ $stats['active'] ?? 0 }}</h3>
                <span class="text-muted small mt-1">جاهزة للاستخدام بالسلة</span>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-xs rounded-3 p-3 h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fw-semibold small">مرات الاستخدام</span>
                    <div class="w-10 h-10 rounded-2 bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="bi bi-bag-check fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-black mb-0 text-dark">{{ $stats['total_used'] ?? 0 }}</h3>
                <span class="text-muted small mt-1">طلب استخدم البروموكود</span>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-xs rounded-3 p-3 h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fw-semibold small">إجمالي التوفير للعملاء</span>
                    <div class="w-10 h-10 rounded-2 bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="bi bi-cash-coin fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-black mb-0 text-primary">{{ number_format($stats['total_savings'] ?? 0, 2) }} <small class="fs-6 font-monospace">ج.م</small></h3>
                <span class="text-muted small mt-1">خصومات مستفادة بالطلبات</span>
            </div>
        </div>
    </div>

    <!-- Coupons Data Table Card -->
    <div class="card border-0 shadow-xs rounded-3 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-bottom border-light-subtle d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-2">
                <h5 class="fw-bold mb-0 text-dark">قائمة أكواد الخصم</h5>
                <span class="badge bg-light text-muted border px-2 py-1 fs-8">{{ $coupons->total() }} كود</span>
            </div>

            <!-- Quick Table Search Input -->
            <div style="min-width: 250px;">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="couponSearchInput" onkeyup="filterCouponsTable()" class="form-control bg-light border-start-0" placeholder="بحث باسم أو رمز الكود...">
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="couponsTable">
                    <thead class="table-light text-muted small">
                        <tr>
                            <th class="ps-4">رمز الكود</th>
                            <th>نوع وقيمة الخصم</th>
                            <th>نطاق السريان</th>
                            <th>الحد الأدنى للطلب</th>
                            <th>فترة الصلاحية</th>
                            <th>مرات الاستخدام</th>
                            <th>الحالة</th>
                            <th class="text-center pe-4">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($coupons as $coupon)
                            @php
                                $isPercentage = in_array(strtolower($coupon->discount_type ?? $coupon->type?->value ?? ''), ['percentage', 'percent']);
                                $isValid = $coupon->isValidNow();
                            @endphp
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1.5 fw-bold font-monospace fs-6">
                                            {{ $coupon->code }}
                                        </span>
                                        <button type="button" class="btn btn-sm btn-light border p-1 text-muted" title="نسخ الكود" onclick="copyCouponCode('{{ $coupon->code }}', this)">
                                            <i class="bi bi-copy"></i>
                                        </button>
                                    </div>
                                </td>

                                <td>
                                    @if ($isPercentage)
                                        <div class="d-flex flex-column">
                                            <span class="fw-black text-danger fs-6">{{ (float)$coupon->discount }}% خصم</span>
                                            @if($coupon->max_discount_amount)
                                                <small class="text-muted fs-8">أقصى خصم: {{ number_format($coupon->max_discount_amount, 2) }} ج.م</small>
                                            @endif
                                        </div>
                                    @else
                                        <div class="d-flex flex-column">
                                            <span class="fw-black text-success fs-6">{{ number_format($coupon->discount, 2) }} ج.م</span>
                                            <small class="text-muted fs-8">مبلغ ثابت مخصوم</small>
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    @if($coupon->applies_to === 'category')
                                        <span class="badge bg-warning-subtle text-dark border border-warning-subtle px-2 py-1">
                                            <i class="bi bi-folder2 me-1"></i> فئات محددة ({{ $coupon->categories->count() }})
                                        </span>
                                    @elseif($coupon->applies_to === 'product')
                                        <span class="badge bg-info-subtle text-dark border border-info-subtle px-2 py-1">
                                            <i class="bi bi-box me-1"></i> منتجات مختارة ({{ $coupon->products->count() }})
                                        </span>
                                    @else
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                            <i class="bi bi-globe me-1"></i> شامل كل المتجر
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($coupon->min_order_amount > 0)
                                        <span class="fw-bold text-dark">{{ number_format($coupon->min_order_amount, 2) }} ج.م</span>
                                    @else
                                        <span class="text-muted small">بدون حد أدنى</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex flex-column small">
                                        @if($coupon->start_date && $coupon->expired_date)
                                            <span class="text-dark font-monospace">{{ $coupon->start_date->format('Y-m-d') }} &larr; {{ $coupon->expired_date->format('Y-m-d') }}</span>
                                        @elseif($coupon->expired_date)
                                            <span class="text-dark font-monospace">ينتهي: {{ $coupon->expired_date->format('Y-m-d') }}</span>
                                        @else
                                            <span class="text-muted">مستمر وغير محدد المدة</span>
                                        @endif

                                        @if($coupon->expired_date && now()->gt($coupon->expired_date))
                                            <span class="badge bg-danger text-white w-fit px-1.5 py-0.5 rounded-1 mt-0.5 fs-8">منتهي الصلاحية</span>
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex flex-column small">
                                        <span class="fw-bold text-dark">{{ $coupon->total_used }} استخدام</span>
                                        @if($coupon->total_usage_limit)
                                            <small class="text-muted fs-8">الحد: {{ $coupon->total_usage_limit }} مرة</small>
                                        @else
                                            <small class="text-muted fs-8">غير محدود</small>
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <a href="{{ route('admin.coupon.toggle', $coupon->id) }}" class="btn btn-sm {{ $coupon->is_active ? 'btn-success bg-opacity-10 text-success border border-success-subtle' : 'btn-light text-muted border' }} fw-bold px-2 py-1" title="تبديل حالة التفعيل">
                                        <i class="bi {{ $coupon->is_active ? 'bi-check-circle-fill' : 'bi-dash-circle' }} me-1"></i>
                                        {{ $coupon->is_active ? 'نشط' : 'معطل' }}
                                    </a>
                                </td>

                                <td class="text-center pe-4">
                                    <div class="d-flex items-center justify-content-center gap-1.5">
                                        <a href="{{ route('admin.coupon.edit', $coupon->id) }}" class="btn btn-sm btn-outline-primary" title="تعديل الكود">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <button type="button" class="btn btn-sm btn-outline-danger" title="حذف الكود" onclick="confirmDeleteCoupon({{ $coupon->id }}, '{{ $coupon->code }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                        <form id="delete-coupon-{{ $coupon->id }}" action="{{ route('admin.coupon.destroy', $coupon->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center justify-content-center py-4">
                                        <div class="w-16 h-16 rounded-circle bg-light d-flex align-items-center justify-content-center text-muted mb-3" style="width: 60px; height: 60px;">
                                            <i class="bi bi-ticket-perforated fs-1"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">لا توجد أكواد خصم منشأة حالياً</h6>
                                        <p class="text-muted small mb-3">ابدأ بإنشاء أول كود خصم ترويجي لعملائك لزيادة مبيعات المتجر</p>
                                        <a href="{{ route('admin.coupon.create') }}" class="btn btn-primary btn-sm fw-bold px-3">
                                            <i class="bi bi-plus-circle me-1"></i> إنشاء كود خصم الآن
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($coupons->hasPages())
                <div class="card-footer bg-white py-3 px-4 border-top border-light-subtle">
                    {{ $coupons->links() }}
                </div>
            @endif
        </div>
    </div>

</div>

<!-- Delete Confirmation Modal (SweetAlert2 or Native) -->
<script>
function copyCouponCode(code, btn) {
    navigator.clipboard.writeText(code).then(() => {
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check text-success"></i>';
        setTimeout(() => {
            btn.innerHTML = originalHtml;
        }, 1500);
    });
}

function confirmDeleteCoupon(id, code) {
    if (confirm('هل أنت متأكد من رغبتك في حذف كود الخصم [' + code + '] نهائياً؟')) {
        document.getElementById('delete-coupon-' + id).submit();
    }
}

function filterCouponsTable() {
    const input = document.getElementById('couponSearchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('couponsTable');
    const tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {
        const td = tr[i].getElementsByTagName('td')[0];
        if (td) {
            const txtValue = td.textContent || td.innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }
    }
}
</script>
@endsection
