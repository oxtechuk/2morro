@extends('admin.layouts.layout')

@section('title', 'تصنيفات المتجر | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-1">تصنيفات المتجر</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">التصنيفات</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary fw-bold">
                    <i class="bi bi-plus-circle me-1"></i> إضافة تصنيف جديد
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">التصنيف</th>
                            <th>الرابط اللطيف (Slug)</th>
                            <th>الوصف</th>
                            <th class="text-center">عدد المنتجات</th>
                            <th>الحالة</th>
                            <th class="pe-4 text-end">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        @if($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}" class="rounded object-fit-cover" style="width: 48px; height: 48px;" alt="{{ $category->name }}">
                                        @else
                                            <div class="rounded bg-light text-secondary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                                <i class="bi bi-tag fs-4"></i>
                                            </div>
                                        @endif
                                        <div class="fw-bold text-dark-emphasis">{{ $category->name }}</div>
                                    </div>
                                </td>
                                <td class="text-start text-muted fs-7">{{ $category->slug }}</td>
                                <td class="fs-7 text-truncate" style="max-width: 250px;">{{ $category->description ?? 'بدون وصف' }}</td>
                                <td class="text-center fw-semibold">{{ $category->products_count }} منتج</td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>نشط</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-circle me-1"></i>معطل</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-info" title="تعديل">
                                            <i class="bi bi-pencil-fill"></i> تعديل
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا التصنيف؟');" class="d-inline">
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
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-tags fs-1 d-block mb-3"></i> لا توجد تصنيفات معرفة حالياً. اضغط على زر "إضافة تصنيف جديد" للبدء.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
