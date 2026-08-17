@extends('admin.layouts.layout')

@section('title', 'إدارة المنتجات | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-1">إدارة منتجات المتجر</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">المنتجات</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary fw-bold">
                    <i class="bi bi-plus-circle me-1"></i> إضافة منتج جديد
                </a>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3 align-items-end">
                <!-- Search text -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <label class="form-label fw-semibold fs-7">البحث عن منتج</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="الاسم أو رمز SKU..." value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Category -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <label class="form-label fw-semibold fs-7">تصنيف المتجر</label>
                    <select name="category" class="form-select">
                        <option value="">كل التصنيفات</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Product Type -->
                <div class="col-lg-2 col-md-6 col-sm-12">
                    <label class="form-label fw-semibold fs-7">نوع المنتج</label>
                    <select name="type" class="form-select">
                        <option value="">كل الأنواع</option>
                        <option value="physical" {{ request('type') === 'physical' ? 'selected' : '' }}>أداة مادية (شحن)</option>
                        <option value="digital" {{ request('type') === 'digital' ? 'selected' : '' }}>ملف رقمي (تحميل فوري)</option>
                        <option value="course" {{ request('type') === 'course' ? 'selected' : '' }}>كورس تعليمي</option>
                        <option value="session" {{ request('type') === 'session' ? 'selected' : '' }}>جلسة استشارية</option>
                    </select>
                </div>

                <!-- Status -->
                <div class="col-lg-2 col-md-6 col-sm-12">
                    <label class="form-label fw-semibold fs-7">حالة الظهور</label>
                    <select name="status" class="form-select">
                        <option value="">الكل</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>نشط (ظاهر)</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>معطل (مخفي)</option>
                    </select>
                </div>

                <!-- Filter Actions -->
                <div class="col-lg-2 col-md-6 col-sm-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2"><i class="bi bi-funnel-fill"></i> تصفية</button>
                    @if(request()->anyFilled(['search', 'category', 'type', 'status']))
                        <a href="{{ route('admin.products.index') }}" class="btn btn-light border py-2" title="إعادة تعيين الفلاتر"><i class="bi bi-arrow-counterclockwise"></i></a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Products Directory -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">المنتج</th>
                            <th>النوع</th>
                            <th>التصنيفات</th>
                            <th>السعر الأساسي</th>
                            <th>سعر العرض</th>
                            <th class="text-center">المخزون</th>
                            <th>الحالة</th>
                            <th class="pe-4 text-end">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        @if(is_array($product->images) && !empty($product->images))
                                            <img src="{{ asset('storage/' . $product->images[0]) }}" class="rounded object-fit-cover" style="width: 48px; height: 48px;" alt="{{ $product->name }}">
                                        @else
                                            <div class="rounded bg-light text-secondary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                                <i class="bi bi-box-seam fs-4"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('admin.products.show', $product->id) }}" class="fw-bold text-dark-emphasis text-decoration-none hover-primary">{{ $product->name }}</a>
                                            <small class="text-muted d-block fs-8">رمز SKU: {{ $product->sku ?? 'بدون رمز' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $typeBadge = match($product->type) {
                                            'digital' => 'bg-info-subtle text-info',
                                            'course' => 'bg-success-subtle text-success',
                                            'session' => 'bg-warning-subtle text-warning-emphasis',
                                            default => 'bg-primary-subtle text-primary',
                                        };
                                        $typeLabel = match($product->type) {
                                            'digital' => 'شيت رقمي (PDF)',
                                            'course' => 'كورس تعليمي',
                                            'session' => 'جلسة تواصل',
                                            default => 'أداة مادية',
                                        };
                                    @endphp
                                    <span class="badge {{ $typeBadge }} fw-semibold">
                                        {{ $typeLabel }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @forelse($product->categories as $cat)
                                            <span class="badge bg-secondary-subtle text-secondary fs-8">{{ $cat->name }}</span>
                                        @empty
                                            <span class="text-muted-50 fs-8">غير مصنف</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="fw-bold">{{ number_format($product->price, 2) }} ج.م</td>
                                <td class="fw-bold text-danger">
                                    {{ $product->sale_price ? number_format($product->sale_price, 2) . ' ج.م' : '-' }}
                                </td>
                                <td class="text-center fw-semibold">
                                    @if($product->type === 'digital')
                                        <span class="text-info"><i class="bi bi-infinity"></i> غير محدود</span>
                                    @else
                                        @if($product->stock <= 5)
                                            <span class="text-danger fw-bold"><i class="bi bi-exclamation-triangle"></i> {{ $product->stock }} (منخفض)</span>
                                        @else
                                            <span class="text-success">{{ $product->stock }} وحدة</span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if($product->is_active)
                                        <span class="badge bg-success-subtle text-success"><i class="bi bi-eye-fill me-1"></i>ظاهر</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger"><i class="bi bi-eye-slash-fill me-1"></i>مخفي</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-outline-primary" title="عرض التفاصيل">
                                            <i class="bi bi-eye-fill"></i> عرض
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-info" title="تعديل">
                                            <i class="bi bi-pencil-fill"></i> تعديل
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟ لا يمكن استرجاع الصور والملفات المرفوعة.');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                                <i class="bi bi-trash-fill"></i> حذف
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-box-seam fs-1 d-block mb-3"></i> لا توجد منتجات مطابقة لخيارات الفرز الحالية.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted fs-7">يعرض {{ $products->firstItem() }} إلى {{ $products->lastItem() }} من إجمالي {{ $products->total() }} منتج</span>
                    <div>
                        {!! $products->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
