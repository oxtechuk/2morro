@extends('admin.layouts.layout')

@section('title', 'مركز إدارة التصنيفات والفلاتر | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-1"><i class="bi bi-diagram-3-fill text-primary me-2"></i>مركز إدارة التصنيفات والفلاتر</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">التصنيفات والفلاتر</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.products.importExport') }}" class="btn btn-outline-primary">
                    <i class="bi bi-file-earmark-spreadsheet me-1"></i> استيراد وتصدير المنتجات
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                    <i class="bi bi-box-seam me-1"></i> عرض كافة المنتجات
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 bg-primary bg-opacity-10 text-primary me-3">
                        <i class="bi bi-folder2-open fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 fs-7">تصنيفات المتجر</h6>
                        <h4 class="fw-bold mb-0 text-dark">{{ $stats['categories'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 bg-success bg-opacity-10 text-success me-3">
                        <i class="bi bi-person-hearts fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 fs-7">الفئات العمرية</h6>
                        <h4 class="fw-bold mb-0 text-dark">{{ $stats['age_groups'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 bg-warning bg-opacity-10 text-warning me-3">
                        <i class="bi bi-lightbulb fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 fs-7">المهارات التطويرية</h6>
                        <h4 class="fw-bold mb-0 text-dark">{{ $stats['skills'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 bg-info bg-opacity-10 text-info me-3">
                        <i class="bi bi-heart-pulse fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 fs-7">الاحتياجات الخاصة</h6>
                        <h4 class="fw-bold mb-0 text-dark">{{ $stats['needs'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill fs-5 me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <h6 class="fw-bold mb-2"><i class="bi bi-exclamation-triangle-fill me-1"></i> يرجى تصحيح الأخطاء التالية:</h6>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Tabs Navigation -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom p-3">
            <ul class="nav nav-pills nav-fill gap-2" id="taxonomyTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab === 'categories' ? 'active' : '' }} fw-bold py-2" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories-pane" type="button" role="tab">
                        <i class="bi bi-folder-fill me-1"></i> تصنيفات المتجر ({{ $categories->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab === 'age_groups' ? 'active' : '' }} fw-bold py-2" id="age_groups-tab" data-bs-toggle="tab" data-bs-target="#age_groups-pane" type="button" role="tab">
                        <i class="bi bi-person-bounding-box me-1"></i> الفئات العمرية ({{ $ageGroups->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab === 'skills' ? 'active' : '' }} fw-bold py-2" id="skills-tab" data-bs-toggle="tab" data-bs-target="#skills-pane" type="button" role="tab">
                        <i class="bi bi-stars me-1"></i> المهارات التطويرية ({{ $skills->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab === 'needs' ? 'active' : '' }} fw-bold py-2" id="needs-tab" data-bs-toggle="tab" data-bs-target="#needs-pane" type="button" role="tab">
                        <i class="bi bi-shield-heart me-1"></i> الاحتياجات الخاصة ({{ $needs->count() }})
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4">
            <div class="tab-content" id="taxonomyTabsContent">

                <!-- ========================================== -->
                <!-- 1. TAB: Categories                         -->
                <!-- ========================================== -->
                <div class="tab-pane fade {{ $activeTab === 'categories' ? 'show active' : '' }}" id="categories-pane" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-dark">قائمة تصنيفات المتجر الأساسية</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                            <i class="bi bi-plus-lg me-1"></i> إضافة تصنيف جديد
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 70px;">الصورة</th>
                                    <th>اسم التصنيف</th>
                                    <th>الرابط اللطيف (Slug)</th>
                                    <th>عدد المنتجات</th>
                                    <th>حالة الظهور</th>
                                    <th class="text-end">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $cat)
                                    <tr>
                                        <td>
                                            @if($cat->image)
                                                <img src="{{ asset('storage/' . $cat->image) }}" class="rounded shadow-sm object-fit-cover" width="48" height="48" alt="{{ $cat->name }}">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width:48px; height:48px;">
                                                    <i class="bi bi-image fs-5"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $cat->name }}</div>
                                            @if($cat->description)
                                                <small class="text-muted text-truncate d-inline-block" style="max-width: 250px;">{{ $cat->description }}</small>
                                            @endif
                                        </td>
                                        <td><code>{{ $cat->slug }}</code></td>
                                        <td>
                                            <a href="{{ route('admin.products.index', ['category' => $cat->id]) }}" class="badge bg-primary bg-opacity-10 text-primary text-decoration-none px-3 py-2 rounded-pill fw-bold">
                                                <i class="bi bi-box-seam me-1"></i> {{ $cat->products_count }} منتج
                                            </a>
                                        </td>
                                        <td>
                                            @if($cat->is_active)
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-check-circle me-1"></i> نشط</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1"><i class="bi bi-dash-circle me-1"></i> معطل</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-sm btn-outline-secondary me-1" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editCategoryModal{{ $cat->id }}">
                                                <i class="bi bi-pencil-square"></i> تعديل
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteCategoryModal{{ $cat->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Edit Category Modal -->
                                    <div class="modal fade" id="editCategoryModal{{ $cat->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content text-start text-rtl">
                                                <form action="{{ route('admin.taxonomy.categories.update', $cat->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold"><i class="bi bi-pencil me-1"></i> تعديل التصنيف: {{ $cat->name }}</h5>
                                                        <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">اسم التصنيف <span class="text-danger">*</span></label>
                                                            <input type="text" name="name" class="form-control" value="{{ $cat->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">الرابط اللطيف (Slug)</label>
                                                            <input type="text" name="slug" class="form-control" value="{{ $cat->slug }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">الوصف</label>
                                                            <textarea name="description" class="form-control" rows="3">{{ $cat->description }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">صورة التصنيف</label>
                                                            <input type="file" name="image" class="form-control" accept="image/*">
                                                            @if($cat->image)
                                                                <div class="mt-2 d-flex align-items-center gap-2">
                                                                    <img src="{{ asset('storage/' . $cat->image) }}" class="rounded" width="40" height="40" alt="">
                                                                    <small class="text-muted">الصورة الحالية</small>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="form-check form-switch mt-3">
                                                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="catActive{{ $cat->id }}" {{ $cat->is_active ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-semibold" for="catActive{{ $cat->id }}">تفعيل وظهور التصنيف بالمتجر</label>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                                                        <button type="submit" class="btn btn-primary fw-bold">حفظ التعديلات</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Category Modal -->
                                    <div class="modal fade" id="deleteCategoryModal{{ $cat->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body text-center p-4">
                                                    <div class="text-danger mb-3"><i class="bi bi-exclamation-octagon fs-1"></i></div>
                                                    <h5 class="fw-bold mb-2">تأكيد حذف التصنيف</h5>
                                                    <p class="text-muted mb-4">هل أنت متأكد من حذف تصنيف <strong>"{{ $cat->name }}"</strong>؟ (المنتجات المرتبطة لن تحذف وإنما ستفقد ربطها بهذا التصنيف فقط).</p>
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">إلغاء</button>
                                                        <form action="{{ route('admin.taxonomy.categories.destroy', $cat->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger px-4 fw-bold">نعم، تأكيد الحذف</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary"></i>
                                            لا توجد تصنيفات حالياً. قم بإضافة تصنيفك الأول!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- 2. TAB: Age Groups                         -->
                <!-- ========================================== -->
                <div class="tab-pane fade {{ $activeTab === 'age_groups' ? 'show active' : '' }}" id="age_groups-pane" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">فلتر الفئات العمرية (Age Groups)</h5>
                            <small class="text-muted">تتيح للعميل تصفية المنتجات والألعاب حسب عمر الطفل</small>
                        </div>
                        <button type="button" class="btn btn-success text-white fw-bold" data-bs-toggle="modal" data-bs-target="#addAgeGroupModal">
                            <i class="bi bi-plus-lg me-1"></i> إضافة فئة عمرية
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>اسم الفئة العمرية</th>
                                    <th>الرابط اللطيف (Slug)</th>
                                    <th>المدى العمري</th>
                                    <th>عدد المنتجات المرتبطة</th>
                                    <th class="text-end">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ageGroups as $ag)
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark"><i class="bi bi-person-fill text-success me-1"></i> {{ $ag->name }}</div>
                                        </td>
                                        <td><code>{{ $ag->slug }}</code></td>
                                        <td>
                                            @if($ag->min_age !== null || $ag->max_age !== null)
                                                <span class="badge bg-light text-dark border">
                                                    {{ $ag->min_age ?? 0 }} إلى {{ $ag->max_age ?? '∞' }} سنة
                                                </span>
                                            @else
                                                <span class="text-muted fs-7">غير محدد</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-bold">
                                                {{ $ag->products_count }} منتج
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-sm btn-outline-secondary me-1" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editAgeGroupModal{{ $ag->id }}">
                                                <i class="bi bi-pencil-square"></i> تعديل
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteAgeGroupModal{{ $ag->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Edit Age Group Modal -->
                                    <div class="modal fade" id="editAgeGroupModal{{ $ag->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content text-start text-rtl">
                                                <form action="{{ route('admin.taxonomy.age-groups.update', $ag->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold">تعديل الفئة العمرية: {{ $ag->name }}</h5>
                                                        <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">اسم الفئة العمرية <span class="text-danger">*</span></label>
                                                            <input type="text" name="name" class="form-control" value="{{ $ag->name }}" placeholder="مثال: 3-5 سنوات" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">الرابط اللطيف (Slug)</label>
                                                            <input type="text" name="slug" class="form-control" value="{{ $ag->slug }}">
                                                        </div>
                                                        <div class="row g-2">
                                                            <div class="col-6">
                                                                <label class="form-label fw-semibold">العمر الأدنى (سنوات)</label>
                                                                <input type="number" step="0.5" name="min_age" class="form-control" value="{{ $ag->min_age }}">
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="form-label fw-semibold">العمر الأقصى (سنوات)</label>
                                                                <input type="number" step="0.5" name="max_age" class="form-control" value="{{ $ag->max_age }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                                                        <button type="submit" class="btn btn-success text-white fw-bold">حفظ التعديلات</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Age Group Modal -->
                                    <div class="modal fade" id="deleteAgeGroupModal{{ $ag->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body text-center p-4">
                                                    <div class="text-danger mb-3"><i class="bi bi-exclamation-octagon fs-1"></i></div>
                                                    <h5 class="fw-bold mb-2">تأكيد حذف الفئة العمرية</h5>
                                                    <p class="text-muted mb-4">هل أنت متأكد من حذف <strong>"{{ $ag->name }}"</strong>؟</p>
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">إلغاء</button>
                                                        <form action="{{ route('admin.taxonomy.age-groups.destroy', $ag->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger px-4 fw-bold">نعم، حذف</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            لا توجد فئات عمرية مضافة حالياً.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- 3. TAB: Skills                             -->
                <!-- ========================================== -->
                <div class="tab-pane fade {{ $activeTab === 'skills' ? 'show active' : '' }}" id="skills-pane" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">فلتر المهارات التطويرية (Skills)</h5>
                            <small class="text-muted">المهارات الذهنية، الحركية، اللغوية، والاجتماعية التي ينميها المنتج</small>
                        </div>
                        <button type="button" class="btn btn-warning text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#addSkillModal">
                            <i class="bi bi-plus-lg me-1"></i> إضافة مهارة جديدة
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>اسم المهارة</th>
                                    <th>الرابط اللطيف (Slug)</th>
                                    <th>الوصف والمجال</th>
                                    <th>عدد المنتجات المرتبطة</th>
                                    <th class="text-end">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($skills as $sk)
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark"><i class="bi bi-star-fill text-warning me-1"></i> {{ $sk->name }}</div>
                                        </td>
                                        <td><code>{{ $sk->slug }}</code></td>
                                        <td>
                                            <span class="text-muted fs-7">{{ $sk->description ?? '—' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning bg-opacity-10 text-dark px-3 py-2 rounded-pill fw-bold">
                                                {{ $sk->products_count }} منتج
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-sm btn-outline-secondary me-1" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editSkillModal{{ $sk->id }}">
                                                <i class="bi bi-pencil-square"></i> تعديل
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteSkillModal{{ $sk->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Edit Skill Modal -->
                                    <div class="modal fade" id="editSkillModal{{ $sk->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content text-start text-rtl">
                                                <form action="{{ route('admin.taxonomy.skills.update', $sk->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold">تعديل المهارة: {{ $sk->name }}</h5>
                                                        <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">اسم المهارة <span class="text-danger">*</span></label>
                                                            <input type="text" name="name" class="form-control" value="{{ $sk->name }}" placeholder="مثال: التفكير الإبداعي" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">الرابط اللطيف (Slug)</label>
                                                            <input type="text" name="slug" class="form-control" value="{{ $sk->slug }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">الوصف</label>
                                                            <textarea name="description" class="form-control" rows="3">{{ $sk->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                                                        <button type="submit" class="btn btn-warning text-dark fw-bold">حفظ التعديلات</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Skill Modal -->
                                    <div class="modal fade" id="deleteSkillModal{{ $sk->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body text-center p-4">
                                                    <div class="text-danger mb-3"><i class="bi bi-exclamation-octagon fs-1"></i></div>
                                                    <h5 class="fw-bold mb-2">تأكيد حذف المهارة</h5>
                                                    <p class="text-muted mb-4">هل أنت متأكد من حذف مهارة <strong>"{{ $sk->name }}"</strong>؟</p>
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">إلغاء</button>
                                                        <form action="{{ route('admin.taxonomy.skills.destroy', $sk->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger px-4 fw-bold">نعم، حذف</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            لا توجد مهارات مضافة حالياً.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- 4. TAB: Special Needs                      -->
                <!-- ========================================== -->
                <div class="tab-pane fade {{ $activeTab === 'needs' ? 'show active' : '' }}" id="needs-pane" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">فلتر الاحتياجات الخاصة والتطورية (Special Needs)</h5>
                            <small class="text-muted">لتخصيص المنتجات والأدوات المناسبة لحالات محددة (ADHD، التوحد، صعوبات التعلم...)</small>
                        </div>
                        <button type="button" class="btn btn-info text-white fw-bold" data-bs-toggle="modal" data-bs-target="#addNeedModal">
                            <i class="bi bi-plus-lg me-1"></i> إضافة احتياج جديد
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>اسم الحالة / الاحتياج</th>
                                    <th>الرابط اللطيف (Slug)</th>
                                    <th>الوصف والتفاصيل</th>
                                    <th>عدد المنتجات المرتبطة</th>
                                    <th class="text-end">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($needs as $nd)
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark"><i class="bi bi-heart-pulse-fill text-info me-1"></i> {{ $nd->name }}</div>
                                        </td>
                                        <td><code>{{ $nd->slug }}</code></td>
                                        <td>
                                            <span class="text-muted fs-7">{{ $nd->description ?? '—' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill fw-bold">
                                                {{ $nd->products_count }} منتج
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-sm btn-outline-secondary me-1" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editNeedModal{{ $nd->id }}">
                                                <i class="bi bi-pencil-square"></i> تعديل
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteNeedModal{{ $nd->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Edit Need Modal -->
                                    <div class="modal fade" id="editNeedModal{{ $nd->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content text-start text-rtl">
                                                <form action="{{ route('admin.taxonomy.needs.update', $nd->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold">تعديل الاحتياج: {{ $nd->name }}</h5>
                                                        <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">اسم الاحتياج / الفئة <span class="text-danger">*</span></label>
                                                            <input type="text" name="name" class="form-control" value="{{ $nd->name }}" placeholder="مثال: فرط الحركة وتشتت الانتباه" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">الرابط اللطيف (Slug)</label>
                                                            <input type="text" name="slug" class="form-control" value="{{ $nd->slug }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">الوصف</label>
                                                            <textarea name="description" class="form-control" rows="3">{{ $nd->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                                                        <button type="submit" class="btn btn-info text-white fw-bold">حفظ التعديلات</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Need Modal -->
                                    <div class="modal fade" id="deleteNeedModal{{ $nd->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body text-center p-4">
                                                    <div class="text-danger mb-3"><i class="bi bi-exclamation-octagon fs-1"></i></div>
                                                    <h5 class="fw-bold mb-2">تأكيد حذف الاحتياج</h5>
                                                    <p class="text-muted mb-4">هل أنت متأكد من حذف <strong>"{{ $nd->name }}"</strong>؟</p>
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">إلغاء</button>
                                                        <form action="{{ route('admin.taxonomy.needs.destroy', $nd->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger px-4 fw-bold">نعم، حذف</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            لا توجد احتياجات مضافة حالياً.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- CREATE MODALS FOR ALL TAXONOMIES           -->
<!-- ========================================== -->

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-start text-rtl">
            <form action="{{ route('admin.taxonomy.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-folder-plus text-primary me-1"></i> إضافة تصنيف جديد</h5>
                    <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">اسم التصنيف <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="مثال: ألعاب تنمية المهارات" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">الرابط اللطيف (Slug)</label>
                        <input type="text" name="slug" class="form-control" placeholder="اتركه فارغاً للتوليد التلقائي">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">الوصف</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="وصف قصير للتصنيف..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">صورة التصنيف</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="newCatActive" checked>
                        <label class="form-check-label fw-semibold" for="newCatActive">تفعيل وظهور التصنيف بالمتجر</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-check-lg me-1"></i> حفظ التصنيف</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Age Group Modal -->
<div class="modal fade" id="addAgeGroupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-start text-rtl">
            <form action="{{ route('admin.taxonomy.age-groups.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-person-plus text-success me-1"></i> إضافة فئة عمرية جديدة</h5>
                    <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">اسم الفئة العمرية <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="مثال: من 3 إلى 5 سنوات" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">الرابط اللطيف (Slug)</label>
                        <input type="text" name="slug" class="form-control" placeholder="اتركه فارغاً للتوليد التلقائي">
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label fw-semibold">العمر الأدنى (سنوات)</label>
                            <input type="number" step="0.5" name="min_age" class="form-control" placeholder="مثال: 3">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">العمر الأقصى (سنوات)</label>
                            <input type="number" step="0.5" name="max_age" class="form-control" placeholder="مثال: 5">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-success text-white fw-bold"><i class="bi bi-check-lg me-1"></i> إضافة الفئة</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Skill Modal -->
<div class="modal fade" id="addSkillModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-start text-rtl">
            <form action="{{ route('admin.taxonomy.skills.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-star text-warning me-1"></i> إضافة مهارة جديدة</h5>
                    <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">اسم المهارة <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="مثال: المهارات الحركية الدقيقة" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">الرابط اللطيف (Slug)</label>
                        <input type="text" name="slug" class="form-control" placeholder="اتركه فارغاً للتوليد التلقائي">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">الوصف</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="شرح مبسط للمهارة وأهميتها..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-warning text-dark fw-bold"><i class="bi bi-check-lg me-1"></i> إضافة المهارة</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Need Modal -->
<div class="modal fade" id="addNeedModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-start text-rtl">
            <form action="{{ route('admin.taxonomy.needs.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-heart-pulse text-info me-1"></i> إضافة احتياج خاص جديد</h5>
                    <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">اسم الاحتياج / الحالة <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="مثال: طيف التوحد (Autism)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">الرابط اللطيف (Slug)</label>
                        <input type="text" name="slug" class="form-control" placeholder="اتركه فارغاً للتوليد التلقائي">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">الوصف</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="ملاحظات توجيهية عن المنتجات المناسبة لهذا الاحتياج..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-info text-white fw-bold"><i class="bi bi-check-lg me-1"></i> إضافة الاحتياج</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
