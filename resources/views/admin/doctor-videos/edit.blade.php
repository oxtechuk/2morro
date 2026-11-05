@extends('admin.layouts.layout')

@section('title', 'تعديل الشرح: ' . $doctorVideo->title)

@section('content')
<div class="container-fluid p-0">

    <!-- Header & Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1 text-dark d-flex align-items-center gap-2">
                <i class="bi bi-pencil-square text-primary"></i>
                <span>تعديل فيديو: {{ $doctorVideo->title }}</span>
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 fs-8">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.doctor-videos.index') }}">شروحات الدكتور والريلز</a></li>
                    <li class="breadcrumb-item active" aria-current="page">تعديل</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            @if(Route::has('doctor-videos.watch'))
            <a href="{{ route('doctor-videos.watch', $doctorVideo->slug) }}" target="_blank" class="btn btn-outline-primary rounded-3 fs-7 fw-bold">
                <i class="bi bi-eye me-1"></i> مشاهدة في الموقع
            </a>
            @endif
            <a href="{{ route('admin.doctor-videos.index') }}" class="btn btn-outline-secondary rounded-3 fs-7 fw-bold">
                <i class="bi bi-arrow-right me-1"></i> العودة للقائمة
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('admin.doctor-videos.update', $doctorVideo) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <!-- Left Column: Core Video Settings -->
            <div class="col-lg-8">
                
                <!-- 1. Video Type Selector -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3 px-4 border-0">
                        <h6 class="fw-bold mb-0 text-dark">نوع وطريقة عرض الفيديو</h6>
                    </div>
                    <div class="card-body px-4 pt-1 pb-4">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="card h-100 p-3 rounded-4 border-2 cursor-pointer transition-all {{ $doctorVideo->video_type === 'standard' ? 'border-primary bg-primary bg-opacity-10' : '' }}" style="cursor: pointer;">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="radio" name="video_type" value="standard" class="form-check-input mt-0" {{ $doctorVideo->video_type === 'standard' ? 'checked' : '' }}>
                                        <div>
                                            <div class="fw-bold text-dark fs-6 d-flex align-items-center gap-1.5">
                                                <i class="bi bi-display text-primary fs-5"></i>
                                                <span>شرح تفصيلي أفقي (16:9)</span>
                                            </div>
                                            <small class="text-muted d-block mt-0.5">مناسب للشروحات الطبية المطولة (YouTube Style).</small>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div class="col-sm-6">
                                <label class="card h-100 p-3 rounded-4 border-2 cursor-pointer transition-all {{ $doctorVideo->video_type === 'reel' ? 'border-primary bg-primary bg-opacity-10' : '' }}" style="cursor: pointer;">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="radio" name="video_type" value="reel" class="form-check-input mt-0" {{ $doctorVideo->video_type === 'reel' ? 'checked' : '' }}>
                                        <div>
                                            <div class="fw-bold text-dark fs-6 d-flex align-items-center gap-1.5">
                                                <i class="bi bi-phone-fill text-danger fs-5"></i>
                                                <span>ريلز / شورتس عمودي (9:16)</span>
                                            </div>
                                            <small class="text-muted d-block mt-0.5">مناسب للنصائح السريعة (Shorts / Reels).</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Video Source -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3 px-4 border-0">
                        <h6 class="fw-bold mb-0 text-dark">ملف الفيديو أو الرابط الحالي</h6>
                    </div>
                    <div class="card-body px-4 pt-1 pb-4">
                        <div class="mb-3">
                            <div class="alert alert-light border rounded-3 p-3 mb-3 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-film fs-4 text-primary"></i>
                                    <div>
                                        <div class="fw-bold fs-7">الملف أو الرابط الحالي:</div>
                                        <span class="text-muted font-monospace fs-8 text-break">{{ $doctorVideo->video_path ?? 'لم يتم رفع ملف' }}</span>
                                    </div>
                                </div>
                                <span class="badge bg-secondary rounded-pill px-2.5 py-1">{{ ucfirst($doctorVideo->video_source) }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fs-7 fw-bold text-muted">تحديث مصدر الفيديو</label>
                            <div class="d-flex gap-3 flex-wrap mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="video_source" id="source_upload" value="upload" {{ $doctorVideo->video_source === 'upload' ? 'checked' : '' }} onchange="toggleSource('upload')">
                                    <label class="form-check-label fw-bold fs-7" for="source_upload">رفع ملف جديد</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="video_source" id="source_youtube" value="youtube" {{ $doctorVideo->video_source === 'youtube' ? 'checked' : '' }} onchange="toggleSource('youtube')">
                                    <label class="form-check-label fw-bold fs-7" for="source_youtube">يوتيوب</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="video_source" id="source_url" value="url" {{ $doctorVideo->video_source === 'url' ? 'checked' : '' }} onchange="toggleSource('url')">
                                    <label class="form-check-label fw-bold fs-7" for="source_url">رابط خارجي CDN</label>
                                </div>
                            </div>

                            <div id="upload_box" class="{{ $doctorVideo->video_source === 'upload' ? '' : 'd-none' }} p-3 border-2 border-dashed rounded-3 text-center bg-light">
                                <input type="file" name="video_file" class="form-control" accept="video/mp4,video/quicktime,video/webm">
                                <small class="text-muted fs-8 mt-1 d-block">اتركه فارغاً إذا كنت لا ترغب في استبدال ملف الفيديو الحالي.</small>
                            </div>

                            <div id="url_box" class="{{ $doctorVideo->video_source !== 'upload' ? '' : 'd-none' }}">
                                <input type="url" name="video_url" class="form-control" value="{{ $doctorVideo->video_path }}" placeholder="https://...">
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label fs-7 fw-bold text-muted">مدة الفيديو</label>
                                <input type="text" name="duration" class="form-control" value="{{ $doctorVideo->duration }}" placeholder="04:30">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Title & Description -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3 px-4 border-0">
                        <h6 class="fw-bold mb-0 text-dark">العنوان والوصف</h6>
                    </div>
                    <div class="card-body px-4 pt-1 pb-4">
                        <div class="mb-3">
                            <label class="form-label fs-7 fw-bold text-muted">عنوان الفيديو <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control form-control-lg fw-bold" value="{{ $doctorVideo->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fs-7 fw-bold text-muted">شرح وتوجيهات الدكتور</label>
                            <textarea name="description" rows="5" class="form-control">{{ $doctorVideo->description }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 4. Related Products -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3 px-4 border-0">
                        <h6 class="fw-bold mb-0 text-dark">منتجات تمورو الموصى بها لعلاج الحالة</h6>
                    </div>
                    <div class="card-body px-4 pt-1 pb-4">
                        @php
                            $selectedProducts = $doctorVideo->products->pluck('id')->toArray();
                        @endphp
                        <div class="border rounded-3 p-3 bg-light overflow-auto" style="max-height: 240px;">
                            <div class="row g-2">
                                @foreach($products as $product)
                                    <div class="col-md-6">
                                        <label class="card h-100 p-2.5 rounded-3 border bg-white cursor-pointer d-flex flex-row align-items-center gap-2" style="cursor: pointer;">
                                            <input type="checkbox" name="related_products[]" value="{{ $product->id }}" class="form-check-input mt-0" {{ in_array($product->id, $selectedProducts) ? 'checked' : '' }}>
                                            <img src="{{ $product->thumbnail_url ?? asset('assets/icons-admin/box.svg') }}" alt="" class="rounded-2 object-fit-cover" style="width: 42px; height: 42px;">
                                            <div class="text-truncate flex-grow-1">
                                                <div class="fw-bold fs-8 text-dark text-truncate">{{ $product->name }}</div>
                                                <small class="text-success fw-bold fs-8">{{ number_format($product->price, 2) }} ج.م</small>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column -->
            <div class="col-lg-4">

                <!-- 1. Thumbnail -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3 px-4 border-0">
                        <h6 class="fw-bold mb-0 text-dark">الصورة المصغرة (Thumbnail)</h6>
                    </div>
                    <div class="card-body px-4 pt-1 pb-4">
                        <div class="mb-3 text-center">
                            <div class="rounded-4 overflow-hidden border bg-light d-flex align-items-center justify-content-center mb-2" 
                                 style="aspect-ratio: {{ $doctorVideo->video_type === 'reel' ? '9/16' : '16/9' }}; max-height: 180px;">
                                <img src="{{ $doctorVideo->thumbnail_url }}" alt="" class="w-100 h-100 object-fit-cover">
                            </div>
                        </div>
                        <input type="file" name="thumbnail_file" class="form-control form-control-sm" accept="image/*">
                        <small class="text-muted fs-8 mt-1 d-block">اتركها فارغة للاحتفاظ بالصورة الحالية.</small>
                    </div>
                </div>

                <!-- 2. Problem & Age Classification -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3 px-4 border-0">
                        <h6 class="fw-bold mb-0 text-dark">التصنيف والجمهور</h6>
                    </div>
                    <div class="card-body px-4 pt-1 pb-4">
                        <div class="mb-3">
                            <label class="form-label fs-7 fw-bold text-muted">نوع المشكلة / الحالة</label>
                            <select name="need_id" class="form-select form-select-sm fw-bold">
                                <option value="">-- اختر المشكلة --</option>
                                @foreach($needs as $need)
                                    <option value="{{ $need->id }}" {{ $doctorVideo->need_id == $need->id ? 'selected' : '' }}>
                                        {{ $need->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="form-label fs-7 fw-bold text-muted">الفئة العمرية</label>
                            <select name="age_group_id" class="form-select form-select-sm fw-bold">
                                <option value="">-- عام لكافة الأعمار --</option>
                                @foreach($ageGroups as $ag)
                                    <option value="{{ $ag->id }}" {{ $doctorVideo->age_group_id == $ag->id ? 'selected' : '' }}>
                                        {{ $ag->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- 3. Monetization Engine -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 border-start border-4 border-warning">
                    <div class="card-header bg-white py-3 px-4 border-0">
                        <h6 class="fw-bold mb-0 text-dark">نوع الوصول والتسعير</h6>
                    </div>
                    <div class="card-body px-4 pt-1 pb-4">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input cursor-pointer" type="checkbox" role="switch" name="is_paid" id="is_paid_switch" value="1" {{ $doctorVideo->is_paid ? 'checked' : '' }} onchange="toggleMonetization(this.checked)">
                            <label class="form-check-label fw-bold fs-7 cursor-pointer" for="is_paid_switch">
                                محتوى مدفوع (يتطلب الشراء) 🔒
                            </label>
                        </div>

                        <div id="pricing_fields" class="p-3 bg-light rounded-3 {{ $doctorVideo->is_paid ? '' : 'd-none' }}">
                            <div class="mb-3">
                                <label class="form-label fs-7 fw-bold text-muted">السعر (ج.م)</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" step="0.5" name="price" id="video_price_input" class="form-control fw-bold" value="{{ $doctorVideo->price }}">
                                    <span class="input-group-text bg-white">ج.م</span>
                                </div>
                            </div>

                            <div class="mb-0">
                                <label class="form-label fs-7 fw-bold text-muted">معاينة مجانية (ثواني)</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" name="preview_seconds" class="form-control" value="{{ $doctorVideo->preview_seconds }}">
                                    <span class="input-group-text bg-white">ثانية</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Save Actions -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input cursor-pointer" type="checkbox" role="switch" name="is_published" id="is_published_switch" value="1" {{ $doctorVideo->is_published ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold fs-7 cursor-pointer" for="is_published_switch">
                                منشور للجمهور
                            </label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold py-2.5 rounded-3 shadow-xs">
                                <i class="bi bi-check2-circle me-1"></i> حفظ التعديلات
                            </button>
                            <a href="{{ route('admin.doctor-videos.index') }}" class="btn btn-light border text-muted py-2 rounded-3 fs-7">
                                إلغاء
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

</div>

@push('scripts')
<script>
    function toggleSource(source) {
        if (source === 'upload') {
            document.getElementById('upload_box').classList.remove('d-none');
            document.getElementById('url_box').classList.add('d-none');
        } else {
            document.getElementById('upload_box').classList.add('d-none');
            document.getElementById('url_box').classList.remove('d-none');
        }
    }

    function toggleMonetization(isPaid) {
        const pricingBox = document.getElementById('pricing_fields');
        if (isPaid) {
            pricingBox.classList.remove('d-none');
        } else {
            pricingBox.classList.add('d-none');
        }
    }
</script>
@endpush

@endsection

