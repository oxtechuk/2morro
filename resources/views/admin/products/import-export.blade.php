@extends('admin.layouts.layout')

@section('title', 'استيراد وتصدير المنتجات بإكسيل | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-1"><i class="bi bi-file-earmark-spreadsheet-fill text-success me-2"></i>استيراد وتصدير المنتجات مجمعة (Excel & CSV)</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">المنتجات</a></li>
                        <li class="breadcrumb-item active" aria-current="page">استيراد وتصدير</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.products.template') }}" class="btn btn-outline-success fw-bold">
                    <i class="bi bi-cloud-arrow-down-fill me-1"></i> تحميل نموذج Excel فارغ
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                    <i class="bi bi-box-seam me-1"></i> العودة للمنتجات
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-3 mb-4">
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-3 text-center">
                    <span class="text-muted fs-7 d-block mb-1">إجمالي المنتجات</span>
                    <h4 class="fw-bold mb-0 text-dark">{{ $stats['total'] }}</h4>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-3 text-center">
                    <span class="text-muted fs-7 d-block mb-1">أدوات مادية (شحن)</span>
                    <h4 class="fw-bold mb-0 text-primary">{{ $stats['physical'] }}</h4>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-3 text-center">
                    <span class="text-muted fs-7 d-block mb-1">ملفات رقمية</span>
                    <h4 class="fw-bold mb-0 text-info">{{ $stats['digital'] }}</h4>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-3 text-center">
                    <span class="text-muted fs-7 d-block mb-1">كورسات تعليمية</span>
                    <h4 class="fw-bold mb-0 text-warning">{{ $stats['course'] }}</h4>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-3 text-center">
                    <span class="text-muted fs-7 d-block mb-1">جلسات واستشارات</span>
                    <h4 class="fw-bold mb-0 text-success">{{ $stats['session'] }}</h4>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-3 text-center">
                    <span class="text-muted fs-7 d-block mb-1">التصنيفات المتاحة</span>
                    <h4 class="fw-bold mb-0 text-purple" style="color: #8b5cf6;">{{ $categories->count() }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill fs-4 me-2"></i>
            <div>
                <strong>نجاح!</strong> {{ session('success') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
            <div>
                <strong>تنبيه:</strong> {{ session('warning') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-x-circle-fill fs-4 me-2"></i>
            <div>
                <strong>خطأ:</strong> {{ session('error') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Import Summary Report (If Available) -->
    @if(session('import_summary'))
        @php $summary = session('import_summary'); @endphp
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden border-start border-4 border-success">
            <div class="card-header bg-light p-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-clipboard-check-fill text-success me-2"></i>تقرير نتائج عملية الاستيراد</h5>
                <span class="badge bg-dark px-3 py-2">إجمالي المعالجة: {{ $summary['total'] }}</span>
            </div>
            <div class="card-body p-4">
                <div class="row g-3 text-center mb-3">
                    <div class="col-md-4">
                        <div class="p-3 bg-success bg-opacity-10 rounded-3">
                            <span class="text-success fw-bold fs-7 d-block">منتجات جديدة تمت إضافتها</span>
                            <h3 class="fw-bold text-success mb-0">+{{ $summary['created'] }}</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-primary bg-opacity-10 rounded-3">
                            <span class="text-primary fw-bold fs-7 d-block">منتجات قائمة تم تحديثها</span>
                            <h3 class="fw-bold text-primary mb-0">{{ $summary['updated'] }}</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-danger bg-opacity-10 rounded-3">
                            <span class="text-danger fw-bold fs-7 d-block">صفوف بها أخطاء</span>
                            <h3 class="fw-bold text-danger mb-0">{{ count($summary['errors']) }}</h3>
                        </div>
                    </div>
                </div>

                @if(!empty($summary['errors']))
                    <div class="alert alert-danger mb-0">
                        <h6 class="fw-bold mb-2"><i class="bi bi-exclamation-triangle-fill me-1"></i> قائمة الأخطاء والصفوف التي تم تخطيها:</h6>
                        <ul class="mb-0 ps-3">
                            @foreach($summary['errors'] as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <div class="row g-4">
        <!-- ========================================== -->
        <!-- 1. EXPORT PRODUCTS SECTION                 -->
        <!-- ========================================== -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom p-4">
                    <div class="d-flex align-items-center">
                        <div class="rounded-3 bg-success bg-opacity-10 p-3 text-success me-3">
                            <i class="bi bi-file-earmark-arrow-down-fill fs-3"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-dark">1. تصدير المنتجات (Export)</h5>
                            <p class="text-muted mb-0 fs-7">تصدير جميع منتجات المتجر أو فلترة بيانات محددة وتنزيلها بصيغة Excel أو CSV.</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.products.export') }}" method="GET" target="_blank">
                        <div class="mb-3">
                            <label class="form-label fw-semibold fs-7">البحث بكلمة مفتاحية أو SKU</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control" placeholder="اتركه فارغاً لتصدير الكل...">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold fs-7">تصنيف المتجر</label>
                                <select name="category_id" class="form-select">
                                    <option value="">كل التصنيفات (الكل)</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold fs-7">نوع المنتج</label>
                                <select name="type" class="form-select">
                                    <option value="">كل الأنواع</option>
                                    <option value="physical">أداة مادية (شحن)</option>
                                    <option value="digital">ملف رقمي (تحميل)</option>
                                    <option value="course">كورس تعليمي</option>
                                    <option value="session">جلسة استشارية</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold fs-7">حالة النشر</label>
                            <select name="status" class="form-select">
                                <option value="">الكل (النشط والمعطل)</option>
                                <option value="active">المنتجات النشطة فقط</option>
                                <option value="inactive">المنتجات المعطلة فقط</option>
                            </select>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" name="format" value="xlsx" class="btn btn-success fw-bold flex-grow-1 py-2">
                                <i class="bi bi-file-earmark-excel-fill me-1"></i> تصدير ملف Excel (.xlsx)
                            </button>
                            <button type="submit" name="format" value="csv" class="btn btn-outline-success fw-bold flex-grow-1 py-2">
                                <i class="bi bi-filetype-csv me-1"></i> تصدير CSV (.csv)
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <!-- Template Card Section -->
                    <div class="p-3 bg-light rounded-3 d-flex align-items-center justify-content-between flex-wrap gap-2 border">
                        <div>
                            <h6 class="fw-bold mb-1 text-dark"><i class="bi bi-info-circle-fill text-primary me-1"></i> هل تريد إضافة منتجات جديدة؟</h6>
                            <small class="text-muted">قم بتنزيل النموذج الإرشادي الفارغ وتعبئته ثم رفعه في قسم الاستيراد.</small>
                        </div>
                        <a href="{{ route('admin.products.template') }}" class="btn btn-sm btn-primary fw-bold px-3 py-2">
                            <i class="bi bi-download me-1"></i> تنزيل القالب
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- 2. IMPORT PRODUCTS SECTION                 -->
        <!-- ========================================== -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom p-4">
                    <div class="d-flex align-items-center">
                        <div class="rounded-3 bg-primary bg-opacity-10 p-3 text-primary me-3">
                            <i class="bi bi-file-earmark-arrow-up-fill fs-3"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-dark">2. استيراد المنتجات المجمعة (Import)</h5>
                            <p class="text-muted mb-0 fs-7">رفع ملف Excel أو CSV لإضافة مئات المنتجات وتحديث المخزون والأسعار دفعة واحدة.</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                        @csrf

                        <!-- Dropzone styled area -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">اختر ملف الإكسيل أو اسحبه هنا <span class="text-danger">*</span></label>
                            <div class="border border-2 border-dashed rounded-4 p-4 text-center bg-light position-relative" id="dropArea" style="cursor: pointer;">
                                <i class="bi bi-cloud-arrow-up-fill text-primary display-4 mb-2 d-block"></i>
                                <h6 class="fw-bold text-dark mb-1" id="fileNameDisplay">اسحب الملف وأفلته هنا، أو اضغط للاختيار</h6>
                                <p class="text-muted fs-7 mb-0">الصيغ المدعومة: <code>.xlsx</code>, <code>.xls</code>, <code>.csv</code> (أقصى حجم: 20MB)</p>
                                <input type="file" name="excel_file" id="excelFileInput" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" accept=".xlsx,.xls,.csv" required>
                            </div>
                        </div>

                        <!-- Smart Features Information -->
                        <div class="mb-4">
                            <h6 class="fw-bold fs-7 text-dark mb-2"><i class="bi bi-magic text-warning me-1"></i> مزايا المعالجة الذكية في تمورو:</h6>
                            <ul class="list-unstyled fs-7 text-muted mb-0">
                                <li class="mb-1"><i class="bi bi-check2-circle text-success me-1"></i> <strong>التحديث التلقائي (Upsert):</strong> إذا كان الـ SKU أو ID موجوداً سيتم تحديث السعر والمخزون، وإلا سيتم إنشاء منتج جديد.</li>
                                <li class="mb-1"><i class="bi bi-check2-circle text-success me-1"></i> <strong>الربط الآلي للفلاتر:</strong> يتم إنشاء وربط التصنيفات، الفئات العمرية، المهارات، والاحتياجات الخاصة تلقائياً.</li>
                                <li class="mb-1"><i class="bi bi-check2-circle text-success me-1"></i> <strong>الترميز العربي السليم:</strong> دعم كامل للغة العربية دون أي تشويه في النصوص.</li>
                            </ul>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2 fs-6" id="submitImportBtn">
                            <i class="bi bi-upload me-1"></i> بدء عملية الاستيراد والمعالجة
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('excelFileInput');
        const fileNameDisplay = document.getElementById('fileNameDisplay');
        const dropArea = document.getElementById('dropArea');
        const form = document.getElementById('importForm');
        const submitBtn = document.getElementById('submitImportBtn');

        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileNameDisplay.innerHTML = '<span class="text-success fw-bold"><i class="bi bi-file-earmark-check-fill me-1"></i> تم اختيار: ' + this.files[0].name + '</span>';
                dropArea.classList.add('border-success');
            }
        });

        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> جاري معالجة واستيراد البيانات، يرجى الانتظار...';
        });
    });
</script>
@endsection
