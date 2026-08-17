@extends('admin.layouts.layout')

@section('title', ($category->exists ? 'تعديل التصنيف: ' . $category->name : 'إضافة تصنيف جديد') . ' | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold mb-1">{{ $category->exists ? 'تعديل تصنيف المتجر' : 'إضافة تصنيف جديد' }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">التصنيفات</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $category->exists ? 'تعديل: ' . $category->name : 'إضافة جديد' }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 fw-bold">{{ $category->exists ? 'بيانات التصنيف الحالية' : 'بيانات التصنيف الجديد' }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ $category->exists ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($category->exists)
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <!-- Category Name -->
                    <div class="col-md-6 col-sm-12">
                        <label class="form-label fw-bold">اسم التصنيف</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="col-md-6 col-sm-12">
                        <label class="form-label fw-bold">الرابط اللطيف (Slug)</label>
                        <input type="text" name="slug" id="slug" class="form-control text-start @error('slug') is-invalid @enderror" value="{{ old('slug', $category->slug) }}" placeholder="اتركه فارغاً للتوليد التلقائي">
                        <small class="text-muted">الرابط الذي يظهر في عنوان المتصفح. مثال: `educational-tools`</small>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label fw-bold">الوصف والتفاصيل</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="اكتب وصفاً موجزاً للتصنيف لتعريف العملاء بمحتوياته...">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category Status -->
                    <div class="col-md-6 col-sm-12">
                        <label class="form-label fw-bold d-block">حالة التصنيف</label>
                        <div class="form-check form-switch fs-5 mt-2">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $category->exists ? $category->is_active : true) ? 'checked' : '' }}>
                            <label class="form-check-label fs-7 text-muted" for="is_active">التصنيف متاح ونشط للعملاء بالمتجر</label>
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="col-md-6 col-sm-12">
                        <label class="form-label fw-bold">أيقونة / صورة التصنيف</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                        <small class="text-muted">الصورة الرمزية للتصنيف (توصى بصيغة WebP أو PNG وحجم أقل من 2 ميجا).</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        @if($category->image)
                            <div class="mt-3">
                                <label class="d-block text-muted fs-8 mb-1">الصورة الحالية:</label>
                                <img src="{{ asset('storage/' . $category->image) }}" class="img-thumbnail" style="max-height: 80px;" alt="{{ $category->name }}">
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row mt-4 pt-3 border-top">
                    <div class="col-12 text-end">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-light me-2 fw-bold">إلغاء</a>
                        <button type="submit" class="btn btn-primary px-5 fw-bold">
                            <i class="bi bi-check-circle me-1"></i> {{ $category->exists ? 'حفظ التغييرات' : 'حفظ التصنيف' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Automatic Slug Generation helper
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    if (nameInput && slugInput && !slugInput.value) {
        nameInput.addEventListener('input', function() {
            let slugText = this.value
                .toLowerCase()
                .replace(/[^\w\s\u0600-\u06FF]/g, '') // Keep letters, spaces, Arabic chars
                .replace(/\s+/g, '-');
            slugInput.value = slugText;
        });
    }
</script>
@endsection
