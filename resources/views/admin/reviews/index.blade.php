@extends('admin.layouts.layout')

@section('title', 'إدارة تقييمات العملاء | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-1">إدارة تقييمات العملاء</h4>
                <p class="text-muted mb-0 fs-7">مراجعة التقييمات المستلمة والموافقة على نشرها بالصفحة الرئيسية للمتجر.</p>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.reviews.index') }}" method="GET" class="row g-3">
                <!-- Search Input -->
                <div class="col-lg-5 col-md-12">
                    <label class="form-label fs-8 fw-semibold text-muted">البحث عن تعليق</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-light border-start-0 fs-7" placeholder="اسم العميل، اسم المنتج، محتوى التقييم...">
                    </div>
                </div>

                <!-- Approval Status Filter -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <label class="form-label fs-8 fw-semibold text-muted">حالة النشر والموافقة</label>
                    <select name="status" class="form-select bg-light fs-7">
                        <option value="">كل التقييمات</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>منشورة (موافق عليها)</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>معلقة (مخفية)</option>
                    </select>
                </div>

                <!-- Filter Actions -->
                <div class="col-lg-4 col-md-6 col-sm-12 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold fs-7">تصفية النتائج</button>
                    @if(request()->anyFilled(['search', 'status']))
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-light border w-100 fw-bold fs-7">تصفير الفلتر</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Reviews Table Card -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0 fs-7">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 25%;">المنتج المعني</th>
                            <th style="width: 15%;">العميل</th>
                            <th class="text-center" style="width: 15%;">التقييم</th>
                            <th style="width: 25%;">التعليق</th>
                            <th class="text-center" style="width: 10%;">الحالة</th>
                            <th class="pe-4 text-end" style="width: 10%;">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                            <tr>
                                <td class="ps-4">
                                    @if($review->product)
                                        <a href="{{ route('admin.products.show', $review->product->id) }}" class="fw-bold text-primary text-decoration-none">
                                            {{ $review->product->name }}
                                        </a>
                                        <small class="text-muted d-block fs-8">نوع: {{ $review->product->type === 'digital' ? 'رقمي' : 'مادي' }}</small>
                                    @else
                                        <span class="text-muted">منتج محذوف</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $review->customer_name ?: ($review->user->name ?? 'مجهول') }}</div>
                                    @if($review->is_verified_purchase)
                                        <span class="badge bg-success-subtle text-success fs-9 py-0.5 px-1.5"><i class="bi bi-shield-check me-0.5"></i>شراء موثق</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="text-warning fs-6">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                ★
                                            @else
                                                <span class="text-muted opacity-30">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                    <small class="text-muted fs-8">({{ $review->rating }} من 5)</small>
                                </td>
                                <td>
                                    <p class="mb-0 text-dark-emphasis whitespace-pre-line" style="font-size: 0.85rem; max-width: 300px;">{{ $review->comment }}</p>
                                    <small class="text-muted d-block mt-1 fs-9">{{ $review->created_at->format('Y/m/d h:i A') }}</small>
                                </td>
                                <td class="text-center">
                                    @if($review->is_approved)
                                        <span class="badge bg-success-subtle text-success"><i class="bi bi-eye-fill me-1"></i>منشور بالمتجر</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger"><i class="bi bi-eye-slash-fill me-1"></i>مخفي</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-inline-flex gap-1">
                                        <!-- Toggle approval form -->
                                        <form action="{{ route('admin.reviews.toggleApprove', $review->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @if($review->is_approved)
                                                <button type="submit" class="btn btn-xs btn-outline-warning" title="حجب التقييم">
                                                    حجب
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-xs btn-outline-success" title="نشر التقييم">
                                                    نشر
                                                </button>
                                            @endif
                                        </form>

                                        <!-- Delete form -->
                                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا التقييم بشكل نهائي؟');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-outline-danger" title="حذف نهائي">
                                                حذف
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-star-fill fs-1 d-block mb-3 opacity-30"></i> لا توجد تقييمات عملاء مستلمة حالياً.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($reviews->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
