@extends('admin.layouts.layout')

@section('title', 'معرض الميديا والوسائط | شروحات الدكتور')

@section('content')
<div class="container-fluid p-0">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1 text-dark d-flex align-items-center gap-2">
                <i class="bi bi-images text-primary"></i>
                <span>معرض وسائط وميديا شروحات الدكتور</span>
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 fs-8">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.doctor-videos.index') }}">شروحات الدكتور</a></li>
                    <li class="breadcrumb-item active" aria-current="page">معرض الميديا</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary fw-bold fs-7 rounded-3" onclick="document.getElementById('quick_upload_input').click()">
                <i class="bi bi-cloud-arrow-up-fill me-1"></i> رفع وسائط جديدة
            </button>
            <input type="file" id="quick_upload_input" class="d-none" accept="image/*,video/*" onchange="uploadMediaFile(this)">
            <a href="{{ route('admin.doctor-videos.create') }}" class="btn btn-outline-primary fw-bold fs-7 rounded-3">
                <i class="bi bi-plus-lg me-1"></i> رفع فيديو كامل
            </a>
        </div>
    </div>

    <!-- Upload Progress Banner (Hidden by default) -->
    <div id="upload_alert" class="alert alert-info border-0 rounded-4 shadow-sm mb-4 d-none d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
            <span class="fw-bold fs-7" id="upload_alert_text">جاري رفع الملف إلى المعرض...</span>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h6 class="fw-bold mb-0 text-dark">
                <span>كافة الوسائط المرفوعة لشروحات الدكتور</span>
                <span class="badge bg-light text-primary rounded-pill px-2.5 py-1 ms-2">{{ $videos->total() }} ملف</span>
            </h6>
        </div>

        <div class="card-body p-4">
            <div class="row g-3" id="gallery_items_container">
                @forelse($videos as $video)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card h-100 rounded-4 border overflow-hidden shadow-2xs hover-scale transition-all">
                            <!-- Media Preview Box -->
                            <div class="position-relative bg-dark" style="aspect-ratio: {{ $video->video_type === 'reel' ? '9/16' : '16/9' }}; max-height: 220px; overflow: hidden;">
                                @if($video->thumbnail)
                                    <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-white bg-slate-800">
                                        <i class="bi bi-play-circle fs-1"></i>
                                    </div>
                                @endif

                                <!-- Type badge -->
                                <span class="position-absolute top-0 start-0 m-2 badge bg-dark bg-opacity-75 text-white fs-8 rounded-pill">
                                    {{ $video->video_type === 'reel' ? '📱 ريلز' : '🖥️ شرح تفصيلي' }}
                                </span>

                                @if($video->duration)
                                    <span class="position-absolute bottom-0 end-0 m-2 badge bg-dark bg-opacity-80 text-white fs-8 font-monospace">
                                        {{ $video->duration }}
                                    </span>
                                @endif
                            </div>

                            <!-- Media Info & Action -->
                            <div class="card-body p-3">
                                <h6 class="fw-bold text-dark fs-7 text-truncate mb-2" title="{{ $video->title }}">
                                    {{ $video->title }}
                                </h6>
                                <div class="d-flex align-items-center justify-content-between text-muted fs-8">
                                    <span>{{ $video->created_at->format('Y-m-d') }}</span>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-light border py-1 px-2" title="نسخ رابط الفيديو" onclick="copyToClipboard('{{ $video->video_url }}')">
                                            <i class="bi bi-clipboard"></i>
                                        </button>
                                        <a href="{{ route('admin.doctor-videos.edit', $video) }}" class="btn btn-light border py-1 px-2 text-primary" title="تعديل">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 text-muted">
                        <i class="bi bi-images display-4 text-muted text-opacity-50 mb-3 d-block"></i>
                        <h5>المعرض فارغ حالياً</h5>
                        <p class="fs-7 text-muted">لم يتم رفع أي وسائط أو فيديوهات بعد. يمكنك البدء برفع صورة أو فيديو الآن.</p>
                    </div>
                @endforelse
            </div>
        </div>

        @if($videos->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $videos->links() }}
            </div>
        @endif
    </div>

</div>

@push('scripts')
<script>
    function copyToClipboard(text) {
        if (!text) {
            alert('لا يوجد رابط متاح لهذا الملف');
            return;
        }
        navigator.clipboard.writeText(text).then(() => {
            alert('تم نسخ الرابط بنجاح: ' + text);
        });
    }

    function uploadMediaFile(input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];
        const formData = new FormData();
        formData.append('media_file', file);
        formData.append('_token', '{{ csrf_token() }}');

        const alertBox = document.getElementById('upload_alert');
        const alertText = document.getElementById('upload_alert_text');
        alertBox.classList.remove('d-none');
        alertText.textContent = `جاري رفع: ${file.name}...`;

        fetch('{{ route("admin.doctor-videos.uploadMedia") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            alertBox.classList.add('d-none');
            if (data.success) {
                alert('تم رفع الملف بنجاح إلى المعرض!');
                window.location.reload();
            } else {
                alert('حدث خطأ أثناء الرفع: ' + (data.message || 'حاول مجدداً'));
            }
        })
        .catch(err => {
            alertBox.classList.add('d-none');
            console.error(err);
            alert('تعذر إكمال الرفع، يرجى التحقق من حجم الملف.');
        });
    }
</script>
@endpush

@endsection

