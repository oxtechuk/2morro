@extends('admin.layouts.layout')

@section('title', 'تعديل شريحة البانر | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1">تعديل شريحة البانر</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">بانرات السليدر</a></li>
                    <li class="breadcrumb-item active" aria-current="page">تعديل الشريحة #{{ $banner->id }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary fw-bold">
            <i class="bi bi-arrow-right me-1"></i> العودة للقائمة
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show fw-bold" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> يرجى مراجعة وتصحيح الأخطاء التالية:
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-xs border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <h6 class="mb-0 fw-bold text-dark">
                <i class="bi bi-pencil-square text-primary me-2"></i> تعديل بيانات الشريحة
            </h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <!-- Current Image Preview & Upload -->
                    <div class="col-12">
                        <label class="form-label fw-bold">صورة البانر الحالية</label>
                        <div class="rounded-3 overflow-hidden border p-2 bg-light mb-3" style="max-width: 480px;">
                            <img src="{{ asset($banner->image) }}" alt="Banner" class="w-100 h-auto rounded-2">
                        </div>
                        <label class="form-label fw-bold">تغيير صورة البانر (اختياري)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">اتركه فارغاً إذا كنت لا ترغب بتغيير الصورة الحالية.</small>
                    </div>

                    <!-- Title & Badge -->
                    <div class="col-md-8 col-sm-12">
                        <label class="form-label fw-bold">العنوان الرئيسي للبانر</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title) }}" placeholder="مثال: أدوات تعليمية تنمي مهارات طفلك">
                    </div>

                    <div class="col-md-4 col-sm-12">
                        <label class="form-label fw-bold">شارة ترويجية صغيرة (Badge)</label>
                        <input type="text" name="badge_text" class="form-control" value="{{ old('badge_text', $banner->badge_text) }}" placeholder="مثال: 🚀 جديد وحصري">
                    </div>

                    <!-- Subtitle -->
                    <div class="col-12">
                        <label class="form-label fw-bold">الوصف والنص الترويجي الفرعي</label>
                        <textarea name="subtitle" class="form-control" rows="2" placeholder="اكتب نصاً تسويقياً جذاباً">{{ old('subtitle', $banner->subtitle) }}</textarea>
                    </div>

                    <!-- Primary Button -->
                    <div class="col-md-6 col-sm-12">
                        <label class="form-label fw-bold">نص الزر الأساسي</label>
                        <input type="text" name="button_text" class="form-control" value="{{ old('button_text', $banner->button_text) }}">
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <label class="form-label fw-bold">رابط الزر الأساسي (URL)</label>
                        <input type="text" name="button_link" class="form-control text-start" value="{{ old('button_link', $banner->button_link) }}" dir="ltr">
                    </div>

                    <!-- Secondary Button -->
                    <div class="col-md-6 col-sm-12">
                        <label class="form-label fw-bold">نص الزر الثانوي (اختياري)</label>
                        <input type="text" name="secondary_button_text" class="form-control" value="{{ old('secondary_button_text', $banner->secondary_button_text) }}">
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <label class="form-label fw-bold">رابط الزر الثانوي (URL)</label>
                        <input type="text" name="secondary_button_link" class="form-control text-start" value="{{ old('secondary_button_link', $banner->secondary_button_link) }}" dir="ltr">
                    </div>

                    <!-- Alignment & Sort Order -->
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label fw-bold">محاذاة النصوص على البانر</label>
                        <select name="text_position" class="form-select">
                            <option value="right" {{ old('text_position', $banner->text_position) === 'right' ? 'selected' : '' }}>جهة اليمين (موصى به للغة العربية)</option>
                            <option value="center" {{ old('text_position', $banner->text_position) === 'center' ? 'selected' : '' }}>في المنتصف</option>
                            <option value="left" {{ old('text_position', $banner->text_position) === 'left' ? 'selected' : '' }}>جهة اليسار</option>
                        </select>
                    </div>

                    <div class="col-md-4 col-sm-12">
                        <label class="form-label fw-bold">ترتيب الظهور في السليدر</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $banner->sort_order) }}" min="0">
                    </div>

                    <div class="col-md-4 col-sm-12 d-flex align-items-center pt-4">
                        <div class="form-check form-switch fs-5">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitch" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fs-6 fw-bold ms-2" for="isActiveSwitch">تفعيل وعرض البانر فوراً</label>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-5 py-2.5 fw-bold shadow-xs">
                        <i class="bi bi-save-fill me-1"></i> حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
