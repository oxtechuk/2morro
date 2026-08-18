@extends('admin.layouts.layout')

@section('title', 'بانرات السليدر الرئيسي | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1">بانرات السليدر الرئيسي (Hero Slider)</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page">إدارة السليدر والبانرات</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary fw-bold shadow-xs">
            <i class="bi bi-plus-lg me-1"></i> إضافة شريحة بانر جديدة
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show fw-bold" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-xs border-0">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="mb-0 fw-bold text-dark">
                <i class="bi bi-images text-primary me-2"></i> جميع شرائح البانر المعروضة ({{ $banners->total() }})
            </h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-light">
                    <tr>
                        <th style="width: 70px;">الترتيب</th>
                        <th style="width: 140px;">معاينة الصورة</th>
                        <th class="text-end">العنوان والنص الترويجي</th>
                        <th>الأزرار والروابط</th>
                        <th>المحاذاة</th>
                        <th>الحالة</th>
                        <th style="width: 140px;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                        <tr>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1.5 fw-bold">
                                    #{{ $banner->sort_order }}
                                </span>
                            </td>
                            <td>
                                <div class="rounded-3 overflow-hidden border shadow-2xs mx-auto" style="width: 120px; height: 60px;">
                                    <img src="{{ asset($banner->image) }}" alt="{{ $banner->title }}" class="w-100 h-100 object-fit-cover">
                                </div>
                            </td>
                            <td class="text-end">
                                @if($banner->badge_text)
                                    <span class="badge bg-danger-subtle text-danger px-2 py-1 mb-1">{{ $banner->badge_text }}</span>
                                @endif
                                <h6 class="mb-1 fw-bold text-dark">{{ $banner->title ?: 'بدون عنوان نصي (بانر مرئي فقط)' }}</h6>
                                @if($banner->subtitle)
                                    <small class="text-muted text-truncate d-block" style="max-width: 320px;">{{ $banner->subtitle }}</small>
                                @endif
                            </td>
                            <td>
                                @if($banner->button_text)
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 d-block mb-1">
                                        {{ $banner->button_text }}
                                    </span>
                                    <small class="text-muted d-block" dir="ltr">{{ Str::limit($banner->button_link, 20) }}</small>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td>
                                @if($banner->text_position === 'center')
                                    <span class="badge bg-secondary">وسط</span>
                                @elseif($banner->text_position === 'left')
                                    <span class="badge bg-secondary">يسار</span>
                                @else
                                    <span class="badge bg-secondary">يمين</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.banners.toggleStatus', $banner) }}" method="POST" class="d-inline">
                                    @csrf
                                    @if($banner->is_active)
                                        <button type="submit" class="btn btn-sm btn-success px-2.5 py-1 rounded-pill fw-bold" title="انقر للتعطيل">
                                            <i class="bi bi-check-circle me-1"></i> مفعل
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-outline-secondary px-2.5 py-1 rounded-pill fw-bold" title="انقر للتفعيل">
                                            <i class="bi bi-dash-circle me-1"></i> معطل
                                        </button>
                                    @endif
                                </form>
                            </td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-1">
                                    <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-outline-primary" title="تعديل">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا البانر نهائياً؟');">
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
                            <td colspan="7" class="py-5 text-center text-muted">
                                <i class="bi bi-images fs-1 text-secondary d-block mb-3"></i>
                                <h6 class="fw-bold">لا توجد بانرات مخصصة حتى الآن</h6>
                                <p class="small text-muted mb-3">يمكنك إضافة شرائح وبانرات متعددة لتظهر في السليدر الرئيسي بالواجهة فوراً.</p>
                                <a href="{{ route('admin.banners.create') }}" class="btn btn-sm btn-primary fw-bold">
                                    <i class="bi bi-plus-lg me-1"></i> إضافة أول شريحة الآن
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($banners->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $banners->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
