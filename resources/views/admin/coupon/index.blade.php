@extends('layouts.app')
@section('header-title', 'أكواد الخصم والبروموكود')

@section('content')
<div class="container-fluid px-3 py-2">
    <div class="d-flex align-items-center flex-wrap gap-3 justify-content-between mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-dark">
                <i class="bi bi-ticket-perforated-fill text-primary me-2"></i> إدارة أكواد الخصم والبروموكود
            </h3>
            <p class="text-muted small mb-0">إنشاء وتخصيص كوبونات الخصم للمتجر أو لفئات ومنتجات محددة</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.discounts.index') }}" class="btn btn-outline-danger">
                <i class="bi bi-percent me-1"></i> العروض والخصومات الجماعية
            </a>
            <a href="{{ route('admin.coupon.create') }}" class="btn btn-primary px-3">
                <i class="bi bi-plus-circle me-1"></i> إنشاء كود خصم جديد
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-xs border-0 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-xs rounded-16">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted small">
                        <tr>
                            <th class="ps-4">رمز الكود</th>
                            <th>نوع الخصم</th>
                            <th>قيمة الخصم</th>
                            <th>الشمولية</th>
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
                            @endphp
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded px-2.5 py-1.5 fw-bold font-monospace fs-6 border border-primary border-opacity-20">
                                            {{ $coupon->code }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($isPercentage)
                                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-20 px-2 py-1">نسبة مئوية %</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1">مبلغ ثابت</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold text-dark fs-6">
                                        {{ $isPercentage ? $coupon->discount . '%' : number_format($coupon->discount, 2) . ' ج.م' }}
                                    </span>
                                    @if($isPercentage && $coupon->max_discount_amount)
                                        <div class="text-muted small" style="font-size: 11px;">(حد أقصى: {{ number_format($coupon->max_discount_amount, 2) }} ج.م)</div>
                                    @endif
                                </td>
                                <td>
                                    @if($coupon->applies_to === 'category')
                                        <span class="badge bg-warning bg-opacity-15 text-dark border border-warning" title="{{ $coupon->categories->pluck('name')->implode(', ') }}">
                                            فئات معينة ({{ $coupon->categories->count() }})
                                        </span>
                                    @elseif($coupon->applies_to === 'product')
                                        <span class="badge bg-purple bg-opacity-15 text-purple border" title="{{ $coupon->products->pluck('name')->implode(', ') }}">
                                            منتجات معينة ({{ $coupon->products->count() }})
                                        </span>
                                    @else
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20">
                                            جميع منتجات المتجر
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($coupon->min_order_amount > 0)
                                        {{ number_format($coupon->min_order_amount, 2) }} ج.م
                                    @else
                                        <span class="text-muted">بدون حد أدنى</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="small">
                                        من: {{ $coupon->start_date ? \Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d') : 'فوري' }}<br>
                                        إلى: {{ $coupon->expired_date ? \Carbon\Carbon::parse($coupon->expired_date)->format('Y-m-d') : 'غير محدد' }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $coupon->total_used }}
                                        @if($coupon->total_usage_limit)
                                            / {{ $coupon->total_usage_limit }}
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.coupon.toggle', $coupon->id) }}" class="text-decoration-none">
                                        @if($coupon->is_active)
                                            <span class="badge bg-success px-2 py-1 cursor-pointer">مفعل</span>
                                        @else
                                            <span class="badge bg-secondary px-2 py-1 cursor-pointer">معطل</span>
                                        @endif
                                    </a>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <a href="{{ route('admin.coupon.edit', $coupon->id) }}" class="btn btn-sm btn-outline-secondary" title="تعديل">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.coupon.destroy', $coupon->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف كود الخصم هذا؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="bi bi-ticket-perforated fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                    لا توجد أكواد خصم مضافة حتى الآن.<br>
                                    اضغط على زر "إنشاء كود خصم جديد" بالأعلى لإنشاء أول كود ترويجي.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($coupons->hasPages())
                <div class="p-3 border-top">
                    {{ $coupons->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
