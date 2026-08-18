@extends('admin.layouts.layout')

@section('title', 'إضافة شريحة بانر جديدة | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1">إضافة شريحة بانر جديدة</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">بانرات السليدر</a></li>
                    <li class="breadcrumb-item active" aria-current="page">إضافة شريحة جديدة</li>
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
                <i class="bi bi-plus-circle text-primary me-2"></i> بيانات الشريحة والبانر الجديد
            </h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <!-- Image Upload -->
                    <div class="col-12">
                        <label class="form-label fw-bold">صورة البانر (بالعرض الكامل) <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control form-control-lg" accept="image/*" required>
                        <small class="text-muted">يقبل صور بدقة عالية JPG, PNG, WebP (المقاس المثالي الموصى به: 1920×650 أو 1440×550 بكسل).</small>
                    </div>

                    <!-- Title & Badge -->
                    <div class="col-md-8 col-sm-12">
                        <label class="form-label fw-bold">العنوان الرئيسي للبانر</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="مثال: أدوات تعليمية تنمي مهارات طفلك">
                    </div>

                    <div class="col-md-4 col-sm-12">
                        <label class="form-label fw-bold">شارة ترويجية صغيرة (Badge)</label>
                        <input type="text" name="badge_text" class="form-control" value="{{ old('badge_text') }}" placeholder="مثال: 🚀 جديد وحصري">
                    </div>

                    <!-- Subtitle -->
                    <div class="col-12">
                        <label class="form-label fw-bold">الوصف والنص الترويجي الفرعي</label>
                        <textarea name="subtitle" class="form-control" rows="2" placeholder="اكتب نصاً تسويقياً جذاباً">{{ old('subtitle') }}</textarea>
                    </div>

                    <!-- Primary Button -->
                    <div class="col-md-6 col-sm-12">
                        <label class="form-label fw-bold">نص الزر الأساسي</label>
                        <input type="text" name="button_text" class="form-control" value="{{ old('button_text', 'تسوق الآن') }}" placeholder="مثال: تسوق الآن">
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <label class="form-label fw-bold">رابط الزر الأساسي (URL)</label>
                        <input type="text" name="button_link" class="form-control text-start" value="{{ old('button_link', '/search') }}" placeholder="/search" dir="ltr">
                    </div>

                    <!-- Secondary Button -->
                    <div class="col-md-6 col-sm-12">
                        <label class="form-label fw-bold">نص الزر الثانوي (اختياري)</label>
                        <input type="text" name="secondary_button_text" class="form-control" value="{{ old('secondary_button_text') }}" placeholder="مثال: اكتشف الباقات">
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <label class="form-label fw-bold">رابط الزر الثانوي (URL)</label>
                        <input type="text" name="secondary_button_link" class="form-control text-start" value="{{ old('secondary_button_link') }}" placeholder="/search?category=educational-bundles" dir="ltr">
                    </div>

                    <!-- Alignment & Sort Order -->
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label fw-bold">محاذاة النصوص على البانر</label>
                        <select name="text_position" class="form-select">
                            <option value="right" {{ old('text_position') === 'right' ? 'selected' : '' }}>جهة اليمين (موصى به للغة العربية)</option>
                            <option value="center" {{ old('text_position') === 'center' ? 'selected' : '' }}>في المنتصف</option>
                            <option value="left" {{ old('text_position') === 'left' ? 'selected' : '' }}>جهة اليسار</option>
                        </select>
                    </div>

                    <div class="col-md-4 col-sm-12">
                        <label class="form-label fw-bold">ترتيب الظهور في السليدر</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                    </div>

                    <div class="col-md-4 col-sm-12 d-flex align-items-center pt-4">
                        <div class="form-check form-switch fs-5">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitch" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label fs-6 fw-bold ms-2" for="isActiveSwitch">تفعيل وعرض البانر فوراً</label>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-5 py-2.5 fw-bold shadow-xs">
                        <i class="bi bi-cloud-upload-fill me-1"></i> حفظ وإضافة البانر
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
