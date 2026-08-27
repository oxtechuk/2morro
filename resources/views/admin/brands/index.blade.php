@extends('admin.layouts.layout')

@section('title', 'إدارة البراندات والشركاء | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">
    
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">إدارة البراندات والشركاء التعليميين</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page">الشريط المائل للبراندات</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary fw-bold shadow-xs">
                <i class="bi bi-eye me-1"></i> معاينة بالرئيسية
            </a>
            <button type="button" class="btn btn-primary fw-bold shadow-xs" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                <i class="bi bi-plus-lg me-1"></i> إضافة براند / شريك جديد
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show fw-bold shadow-xs" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Quick Stats -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-xs">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <span class="text-muted small fw-bold d-block">إجمالي البراندات</span>
                        <h4 class="fw-bold text-dark mb-0">{{ $stats['total'] }}</h4>
                    </div>
                    <div class="w-11 h-11 rounded-3 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fs-4">
                        <i class="bi bi-patch-check-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-xs">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <span class="text-muted small fw-bold d-block">الشريط العلوي (Row 1)</span>
                        <h4 class="fw-bold text-primary mb-0">{{ $stats['top_row'] }}</h4>
                    </div>
                    <div class="w-11 h-11 rounded-3 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fs-4">
                        <i class="bi bi-arrow-left-right"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-xs">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <span class="text-muted small fw-bold d-block">الشريط السفلي (Row 2)</span>
                        <h4 class="fw-bold text-info mb-0">{{ $stats['bottom_row'] }}</h4>
                    </div>
                    <div class="w-11 h-11 rounded-3 bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center fs-4">
                        <i class="bi bi-arrow-left-right"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-xs">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <span class="text-muted small fw-bold d-block">البراندات النشطة</span>
                        <h4 class="fw-bold text-success mb-0">{{ $stats['active'] }}</h4>
                    </div>
                    <div class="w-11 h-11 rounded-3 bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center fs-4">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Brands Table Card -->
    <div class="card shadow-xs border-0">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="mb-0 fw-bold text-dark">
                <i class="bi bi-grid-fill text-primary me-2"></i> قائمة الشعارات المعروضة في الشريطين المتحركين ({{ $brands->total() }})
            </h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th style="width: 130px;">شعار البراند</th>
                        <th class="text-end">اسم البراند / الشريك</th>
                        <th>مكان العرض</th>
                        <th class="text-start">رابط الفلترة / التوجيه</th>
                        <th>الحالة</th>
                        <th style="width: 140px;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($brands as $brand)
                        <tr>
                            <td>
                                <span class="badge bg-light text-muted border px-2 py-1.5 fw-bold font-mono">
                                    #{{ $brand->sort_order }}
                                </span>
                            </td>
                            <td>
                                <div class="rounded-3 border bg-light p-2 mx-auto d-flex align-items-center justify-content-center" style="width: 110px; height: 55px;">
                                    <img src="{{ asset($brand->logo) }}" alt="{{ $brand->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                </div>
                            </td>
                            <td class="text-end">
                                <h6 class="mb-0 fw-bold text-dark">{{ $brand->name }}</h6>
                                <small class="text-muted font-mono">{{ $brand->slug }}</small>
                            </td>
                            <td>
                                @if($brand->row === 'top')
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 fw-bold">
                                        <i class="bi bi-arrow-up-right me-1"></i> الشريط العلوي (Row 1)
                                    </span>
                                @else
                                    <span class="badge bg-info-subtle text-info border border-info-subtle px-2.5 py-1 fw-bold">
                                        <i class="bi bi-arrow-down-left me-1"></i> الشريط السفلي (Row 2)
                                    </span>
                                @endif
                            </td>
                            <td class="text-start">
                                <a href="{{ $brand->target_url }}" target="_blank" class="small text-decoration-none fw-bold text-truncate d-inline-block" style="max-width: 250px;">
                                    <i class="bi bi-link-45deg me-1"></i> {{ $brand->link ?: ($brand->filter_keyword ? 'فلترة: ' . $brand->filter_keyword : 'بحث بالاسم') }}
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('admin.brands.toggleStatus', $brand) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $brand->is_active ? 'btn-success' : 'btn-secondary' }} px-3 py-1 fw-bold rounded-pill">
                                        {{ $brand->is_active ? 'نشط' : 'معطل' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="btn-group shadow-xs">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editBrandModal{{ $brand->id }}" title="تعديل">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteBrandModal{{ $brand->id }}" title="حذف">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Brand Modal -->
                        <div class="modal fade" id="editBrandModal{{ $brand->id }}" tabindex="-1" aria-labelledby="editBrandModalLabel{{ $brand->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content text-start text-end">
                                    <form action="{{ route('admin.brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold" id="editBrandModalLabel{{ $brand->id }}">تعديل بيانات البراند: {{ $brand->name }}</h5>
                                            <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body space-y-3">
                                            
                                            <div class="mb-3 text-end">
                                                <label class="form-label fw-bold">اسم البراند / الشريك <span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control" value="{{ $brand->name }}" required>
                                            </div>

                                            <div class="mb-3 text-end">
                                                <label class="form-label fw-bold">الشريط المخصص للعرض <span class="text-danger">*</span></label>
                                                <select name="row" class="form-select" required>
                                                    <option value="top" {{ $brand->row === 'top' ? 'selected' : '' }}>الشريط العلوي (Row 1 - اتجاه اليمين)</option>
                                                    <option value="bottom" {{ $brand->row === 'bottom' ? 'selected' : '' }}>الشريط السفلي (Row 2 - اتجاه اليسار)</option>
                                                </select>
                                            </div>

                                            <div class="mb-3 text-end">
                                                <label class="form-label fw-bold">تغيير صورة الشعار (Logo)</label>
                                                <input type="file" name="logo_file" class="form-control mb-2" accept="image/*">
                                                <div class="p-2 border rounded bg-light text-center">
                                                    <img src="{{ asset($brand->logo) }}" alt="Logo Preview" style="max-height: 50px; object-fit: contain;">
                                                </div>
                                            </div>

                                            <div class="mb-3 text-end">
                                                <label class="form-label fw-bold">رابط التوجيه المخصص (Link - اختياري)</label>
                                                <input type="text" name="link" class="form-control text-start" dir="ltr" value="{{ $brand->link }}" placeholder="مثال: /search?category=educational-tools">
                                            </div>

                                            <div class="mb-3 text-end">
                                                <label class="form-label fw-bold">أو كلمة فلترة البحث (Filter Keyword)</label>
                                                <input type="text" name="filter_keyword" class="form-control" value="{{ $brand->filter_keyword }}" placeholder="مثال: تخاطب / ألعاب">
                                            </div>

                                            <div class="mb-3 text-end">
                                                <label class="form-label fw-bold">الترتيب</label>
                                                <input type="number" name="sort_order" class="form-control" value="{{ $brand->sort_order }}">
                                            </div>

                                            <div class="form-check form-switch text-end">
                                                <input class="form-check-input ms-2 me-0" type="checkbox" name="is_active" id="editActive{{ $brand->id }}" value="1" {{ $brand->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="editActive{{ $brand->id }}">تفعيل وظهور البراند في الشريط</label>
                                            </div>

                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                                            <button type="submit" class="btn btn-primary fw-bold px-4">حفظ التعديلات</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Brand Modal -->
                        <div class="modal fade" id="deleteBrandModal{{ $brand->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content text-center p-3">
                                    <div class="w-12 h-12 rounded-circle bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center fs-3 mx-auto mb-2">
                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1">هل أنت متأكد من الحذف؟</h6>
                                    <p class="text-muted small mb-3">سيتم حذف شعار براند <b>{{ $brand->name }}</b> نهائياً من الشريط المتحرك.</p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-light btn-sm px-3" data-bs-dismiss="modal">إلغاء</button>
                                        <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm px-3 fw-bold">نعم، احذف</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="7" class="py-5 text-center text-muted">
                                <i class="bi bi-patch-exclamation fs-1 d-block mb-2 text-warning"></i>
                                لا توجد براندات مضافة حالياً.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($brands->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $brands->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Add Brand Modal -->
<div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-end">
            <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="addBrandModalLabel">إضافة براند / شريك جديد</h5>
                    <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body space-y-3">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">اسم البراند / الشريك <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="مثال: Kids Party" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">الشريط المخصص للعرض <span class="text-danger">*</span></label>
                        <select name="row" class="form-select" required>
                            <option value="top">الشريط العلوي (Row 1 - اتجاه اليمين)</option>
                            <option value="bottom">الشريط السفلي (Row 2 - اتجاه اليسار)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">صورة شعار البراند (Logo File) <span class="text-danger">*</span></label>
                        <input type="file" name="logo_file" class="form-control" accept="image/*" required>
                        <small class="text-muted">يفضل صورة شفافة PNG أو بيضاء واضحة بدقة مناسبة.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">رابط التوجيه المخصص (Link - اختياري)</label>
                        <input type="text" name="link" class="form-control text-start" dir="ltr" placeholder="مثال: /search?category=educational-tools">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">أو كلمة فلترة البحث (Filter Keyword - اختياري)</label>
                        <input type="text" name="filter_keyword" class="form-control" placeholder="مثال: ألعاب / شيتات">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">الترتيب</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input ms-2 me-0" type="checkbox" name="is_active" id="newActive" value="1" checked>
                        <label class="form-check-label fw-bold" for="newActive">تفعيل وظهور البراند مباشرة في الشريط</label>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4">إضافة وتثبيت البراند</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
