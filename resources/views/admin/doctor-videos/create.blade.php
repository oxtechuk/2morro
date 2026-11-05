@extends('admin.layouts.layout')

@section('title', 'رفع فيديو أو ريلز جديد | شروحات الدكتور')

@section('content')
<div class="container-fluid p-0">

    <!-- Header & Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1 text-dark d-flex align-items-center gap-2">
                <i class="bi bi-cloud-arrow-up-fill text-primary"></i>
                <span>رفع فيديو أو ريلز جديد لشروحات الدكتور</span>
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 fs-8">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.doctor-videos.index') }}">شروحات الدكتور والريلز</a></li>
                    <li class="breadcrumb-item active" aria-current="page">رفع جديد</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.doctor-videos.index') }}" class="btn btn-outline-secondary rounded-3 fs-7 fw-bold">
                <i class="bi bi-arrow-right me-1"></i> العودة للقائمة
            </a>
        </div>
    </div>

    <!-- Upload Form -->
    <form action="{{ route('admin.doctor-videos.store') }}" method="POST" enctype="multipart/form-data" id="videoUploadForm">
        @csrf

        <div class="row g-4">
            <!-- Left Column: Core Video Settings -->
            <div class="col-lg-8">
                
                <!-- 1. Video Type Selector (Reel vs Standard) -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3 px-4 border-0">
                        <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <span class="badge bg-primary rounded-circle p-1" style="width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center;">1</span>
                            <span>تحديد نوع وطريقة عرض الفيديو</span>
                        </h6>
                    </div>
                    <div class="card-body px-4 pt-1 pb-4">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="card h-100 p-3 rounded-4 border-2 cursor-pointer transition-all video-type-card active" id="card-standard" style="cursor: pointer;">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="radio" name="video_type" value="standard" class="form-check-input mt-0" checked onchange="handleTypeChange('standard')">
                                        <div>
                                            <div class="fw-bold text-dark fs-6 d-flex align-items-center gap-1.5">
                                                <i class="bi bi-display text-primary fs-5"></i>
                                                <span>شرح تفصيلي أفقي (16:9)</span>
                                            </div>
                                            <small class="text-muted d-block mt-0.5">مناسب للشروحات الطبية المطولة وجلسات التوجيه التفصيلية لأولياء الأمور (YouTube Style).</small>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div class="col-sm-6">
                                <label class="card h-100 p-3 rounded-4 border-2 cursor-pointer transition-all video-type-card" id="card-reel" style="cursor: pointer;">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="radio" name="video_type" value="reel" class="form-check-input mt-0" onchange="handleTypeChange('reel')">
                                        <div>
                                            <div class="fw-bold text-dark fs-6 d-flex align-items-center gap-1.5">
                                                <i class="bi bi-phone-fill text-danger fs-5"></i>
                                                <span>ريلز / شورتس عمودي (9:16)</span>
                                            </div>
                                            <small class="text-muted d-block mt-0.5">مناسب للنصائح السريعة والريلز الجذابة للموبايل وشورتس يوتيوب (Shorts / Reels).</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Video Source & Upload -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3 px-4 border-0">
                        <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <span class="badge bg-primary rounded-circle p-1" style="width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center;">2</span>
                            <span>ملف الفيديو أو الرابط</span>
                        </h6>
                    </div>
                    <div class="card-body px-4 pt-1 pb-4">
                        <div class="mb-3">
                            <label class="form-label fs-7 fw-bold text-muted">طريقة إضافة الفيديو</label>
                            <div class="d-flex gap-3 flex-wrap">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="video_source" id="source_upload" value="upload" checked onchange="toggleSource('upload')">
                                    <label class="form-check-label fw-bold fs-7 cursor-pointer" for="source_upload">
                                        <i class="bi bi-upload text-primary me-1"></i> رفع ملف فيديو مباشر من جهازك
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="video_source" id="source_youtube" value="youtube" onchange="toggleSource('youtube')">
                                    <label class="form-check-label fw-bold fs-7 cursor-pointer" for="source_youtube">
                                        <i class="bi bi-youtube text-danger me-1"></i> رابط YouTube / Shorts
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="video_source" id="source_url" value="url" onchange="toggleSource('url')">
                                    <label class="form-check-label fw-bold fs-7 cursor-pointer" for="source_url">
                                        <i class="bi bi-link-45deg text-info me-1"></i> رابط مباشر خارجي (CDN / Vimeo)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Direct File Upload Box -->
                        <div id="upload_box" class="p-4 border-2 border-dashed rounded-4 text-center bg-light transition-all mb-3">
                            <i class="bi bi-cloud-arrow-up display-5 text-primary mb-2 d-block"></i>
                            <h6 class="fw-bold mb-1">اختر ملف الفيديو أو اسحبه هنا</h6>
                            <p class="text-muted fs-8 mb-3">الصيغ المدعومة: MP4, MOV, WEBM (الحد الأقصى الموصى به: 500 ميجابايت)</p>
                            <input type="file" name="video_file" id="video_file_input" class="d-none" accept="video/mp4,video/quicktime,video/webm" onchange="handleFileSelected(this)">
                            <button type="button" class="btn btn-outline-primary fw-bold fs-7 rounded-3 px-4 py-2" onclick="document.getElementById('video_file_input').click()">
                                <i class="bi bi-folder2-open me-1"></i> تصفح من الكمبيوتر
                            </button>
                            <div id="file_selected_info" class="mt-3 d-none">
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill fs-7 fw-bold">
                                    <i class="bi bi-check-circle-fill me-1"></i> <span id="file_selected_name"></span> (<span id="file_selected_size"></span>)
                                </span>
                            </div>
                        </div>

                        <!-- External URL Box -->
                        <div id="url_box" class="d-none mb-3">
                            <label class="form-label fs-7 fw-bold text-muted">رابط الفيديو (URL)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-link-45deg"></i></span>
                                <input type="url" name="video_url" id="video_url_input" class="form-control" placeholder="https://www.youtube.com/watch?v=... أو رابط مباشر">
                            </div>
                            <small class="text-muted fs-8 mt-1 d-block">سواء كان رابط يوتيوب عادي، أو رابط Shorts، أو رابط استضافة فيديو Bunny / Vimeo.</small>
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label fs-7 fw-bold text-muted">مدة الفيديو التقديرية</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-clock"></i></span>
                                    <input type="text" name="duration" class="form-control" placeholder="مثال: 04:30 أو 0:55">
                                </div>
                                <small class="text-muted fs-8">تظهر كبادج بالزاوية السفلية مثل يوتيوب.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Video Details (Title & Description) -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3 px-4 border-0">
                        <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <span class="badge bg-primary rounded-circle p-1" style="width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center;">3</span>
                            <span>عنوان الشرح والوصف التفصيلي</span>
                        </h6>
                    </div>
                    <div class="card-body px-4 pt-1 pb-4">
                        <div class="mb-3">
                            <label class="form-label fs-7 fw-bold text-muted">عنوان الفيديو / المشكلة <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control form-control-lg fw-bold" placeholder="مثال: كيفية التعامل مع نوبات العناد وتأخر الكلام عند سن 3 سنوات" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fs-7 fw-bold text-muted">شرح وتوجيهات الدكتور (الوصف النصي)</label>
                            <textarea name="description" rows="5" class="form-control" placeholder="اكتب تشخيص الدكتور، خطوات العلاج في المنزل، النصائح والإرشادات لأولياء الأمور..."></textarea>
                            <small class="text-muted fs-8">سيظهر أسفل مشغل الفيديو في قسم الوصف مع إمكانية التوسيع (Show More).</small>
                        </div>
                    </div>
                </div>

                <!-- 4. Related Store Products (Smart Upsell) -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3 px-4 border-0 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <span class="badge bg-success rounded-circle p-1" style="width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center;">4</span>
                            <span>أدوات وألعاب تمورو الموصى بها لعلاج الحالة (Smart Upsell)</span>
                        </h6>
                        <span class="badge bg-light text-muted fs-8">اختياري</span>
                    </div>
                    <div class="card-body px-4 pt-1 pb-4">
                        <p class="text-muted fs-7 mb-3">اختر المنتجات أو الألعاب أو بطاقات التخاطب من متجر 2morro التي يوصي بها الدكتور لعلاج هذه المشكلة لتظهر فوراً أسفل الفيديو للمشاهدين:</p>
                        
                        <div class="border rounded-3 p-3 bg-light overflow-auto" style="max-height: 240px;">
                            <div class="row g-2">
                                @forelse($products as $product)
                                    <div class="col-md-6">
                                        <label class="card h-100 p-2.5 rounded-3 border bg-white cursor-pointer d-flex flex-row align-items-center gap-2" style="cursor: pointer;">
                                            <input type="checkbox" name="related_products[]" value="{{ $product->id }}" class="form-check-input mt-0">
                                            <img src="{{ $product->thumbnail_url ?? asset('assets/icons-admin/box.svg') }}" alt="" class="rounded-2 object-fit-cover" style="width: 42px; height: 42px;">
                                            <div class="text-truncate flex-grow-1">
                                                <div class="fw-bold fs-8 text-dark text-truncate">{{ $product->name }}</div>
                                                <small class="text-success fw-bold fs-8">{{ number_format($product->price, 2) }} ج.م</small>
                                            </div>
                                        </label>
                                    </div>
                                @empty
                                    <div class="col-12 text-center text-muted py-2 fs-8">لا توجد منتجات نشطة حالياً.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Thumbnail, Diagnosis, Pricing & Actions -->
            <div class="col-lg-4">

                <!-- 1. Thumbnail Selector & Upload -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3 px-4 border-0">
                        <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <i class="bi bi-image text-primary"></i>
                            <span>الصورة المصغرة (Thumbnail)</span>
                        </h6>
                    </div>
                    <div class="card-body px-4 pt-1 pb-4">
                        <div class="mb-3 text-center">
                            <div id="thumbnail_preview_container" class="rounded-4 overflow-hidden border bg-light d-flex align-items-center justify-content-center position-relative mb-2" 
                                 style="aspect-ratio: 16/9; max-height: 180px;">
                                <img id="thumbnail_preview" src="{{ asset('assets/icons-admin/video.svg') }}" alt="" class="w-100 h-100 object-fit-cover d-none">
                                <div id="thumbnail_placeholder" class="text-muted fs-8 text-center p-3">
                                    <i class="bi bi-image fs-1 d-block mb-1 text-muted text-opacity-50"></i>
                                    <span>المقاس الموصى به: 1280×720 (16:9) أو 720×1280 (9:16) للريلز</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <input type="file" name="thumbnail_file" id="thumbnail_file_input" class="d-none" accept="image/*" onchange="handleThumbnailPreview(this)">
                            <button type="button" class="btn btn-outline-primary btn-sm fw-bold rounded-3" onclick="document.getElementById('thumbnail_file_input').click()">
                                <i class="bi bi-upload me-1"></i> رفع صورة مصغرة
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 2. Problem & Age Classification -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3 px-4 border-0">
                        <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <i class="bi bi-tags text-primary"></i>
                            <span>التصنيف والجمهور المستهدف</span>
                        </h6>
                    </div>
                    <div class="card-body px-4 pt-1 pb-4">
                        <div class="mb-3">
                            <label class="form-label fs-7 fw-bold text-muted">نوع المشكلة / الاحتياج الخاص <span class="text-danger">*</span></label>
                            <select name="need_id" class="form-select form-select-sm fw-bold">
                                <option value="">-- اختر المشكلة المعالجة --</option>
                                @foreach($needs as $need)
                                    <option value="{{ $need->id }}" {{ old('need_id') == $need->id ? 'selected' : '' }}>
                                        {{ $need->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted fs-8">مثل: تأخر نطق، فرط حركة وتشتت، توحد، تعديل سلوك...</small>
                        </div>

                        <div class="mb-2">
                            <label class="form-label fs-7 fw-bold text-muted">الفئة العمرية المستهدفة</label>
                            <select name="age_group_id" class="form-select form-select-sm fw-bold">
                                <option value="">-- عام لكافة الأعمار --</option>
                                @foreach($ageGroups as $ag)
                                    <option value="{{ $ag->id }}" {{ old('age_group_id') == $ag->id ? 'selected' : '' }}>
                                        {{ $ag->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted fs-8">يسهّل على الآباء إيجاد فيديوهات تناسب عمر طفلهم فوراً.</small>
                        </div>
                    </div>
                </div>

                <!-- 3. Monetization Engine (Free vs Paid) -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 border-start border-4 border-warning">
                    <div class="card-header bg-white py-3 px-4 border-0 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <i class="bi bi-cash-coin text-warning"></i>
                            <span>نوع الوصول والتسعير</span>
                        </h6>
                    </div>
                    <div class="card-body px-4 pt-1 pb-4">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input cursor-pointer" type="checkbox" role="switch" name="is_paid" id="is_paid_switch" value="1" onchange="toggleMonetization(this.checked)">
                            <label class="form-check-label fw-bold fs-7 cursor-pointer" for="is_paid_switch">
                                محتوى مدفوع (يتطلب الشراء للمشاهدة) 🔒
                            </label>
                        </div>

                        <div id="pricing_fields" class="p-3 bg-light rounded-3 d-none">
                            <div class="mb-3">
                                <label class="form-label fs-7 fw-bold text-muted">سعر مشاهدة الفيديو (ج.م) <span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input type="number" step="0.5" name="price" id="video_price_input" class="form-control fw-bold" placeholder="مثال: 50">
                                    <span class="input-group-text bg-white">ج.م</span>
                                </div>
                            </div>

                            <div class="mb-0">
                                <label class="form-label fs-7 fw-bold text-muted">مدة المعاينة المجانية (بالثواني)</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" name="preview_seconds" class="form-control" value="45" placeholder="45">
                                    <span class="input-group-text bg-white">ثانية</span>
                                </div>
                                <small class="text-muted fs-8">مدة يستطيع غير المشتركين مشاهدتها مجاناً كـ Teaser لتشويقهم للشراء.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Publishing Actions -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input cursor-pointer" type="checkbox" role="switch" name="is_published" id="is_published_switch" value="1" checked>
                            <label class="form-check-label fw-bold fs-7 cursor-pointer" for="is_published_switch">
                                نشر الفيديو مباشرة للجمهور
                            </label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold py-2.5 rounded-3 shadow-xs d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-cloud-arrow-up-fill fs-5"></i>
                                <span>حفظ ونشر الفيديو الآن</span>
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
    function handleTypeChange(type) {
        document.querySelectorAll('.video-type-card').forEach(c => c.classList.remove('active', 'border-primary', 'bg-primary', 'bg-opacity-10'));
        if (type === 'reel') {
            document.getElementById('card-reel').classList.add('active', 'border-primary');
            document.getElementById('thumbnail_preview_container').style.aspectRatio = '9/16';
        } else {
            document.getElementById('card-standard').classList.add('active', 'border-primary');
            document.getElementById('thumbnail_preview_container').style.aspectRatio = '16/9';
        }
    }

    function toggleSource(source) {
        if (source === 'upload') {
            document.getElementById('upload_box').classList.remove('d-none');
            document.getElementById('url_box').classList.add('d-none');
        } else {
            document.getElementById('upload_box').classList.add('d-none');
            document.getElementById('url_box').classList.remove('d-none');
            if (source === 'youtube') {
                document.getElementById('video_url_input').placeholder = 'https://www.youtube.com/watch?v=... أو رابط Shorts';
            } else {
                document.getElementById('video_url_input').placeholder = 'https://vimeo.com/... أو رابط فيديو CDN';
            }
        }
    }

    function handleFileSelected(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            document.getElementById('file_selected_name').textContent = file.name;
            document.getElementById('file_selected_size').textContent = (file.size / (1024 * 1024)).toFixed(1) + ' MB';
            document.getElementById('file_selected_info').classList.remove('d-none');
        }
    }

    function handleThumbnailPreview(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('thumbnail_preview');
                img.src = e.target.result;
                img.classList.remove('d-none');
                document.getElementById('thumbnail_placeholder').classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function toggleMonetization(isPaid) {
        const pricingBox = document.getElementById('pricing_fields');
        if (isPaid) {
            pricingBox.classList.remove('d-none');
            document.getElementById('video_price_input').required = true;
        } else {
            pricingBox.classList.add('d-none');
            document.getElementById('video_price_input').required = false;
        }
    }
</script>
@endpush

@endsection

