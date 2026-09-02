@extends('admin.layouts.layout')

@section('title', ($product->exists ? 'تعديل المنتج: ' . $product->name : 'إضافة منتج جديد') . ' | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold mb-1">{{ $product->exists ? 'تعديل منتج بالمتجر' : 'إضافة منتج جديد' }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">المنتجات</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->exists ? 'تعديل: ' . $product->name : 'إضافة جديد' }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ $product->exists ? route('admin.products.update', $product->id) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($product->exists)
            @method('PUT')
        @endif

        <!-- Tabbed Navigation Header -->
        <div class="card mb-4">
            <div class="card-body p-2">
                <ul class="nav nav-pills nav-fill gap-2" id="productFormTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic-pane" type="button" role="tab" aria-controls="basic-pane" aria-selected="true">
                            <i class="bi bi-info-circle-fill"></i> البيانات الأساسية
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2" id="price-tab" data-bs-toggle="tab" data-bs-target="#price-pane" type="button" role="tab" aria-controls="price-pane" aria-selected="false">
                            <i class="bi bi-tag-fill"></i> السعر والمخزون
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" id="digital-tab-item">
                        <button class="nav-link py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2" id="digital-tab" data-bs-toggle="tab" data-bs-target="#digital-pane" type="button" role="tab" aria-controls="digital-pane" aria-selected="false">
                            <i class="bi bi-file-earmark-pdf-fill"></i> ملفات الشيت الرقمي
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2" id="details-tab" data-bs-toggle="tab" data-bs-target="#details-pane" type="button" role="tab" aria-controls="details-pane" aria-selected="false">
                            <i class="bi bi-card-text"></i> تفاصيل الاستخدام والفوائد
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2" id="relations-tab" data-bs-toggle="tab" data-bs-target="#relations-pane" type="button" role="tab" aria-controls="relations-pane" aria-selected="false">
                            <i class="bi bi-intersect"></i> ربط الفلاتر والشرائح
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2" id="media-tab" data-bs-toggle="tab" data-bs-target="#media-pane" type="button" role="tab" aria-controls="media-pane" aria-selected="false">
                            <i class="bi bi-image-fill"></i> صورة المنتج
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Tabbed Navigation Content -->
        <div class="tab-content" id="productFormTabContent">
            
            <!-- 1. Basic Details Tab -->
            <div class="tab-pane fade show active" id="basic-pane" role="tabpanel" aria-labelledby="basic-tab" tabindex="0">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">بيانات المنتج التعريفية الأساسية</h5></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6 col-sm-12">
                                <label class="form-label fw-bold">اسم المنتج</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 col-sm-12">
                                <label class="form-label fw-bold">الرابط اللطيف (Slug)</label>
                                <input type="text" name="slug" id="slug" class="form-control text-start @error('slug') is-invalid @enderror" value="{{ old('slug', $product->slug) }}" placeholder="اتركه فارغاً للتوليد التلقائي">
                                <small class="text-muted">الرابط الذي يظهر في عنوان المتصفح. مثال: `speech-box`</small>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">وصف مختصر للمنتج (يظهر بجوار كارت المنتج)</label>
                                <input type="text" name="short_description" class="form-control @error('short_description') is-invalid @enderror" value="{{ old('short_description', $product->short_description) }}" placeholder="اكتب جملة تعريفية تبرز أهم فائدة للمنتج...">
                                @error('short_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">الوصف الكامل والشرح المفصل</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="6" placeholder="اكتب تفاصيل كاملة عن المنتج وتأثيره...">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <label class="form-label fw-bold">شارة المنتج (Badge)</label>
                                <input type="text" name="badge" class="form-control" value="{{ old('badge', $product->badge) }}" placeholder="مثال: الأكثر مبيعاً، خصم، جديد">
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <label class="form-label fw-bold d-block">حالة الظهور بالمتجر</label>
                                <div class="form-check form-switch fs-5 mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $product->exists ? $product->is_active : true) ? 'checked' : '' }}>
                                    <label class="form-check-label fs-7 text-muted" for="is_active">المنتج ظاهر ومتاح للشراء الفوري في المتجر</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Price & Inventory Tab -->
            <div class="tab-pane fade" id="price-pane" role="tabpanel" aria-labelledby="price-tab" tabindex="0">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">التسعير والمخزون</h5></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6 col-sm-12">
                                <label class="form-label fw-bold">السعر الأساسي للمنتج (ج.م)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
                                    <span class="input-group-text">ج.م</span>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <label class="form-label fw-bold">سعر العرض / التخفيض (اختياري)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror" value="{{ old('sale_price', $product->sale_price) }}">
                                    <span class="input-group-text">ج.م</span>
                                </div>
                                <small class="text-muted">اتركه فارغاً في حالة عدم وجود خصم. يجب أن يكون أقل من السعر الأساسي.</small>
                                @error('sale_price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <label class="form-label fw-bold">رمز SKU للمخزون (اختياري)</label>
                                <input type="text" name="sku" class="form-control text-start @error('sku') is-invalid @enderror" value="{{ old('sku', $product->sku) }}">
                                @error('sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <label class="form-label fw-bold">نوع المنتج</label>
                                <select name="type" id="typeSelect" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="physical" {{ old('type', $product->type) === 'physical' ? 'selected' : '' }}>أداة مادية (تتطلب شحن مادي ومخزون)</option>
                                    <option value="digital" {{ old('type', $product->type) === 'digital' ? 'selected' : '' }}>شيت رقمي (ملف PDF، تحميل فوري بعد الدفع)</option>
                                    <option value="course" {{ old('type', $product->type) === 'course' ? 'selected' : '' }}>كورس تعليمي (محاضرات مسجلة)</option>
                                    <option value="session" {{ old('type', $product->type) === 'session' ? 'selected' : '' }}>جلسة استشارية (حجز وتواصل)</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 col-sm-12" id="stockContainer">
                                <label class="form-label fw-bold">كمية المخزون المتاحة</label>
                                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $product->exists ? $product->stock : 10) }}" required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <label class="form-label fw-bold">رابط فيديو الشرح اليوتيوب (اختياري)</label>
                                <input type="url" name="video_url" class="form-control text-start" value="{{ old('video_url', $product->video_url) }}" placeholder="https://www.youtube.com/embed/...">
                                <small class="text-muted">الرابط المباشر لتضمين فيديو شرح المنتج للوالدين.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Digital File Settings Tab -->
            <div class="tab-pane fade" id="digital-pane" role="tabpanel" aria-labelledby="digital-tab" tabindex="0">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">ملف الشيت الرقمي والتحميل الفوري</h5></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">ملف الشيت الرقمي (PDF / ZIP)</label>
                                <input type="file" name="digital_file" class="form-control @error('digital_file') is-invalid @enderror">
                                <small class="text-muted">سيتم تخزين هذا الملف بشكل آمن وتشفير مساره لمنع التحميل المباشر دون شراء.</small>
                                @error('digital_file')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                @if($product->digital_file_name)
                                    <div class="mt-3 p-3 bg-light rounded d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-2"></i>
                                            <span class="fw-semibold">{{ $product->digital_file_name }}</span>
                                        </div>
                                        <span class="badge bg-secondary-subtle text-secondary">ملف مرفوع مسبقاً</span>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <label class="form-label fw-bold">أقصى حد لعدد مرات التحميل لكل مشتري</label>
                                <div class="input-group">
                                    <input type="number" name="digital_download_limit" class="form-control" value="{{ old('digital_download_limit', $product->exists ? $product->digital_download_limit : 5) }}">
                                    <span class="input-group-text">مرات تحميل</span>
                                </div>
                                <small class="text-muted">الحد الأقصى لتنزيل الملف لكل مستخدم. اتركه فارغاً لجعله غير محدود.</small>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <label class="form-label fw-bold">صلاحية رابط التحميل بعد الشراء (بالأيام)</label>
                                <div class="input-group">
                                    <input type="number" name="digital_expiry_days" class="form-control" value="{{ old('digital_expiry_days', $product->exists ? $product->digital_expiry_days : 30) }}">
                                    <span class="input-group-text">يوم</span>
                                </div>
                                <small class="text-muted">ينتهي الرابط للعميل بعد مرور هذه المدة. اتركه فارغاً لجعله دائماً.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Usage & Benefits Tab -->
            <div class="tab-pane fade" id="details-pane" role="tabpanel" aria-labelledby="details-tab" tabindex="0">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">تفاصيل الاستخدام والفوائد والتوصيات</h5></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6 col-sm-12">
                                <label class="form-label fw-bold">فوائد المنتج (تنمية المهارات)</label>
                                <textarea name="benefits" class="form-control" rows="5" placeholder="اكتب كل فائدة في سطر مستقل لتقديمها بنقاط مرقمة للوالدين... مثال:&#10;تقوية عضلات اليدين والكتابة&#10;التمييز البصري بين أشكال الحروف">{{ old('benefits', $benefitsText ?? '') }}</textarea>
                                <small class="text-muted">كل سطر يمثل فائدة واحدة تظهر بشكل تعداد نقطي في صفحة المنتج.</small>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <label class="form-label fw-bold">طريقة الاستخدام بالتفصيل (دليل ارشادي للأم)</label>
                                <textarea name="how_to_use" class="form-control" rows="5" placeholder="اكتب كل خطوة في سطر مستقل لتظهر كخطوات متتالية للعميل... مثال:&#10;اجلسي مع طفلك في مكان هادئ وخالٍ من المشتتات&#10;ابدئي بكرت واحد واسأليه: ماذا يفعل الولد؟">{{ old('how_to_use', $howToUseText ?? '') }}</textarea>
                                <small class="text-muted">كل سطر يمثل خطوة مرقمة في دليل استخدام المنتج.</small>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <label class="form-label fw-bold">محتويات العلبة / الملف بالتفصيل</label>
                                <input type="text" name="whats_included" class="form-control" value="{{ old('whats_included', $product->whats_included) }}" placeholder="مثال: 150 كرت، علبة كرتونية، دليل ارشادي ورقي">
                                <small class="text-muted">ما الذي سيجده المشتري داخل الشحنة أو عند تحميل الشيت.</small>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <label class="form-label fw-bold">الفئات المناسبة (مثال: السن، نوع المشكلة)</label>
                                <input type="text" name="suitable_for" class="form-control" value="{{ old('suitable_for', $product->suitable_for) }}" placeholder="مثال: للأطفال من سن 2-6 سنوات الذين يعانون من تأخر نطق بسيط">
                                <small class="text-muted">توصيات إدارية أو طبية بسيطة ومسؤولة للفئة المستهدفة.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Target Audiences & Sync Filters Tab -->
            <div class="tab-pane fade" id="relations-pane" role="tabpanel" aria-labelledby="relations-tab" tabindex="0">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">تصنيف وربط فلاتر البحث والشرائح المستهدفة</h5></div>
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- Categories Sync -->
                            <div class="col-md-6 col-sm-12">
                                <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                                    <h6 class="fw-bold text-primary mb-0"><i class="bi bi-tag-fill me-1"></i>تصنيفات المتجر الأساسية</h6>
                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill py-0.5 px-2.5 fs-8 fw-bold" data-bs-toggle="modal" data-bs-target="#quickAddCategoryModal">
                                        <i class="bi bi-plus-lg"></i> إضافة سريعة
                                    </button>
                                </div>
                                <div class="row g-2 overflow-y-auto" id="categoriesListContainer" style="max-height: 160px;">
                                    @foreach($categories as $cat)
                                        <div class="col-12" id="cat_wrapper_{{ $cat->id }}">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $cat->id }}" id="cat_{{ $cat->id }}" {{ in_array($cat->id, old('categories', $product->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                <label class="form-check-label fs-7" for="cat_{{ $cat->id }}">{{ $cat->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Age Groups Sync -->
                            <div class="col-md-6 col-sm-12">
                                <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                                    <h6 class="fw-bold text-success mb-0"><i class="bi bi-calendar-range-fill me-1"></i>المراحل العمرية المناسبة للطفل</h6>
                                    <button type="button" class="btn btn-outline-success btn-sm rounded-pill py-0.5 px-2.5 fs-8 fw-bold" data-bs-toggle="modal" data-bs-target="#quickAddAgeGroupModal">
                                        <i class="bi bi-plus-lg"></i> إضافة سريعة
                                    </button>
                                </div>
                                <div class="row g-2 overflow-y-auto" id="ageGroupsListContainer" style="max-height: 160px;">
                                    @foreach($ageGroups as $age)
                                        <div class="col-12" id="age_wrapper_{{ $age->id }}">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="age_groups[]" value="{{ $age->id }}" id="age_{{ $age->id }}" {{ in_array($age->id, old('age_groups', $product->ageGroups->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                <label class="form-check-label fs-7" for="age_{{ $age->id }}">{{ $age->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Skills Sync -->
                            <div class="col-md-6 col-sm-12">
                                <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                                    <h6 class="fw-bold text-warning mb-0"><i class="bi bi-lightbulb-fill me-1"></i>المهارات المستهدفة للتنمية</h6>
                                    <button type="button" class="btn btn-outline-warning text-dark btn-sm rounded-pill py-0.5 px-2.5 fs-8 fw-bold" data-bs-toggle="modal" data-bs-target="#quickAddSkillModal">
                                        <i class="bi bi-plus-lg"></i> إضافة سريعة
                                    </button>
                                </div>
                                <div class="row g-2 overflow-y-auto" id="skillsListContainer" style="max-height: 160px;">
                                    @foreach($skills as $skill)
                                        <div class="col-12" id="skill_wrapper_{{ $skill->id }}">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="skills[]" value="{{ $skill->id }}" id="skill_{{ $skill->id }}" {{ in_array($skill->id, old('skills', $product->skills->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                <label class="form-check-label fs-7" for="skill_{{ $skill->id }}">{{ $skill->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Needs Sync -->
                            <div class="col-md-6 col-sm-12">
                                <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                                    <h6 class="fw-bold text-danger mb-0"><i class="bi bi-heart-pulse-fill me-1"></i>الاحتياجات الخاصة / المشكلة التي يعالجها</h6>
                                    <button type="button" class="btn btn-outline-danger btn-sm rounded-pill py-0.5 px-2.5 fs-8 fw-bold" data-bs-toggle="modal" data-bs-target="#quickAddNeedModal">
                                        <i class="bi bi-plus-lg"></i> إضافة سريعة
                                    </button>
                                </div>
                                <div class="row g-2 overflow-y-auto" id="needsListContainer" style="max-height: 160px;">
                                    @foreach($needs as $need)
                                        <div class="col-12" id="need_wrapper_{{ $need->id }}">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="needs[]" value="{{ $need->id }}" id="need_{{ $need->id }}" {{ in_array($need->id, old('needs', $product->needs->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                <label class="form-check-label fs-7" for="need_{{ $need->id }}">{{ $need->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 6. Media / Upload Image Tab -->
            <div class="tab-pane fade" id="media-pane" role="tabpanel" aria-labelledby="media-tab" tabindex="0">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">صورة المنتج وميديا العرض</h5></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-8 col-sm-12">
                                <label class="form-label fw-bold">الصورة الرئيسية للمنتج</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                <small class="text-muted">الصورة الأساسية التي تظهر في بطاقة المنتج بالمتجر (توصى بصورة مربعة ذات خلفية بيضاء وحجم أقل من 2 ميجا).</small>
                                @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 col-sm-12 text-center text-md-start">
                                @if(is_array($product->images) && !empty($product->images))
                                    <div class="p-2 border rounded d-inline-block bg-light">
                                        <label class="d-block text-muted fs-8 mb-1 text-center">الصورة الحالية:</label>
                                        <img src="{{ asset('storage/' . $product->images[0]) }}" class="object-fit-cover rounded" style="width: 140px; height: 140px;" alt="{{ $product->name }}">
                                    </div>
                                @else
                                    <div class="p-4 border border-dashed rounded text-center text-muted d-flex flex-column align-items-center justify-content-center bg-light" style="width: 140px; height: 140px;">
                                        <i class="bi bi-image fs-1 mb-1"></i>
                                        <span class="fs-8">لا توجد صورة</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Action / Save Buttons -->
        <div class="row mt-4 pt-3 border-top">
            <div class="col-12 text-end">
                <a href="{{ route('admin.products.index') }}" class="btn btn-light me-2 fw-bold">إلغاء</a>
                <button type="submit" class="btn btn-primary px-5 fw-bold">
                    <i class="bi bi-check-circle me-1"></i> {{ $product->exists ? 'حفظ التغييرات بالكامل' : 'إضافة المنتج للمتجر' }}
                </button>
            </div>
        </div>

    </form>
</div>

<!-- ========================================== -->
<!-- QUICK ADD MODALS FOR FAST TAXONOMY CREATION -->
<!-- ========================================== -->

<!-- Quick Add Category Modal -->
<div class="modal fade" id="quickAddCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-start text-rtl">
            <form id="quickCategoryForm" action="{{ route('admin.taxonomy.categories.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-folder-plus text-primary me-1"></i> إضافة تصنيف جديد سريعاً</h5>
                    <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">اسم التصنيف <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="مثال: ألعاب مونتيسوري" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">وصف مختصر</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="وصف للتصنيف..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary fw-bold">
                        <i class="bi bi-check-lg me-1"></i> حفظ وإضافة للمنتج
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Quick Add Age Group Modal -->
<div class="modal fade" id="quickAddAgeGroupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-start text-rtl">
            <form id="quickAgeGroupForm" action="{{ route('admin.taxonomy.age-groups.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-person-plus text-success me-1"></i> إضافة فئة عمرية سريعة</h5>
                    <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">اسم الفئة العمرية <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="مثال: من 7 إلى 9 سنوات" required>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label fw-semibold">العمر الأدنى</label>
                            <input type="number" step="0.5" name="min_age" class="form-control" placeholder="مثال: 7">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">العمر الأقصى</label>
                            <input type="number" step="0.5" name="max_age" class="form-control" placeholder="مثال: 9">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-success text-white fw-bold">
                        <i class="bi bi-check-lg me-1"></i> حفظ وإضافة للمنتج
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Quick Add Skill Modal -->
<div class="modal fade" id="quickAddSkillModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-start text-rtl">
            <form id="quickSkillForm" action="{{ route('admin.taxonomy.skills.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-star text-warning me-1"></i> إضافة مهارة جديدة سريعة</h5>
                    <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">اسم المهارة <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="مثال: التفكير المنطقي والتحليلي" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">الوصف</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="شرح مبسط للمهارة..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-warning text-dark fw-bold">
                        <i class="bi bi-check-lg me-1"></i> حفظ وإضافة للمنتج
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Quick Add Need Modal -->
<div class="modal fade" id="quickAddNeedModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-start text-rtl">
            <form id="quickNeedForm" action="{{ route('admin.taxonomy.needs.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-heart-pulse text-danger me-1"></i> إضافة احتياج خاص جديد</h5>
                    <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">اسم الحالة / الاحتياج <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="مثال: صعوبات القراءة والكتابة (Dyslexia)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">الوصف</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="ملاحظات وتفاصيل الحالة..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger fw-bold">
                        <i class="bi bi-check-lg me-1"></i> حفظ وإضافة للمنتج
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Toast Notification Container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
    <div id="quickToast" class="toast align-items-center text-bg-success border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body fs-7 fw-bold" id="quickToastMessage">
                <i class="bi bi-check-circle-fill me-2 fs-6"></i> تمت الإضافة وتحديد الخيار بنجاح!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
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
                .replace(/[^\w\s\u0600-\u06FF]/g, '')
                .replace(/\s+/g, '-');
            slugInput.value = slugText;
        });
    }

    // Toggle Digital Worksheet Settings Tab and fields based on type selection
    const typeSelect = document.getElementById('typeSelect');
    const digitalTabItem = document.getElementById('digital-tab-item');
    const stockContainer = document.getElementById('stockContainer');
    const stockInput = stockContainer ? stockContainer.querySelector('input') : null;

    function handleTypeToggle() {
        if (!typeSelect) return;
        const selectedValue = typeSelect.value;
        
        if (selectedValue === 'digital') {
            if (digitalTabItem) digitalTabItem.style.display = 'block';
            if (stockContainer) stockContainer.style.display = 'none';
            if (stockInput) stockInput.value = '9999';
        } else {
            if (digitalTabItem) digitalTabItem.style.display = 'none';
            if (stockContainer) stockContainer.style.display = 'block';
            if (stockInput && stockInput.value === '9999') stockInput.value = '10';
        }
    }

    if (typeSelect) {
        typeSelect.addEventListener('change', handleTypeToggle);
        handleTypeToggle();
    }

    // =========================================================================
    // AJAX Quick Add Handler for Taxonomy (Categories, AgeGroups, Skills, Needs)
    // =========================================================================
    function showToast(msg) {
        const toastEl = document.getElementById('quickToast');
        const toastMsg = document.getElementById('quickToastMessage');
        toastMsg.innerHTML = '<i class="bi bi-check-circle-fill me-2 fs-6"></i> ' + msg;
        const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
        toast.show();
    }

    function setupQuickForm(formId, modalId, containerId, inputName, prefix, labelNoun) {
        const form = document.getElementById(formId);
        if (!form) return;

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = form.querySelector('button[type="submit"]');
            const origHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> جاري الحفظ...';

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = origHtml;

                if (data.success && data.item) {
                    const item = data.item;
                    const container = document.getElementById(containerId);
                    
                    // Create new checkbox item
                    const colDiv = document.createElement('div');
                    colDiv.className = 'col-12';
                    colDiv.id = prefix + '_wrapper_' + item.id;
                    colDiv.innerHTML = `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="${inputName}[]" value="${item.id}" id="${prefix}_${item.id}" checked>
                            <label class="form-check-label fs-7 fw-bold text-success" for="${prefix}_${item.id}">${item.name} <span class="badge bg-success-subtle text-success fs-9 ms-1">جديد</span></label>
                        </div>
                    `;
                    container.prepend(colDiv);

                    // Close modal & reset form
                    const modalEl = document.getElementById(modalId);
                    const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    modalInstance.hide();
                    form.reset();

                    showToast(`تمت إضافة ${labelNoun} "<strong>${item.name}</strong>" وتحديده للمنتج بنجاح!`);
                } else {
                    alert(data.message || 'حدث خطأ أثناء الحفظ.');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = origHtml;
                alert('تعذر إتمام العملية. يرجى التأكد من ملء الحقول المطلوبة بشكل صحيح.');
            });
        });
    }

    setupQuickForm('quickCategoryForm', 'quickAddCategoryModal', 'categoriesListContainer', 'categories', 'cat', 'التصنيف');
    setupQuickForm('quickAgeGroupForm', 'quickAddAgeGroupModal', 'ageGroupsListContainer', 'age_groups', 'age', 'الفئة العمرية');
    setupQuickForm('quickSkillForm', 'quickAddSkillModal', 'skillsListContainer', 'skills', 'skill', 'المهارة');
    setupQuickForm('quickNeedForm', 'quickAddNeedModal', 'needsListContainer', 'needs', 'need', 'الاحتياج');
</script>
@endsection
