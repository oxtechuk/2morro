@extends('admin.layouts.layout')

@section('title', 'شروحات الدكتور والريلز | لوحة التحكم تمورو')

@section('content')
<div class="container-fluid p-0">

    <!-- 1. Hero Control Header -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" 
         style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #1e3a8a 100%); color: #ffffff;">
        <div class="card-body p-4 p-md-5 d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-4">
            <div>
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-white bg-opacity-10 border border-white border-opacity-20 text-white fs-7 fw-bold mb-3 shadow-xs">
                    <span class="badge rounded-circle p-1 bg-danger" style="width: 8px; height: 8px; display: inline-block;"></span>
                    <span>مركز شروحات وريلز الدكتور • منصة فيديو تمورو التفاعلية</span>
                </div>
                <h2 class="fw-black mb-1 text-white" style="font-size: 1.75rem;">إدارة شروحات الدكتور ومقاطع الريلز</h2>
                <p class="text-white text-opacity-75 fs-6 mb-0">رفع فيديوهات الشروحات الطبية والسلوكية والريلز السريعة، وتصنيفها حسب عمر الطفل والمشكلة، وإدارة الوصول المجاني والمدفوع.</p>
            </div>

            <!-- Quick Action Buttons -->
            <div class="d-flex flex-wrap gap-2.5">
                <a href="{{ route('admin.doctor-videos.create') }}" class="btn btn-primary fw-bold fs-7 rounded-3 px-3 py-2 shadow-sm d-flex align-items-center gap-2 hover-scale">
                    <i class="bi bi-cloud-arrow-up-fill fs-5"></i>
                    <span>رفع فيديو / ريلز جديد</span>
                </a>
                <a href="{{ route('admin.doctor-videos.gallery') }}" class="btn btn-outline-light bg-white bg-opacity-10 border-white border-opacity-25 fw-bold fs-7 rounded-3 px-3 py-2 text-white d-flex align-items-center gap-2">
                    <i class="bi bi-images"></i>
                    <span>معرض الميديا</span>
                </a>
                <a href="{{ route('admin.doctor-videos.purchases') }}" class="btn btn-outline-light bg-white bg-opacity-10 border-white border-opacity-25 fw-bold fs-7 rounded-3 px-3 py-2 text-white d-flex align-items-center gap-2">
                    <i class="bi bi-wallet2"></i>
                    <span>سجل المبيعات</span>
                </a>
                @if(Route::has('doctor-videos.index'))
                <a href="{{ route('doctor-videos.index') }}" target="_blank" class="btn btn-outline-light bg-white bg-opacity-10 border-white border-opacity-25 fw-bold fs-7 rounded-3 px-3 py-2 text-white d-flex align-items-center gap-2">
                    <i class="bi bi-box-arrow-up-right"></i>
                    <span>عرض واجهة يوتيوب</span>
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- 2. KPIs Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fs-7 fw-bold">إجمالي الفيديوهات</span>
                    <span class="p-2 rounded-3 bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-collection-play-fill fs-5"></i>
                    </span>
                </div>
                <h3 class="fw-black text-dark mb-0">{{ number_format($stats['total']) }}</h3>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fs-7 fw-bold">مقاطع ريلز (9:16)</span>
                    <span class="p-2 rounded-3 bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-phone-fill fs-5"></i>
                    </span>
                </div>
                <h3 class="fw-black text-dark mb-0">{{ number_format($stats['reels']) }}</h3>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fs-7 fw-bold">شروحات كاملة (16:9)</span>
                    <span class="p-2 rounded-3 bg-info bg-opacity-10 text-info">
                        <i class="bi bi-display fs-5"></i>
                    </span>
                </div>
                <h3 class="fw-black text-dark mb-0">{{ number_format($stats['standard']) }}</h3>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fs-7 fw-bold">شروحات مدفوعة</span>
                    <span class="p-2 rounded-3 bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-lock-fill fs-5"></i>
                    </span>
                </div>
                <h3 class="fw-black text-dark mb-0">{{ number_format($stats['paid']) }}</h3>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fs-7 fw-bold">إجمالي المشاهدات</span>
                    <span class="p-2 rounded-3 bg-success bg-opacity-10 text-success">
                        <i class="bi bi-eye-fill fs-5"></i>
                    </span>
                </div>
                <h3 class="fw-black text-dark mb-0">{{ number_format($stats['views']) }}</h3>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fs-7 fw-bold">إيرادات المشاهدات</span>
                    <span class="p-2 rounded-3 bg-purple bg-opacity-10 text-primary">
                        <i class="bi bi-currency-dollar fs-5"></i>
                    </span>
                </div>
                <h3 class="fw-black text-success mb-0">{{ number_format($stats['revenue'], 2) }} <small class="fs-8 text-muted">ج.م</small></h3>
            </div>
        </div>
    </div>

    <!-- 3. Filters & Search Box -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3 p-md-4">
            <form action="{{ route('admin.doctor-videos.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fs-7 fw-bold text-muted">بحث بالعنوان أو الكلمات الدلالية</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0" placeholder="مثال: تأخر الكلام، فرط الحركة...">
                    </div>
                </div>

                <div class="col-md-2 col-sm-6">
                    <label class="form-label fs-7 fw-bold text-muted">نوع الفيديو</label>
                    <select name="type" class="form-select">
                        <option value="">جميع الأنواع</option>
                        <option value="reel" {{ request('type') == 'reel' ? 'selected' : '' }}>📱 ريلز عمودي (9:16)</option>
                        <option value="standard" {{ request('type') == 'standard' ? 'selected' : '' }}>🖥️ شرح تفصيلي (16:9)</option>
                    </select>
                </div>

                <div class="col-md-2 col-sm-6">
                    <label class="form-label fs-7 fw-bold text-muted">نوع الوصول</label>
                    <select name="status" class="form-select">
                        <option value="">الكل (مجاني ومدفوع)</option>
                        <option value="free" {{ request('status') == 'free' ? 'selected' : '' }}>مجاني فقط</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>مدفوع فقط 🔒</option>
                    </select>
                </div>

                <div class="col-md-2 col-sm-6">
                    <label class="form-label fs-7 fw-bold text-muted">المشكلة / الحالة</label>
                    <select name="need_id" class="form-select">
                        <option value="">كل المشاكل</option>
                        @foreach($needs as $need)
                            <option value="{{ $need->id }}" {{ request('need_id') == $need->id ? 'selected' : '' }}>{{ $need->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 col-sm-6">
                    <label class="form-label fs-7 fw-bold text-muted">الفئة العمرية</label>
                    <select name="age_group_id" class="form-select">
                        <option value="">كل الأعمار</option>
                        @foreach($ageGroups as $ag)
                            <option value="{{ $ag->id }}" {{ request('age_group_id') == $ag->id ? 'selected' : '' }}>{{ $ag->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-1 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold" title="تطبيق الفلتر">
                        <i class="bi bi-funnel-fill"></i>
                    </button>
                    @if(request()->anyFilled(['search', 'type', 'status', 'need_id', 'age_group_id']))
                        <a href="{{ route('admin.doctor-videos.index') }}" class="btn btn-light border text-muted" title="إلغاء التصفية">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- 4. Videos Listing Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-0 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                <i class="bi bi-film text-primary"></i>
                <span>قائمة الشروحات المرفوعة</span>
                <span class="badge bg-light text-primary rounded-pill px-2.5 py-1">{{ $videos->total() }} فيديو</span>
            </h5>
            <a href="{{ route('admin.doctor-videos.create') }}" class="btn btn-sm btn-outline-primary fw-bold rounded-3">
                <i class="bi bi-plus-lg me-1"></i> إضافة فيديو جديد
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted fs-7 text-nowrap">
                    <tr>
                        <th class="ps-4" style="width: 80px;">المعاينة</th>
                        <th>العنوان والمشكلة</th>
                        <th>النوع والمدة</th>
                        <th>الفئة المستهدفة</th>
                        <th>التسعير والوصول</th>
                        <th>المشاهدات</th>
                        <th>المنتجات المرتبطة</th>
                        <th>حالة النشر</th>
                        <th class="text-end pe-4" style="width: 140px;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($videos as $video)
                        <tr>
                            <td class="ps-4">
                                <div class="position-relative rounded-3 overflow-hidden bg-dark shadow-2xs" 
                                     style="width: 72px; height: {{ $video->video_type === 'reel' ? '96px' : '48px' }};">
                                    @if($video->thumbnail)
                                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-100 h-100 object-fit-cover">
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-white bg-slate-800">
                                            <i class="bi bi-play-circle fs-4"></i>
                                        </div>
                                    @endif
                                    @if($video->duration)
                                        <span class="position-absolute bottom-0 end-0 bg-dark bg-opacity-75 text-white fs-8 px-1 rounded-1 m-1 font-monospace">
                                            {{ $video->duration }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <div class="fw-bold text-dark mb-1 text-truncate" style="max-width: 280px;" title="{{ $video->title }}">
                                    {{ $video->title }}
                                </div>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    @if($video->need)
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill fs-8">
                                            <i class="bi bi-tag-fill me-1"></i>{{ $video->need->name }}
                                        </span>
                                    @endif
                                    <small class="text-muted font-monospace fs-8">{{ $video->created_at->format('Y-m-d') }}</small>
                                </div>
                            </td>

                            <td>
                                @if($video->video_type === 'reel')
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2.5 py-1 fs-8 fw-bold">
                                        <i class="bi bi-phone-fill me-1"></i> ريلز (9:16)
                                    </span>
                                @else
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 rounded-pill px-2.5 py-1 fs-8 fw-bold">
                                        <i class="bi bi-display me-1"></i> شرح كامل (16:9)
                                    </span>
                                @endif
                                <div class="text-muted fs-8 mt-1">المصدر: {{ ucfirst($video->video_source) }}</div>
                            </td>

                            <td>
                                @if($video->ageGroup)
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-2.5 py-1 fs-8">
                                        <i class="bi bi-person-hearts me-1"></i>{{ $video->ageGroup->name }}
                                    </span>
                                @else
                                    <span class="text-muted fs-8">عام لكافة الأعمار</span>
                                @endif
                            </td>

                            <td>
                                @if($video->is_paid)
                                    <span class="badge bg-warning bg-opacity-15 text-dark border border-warning rounded-pill px-2.5 py-1 fs-8 fw-bold d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-lock-fill text-warning"></i>
                                        <span>مدفوع ({{ number_format($video->price, 2) }} ج.م)</span>
                                    </span>
                                    @if($video->preview_seconds > 0)
                                        <div class="text-muted fs-8 mt-0.5">معاينة مجانية: {{ $video->preview_seconds }} ثانية</div>
                                    @endif
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2.5 py-1 fs-8 fw-bold">
                                        <i class="bi bi-unlock-fill me-1"></i> مجاني 100%
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="fw-bold text-dark fs-7 d-flex align-items-center gap-1">
                                    <i class="bi bi-eye text-muted"></i>
                                    <span>{{ number_format($video->views_count) }}</span>
                                </div>
                            </td>

                            <td>
                                @if($video->products_count > 0)
                                    <span class="badge bg-dark bg-opacity-10 text-dark rounded-pill px-2.5 py-1 fs-8">
                                        <i class="bi bi-bag-check-fill text-primary me-1"></i>{{ $video->products_count }} منتج مقترح
                                    </span>
                                @else
                                    <span class="text-muted fs-8">-</span>
                                @endif
                            </td>

                            <td>
                                <div class="form-check form-switch p-0 m-0">
                                    <input class="form-check-input ms-0 status-toggle" type="checkbox" role="switch" 
                                           data-id="{{ $video->id }}" 
                                           {{ $video->is_published ? 'checked' : '' }} 
                                           style="cursor: pointer;">
                                    <span class="fs-8 text-muted d-block mt-1 status-label-{{ $video->id }}">
                                        {{ $video->is_published ? 'منشور' : 'مسودة' }}
                                    </span>
                                </div>
                            </td>

                            <td class="text-end pe-4 text-nowrap">
                                <div class="btn-group btn-group-sm">
                                    @if(Route::has('doctor-videos.watch'))
                                    <a href="{{ route('doctor-videos.watch', $video->slug) }}" target="_blank" class="btn btn-light border text-muted" title="معاينة الفيديو في المتجر">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @endif
                                    <a href="{{ route('admin.doctor-videos.edit', $video) }}" class="btn btn-light border text-primary" title="تعديل">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-light border text-danger" title="حذف" 
                                            onclick="confirmDelete('{{ $video->id }}', '{{ addslashes($video->title) }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <form id="delete-form-{{ $video->id }}" action="{{ route('admin.doctor-videos.destroy', $video) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-camera-reels display-4 d-block mb-3 text-muted text-opacity-50"></i>
                                <h5>لا توجد فيديوهات مطابقة للبحث حالياً</h5>
                                <p class="fs-7 text-muted mb-3">ابدأ الآن برفع أول فيديو شرح أو ريلز للدكتور لتظهر لأولياء الأمور في الموقع.</p>
                                <a href="{{ route('admin.doctor-videos.create') }}" class="btn btn-primary fw-bold fs-7 rounded-3 px-4 py-2">
                                    <i class="bi bi-plus-lg me-1"></i> رفع فيديو جديد
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($videos->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $videos->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-body text-center p-4">
                <div class="text-danger mb-3">
                    <i class="bi bi-exclamation-triangle-fill display-4"></i>
                </div>
                <h5 class="fw-bold mb-2">هل أنت متأكد من حذف هذا الفيديو؟</h5>
                <p class="text-muted fs-7 mb-4" id="deleteVideoTitle"></p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-danger rounded-3 px-4 fw-bold" id="confirmDeleteBtn">تأكيد الحذف</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let activeDeleteId = null;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

    function confirmDelete(id, title) {
        activeDeleteId = id;
        document.getElementById('deleteVideoTitle').textContent = `سيتم حذف: "${title}" وجميع الملفات المرتبطة به نهائياً.`;
        deleteModal.show();
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (activeDeleteId) {
            document.getElementById(`delete-form-${activeDeleteId}`).submit();
        }
    });

    // AJAX Toggle Status
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const videoId = this.dataset.id;
            const label = document.querySelector(`.status-label-${videoId}`);
            
            fetch(`{{ url('admin/doctor-videos') }}/${videoId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    label.textContent = data.is_published ? 'منشور' : 'مسودة';
                }
            })
            .catch(err => {
                console.error(err);
                this.checked = !this.checked;
            });
        });
    });
</script>
@endpush

@endsection

