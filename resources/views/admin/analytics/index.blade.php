@extends('admin.layouts.layout')

@section('title', 'تحليل الترافيك والزيارات | لوحة التحكم تمورو')

@section('content')
<div class="container-fluid p-0">

    <!-- Header Hero -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" 
         style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #1e3a8a 100%); color: #ffffff;">
        <div class="card-body p-4 p-md-5 d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-4">
            <div>
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-white bg-opacity-10 border border-white border-opacity-20 text-white fs-7 fw-bold mb-3 shadow-xs">
                    <span class="badge rounded-circle p-1 bg-success" style="width: 8px; height: 8px; display: inline-block;"></span>
                    <span>محرك تحليلات تمورو المباشر • تتبع الزيارات ومصادر الحملات</span>
                </div>
                <h2 class="fw-black mb-1 text-white" style="font-size: 1.75rem;">تحليل الترافيك والزيارات ومصادر العملاء</h2>
                <p class="text-white text-opacity-75 fs-6 mb-0">متابعة الزوار الحقيقيين، مشاهدات الصفحات، معدل التحويل، ومصادر الترافيك من فيسبوك وتيك توك وجوجل وواتساب.</p>
            </div>

            <div class="d-flex flex-wrap gap-2.5 align-items-center">
                <!-- Period Switcher Buttons -->
                <div class="btn-group bg-white bg-opacity-10 p-1 rounded-3 border border-white border-opacity-20">
                    <a href="{{ route('admin.analytics.index', ['period' => 'today']) }}" class="btn btn-sm {{ $period === 'today' ? 'btn-primary fw-black' : 'text-white' }}">اليوم</a>
                    <a href="{{ route('admin.analytics.index', ['period' => '7_days']) }}" class="btn btn-sm {{ $period === '7_days' ? 'btn-primary fw-black' : 'text-white' }}">آخر 7 أيام</a>
                    <a href="{{ route('admin.analytics.index', ['period' => '30_days']) }}" class="btn btn-sm {{ $period === '30_days' ? 'btn-primary fw-black' : 'text-white' }}">آخر 30 يوم</a>
                    <a href="{{ route('admin.analytics.index', ['period' => 'this_month']) }}" class="btn btn-sm {{ $period === 'this_month' ? 'btn-primary fw-black' : 'text-white' }}">هذا الشهر</a>
                </div>

                <a href="{{ route('admin.marketing.pixels.index') }}" class="btn btn-light fw-bold fs-7 rounded-3 px-3 py-2 text-primary shadow-sm d-flex align-items-center gap-2">
                    <i class="bi bi-sliders"></i>
                    <span>إعدادات البكسلات</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 1. Core KPIs Row -->
    <div class="row g-3 mb-4">
        <!-- Unique Visitors -->
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fs-7 fw-bold">الزوار الحقيقيون (Unique Visitors)</span>
                    <span class="p-2.5 rounded-3 bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-people-fill fs-5"></i>
                    </span>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <h2 class="fw-black text-dark mb-0">{{ number_format($uniqueVisitors) }}</h2>
                    @if($growth != 0)
                        <span class="badge {{ $growth > 0 ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' }} rounded-pill px-2 py-0.5 fs-8 fw-bold">
                            {{ $growth > 0 ? '+' : '' }}{{ $growth }}%
                        </span>
                    @endif
                </div>
                <small class="text-muted fs-8">مقارنة بالفترة السابقة المماثلة</small>
            </div>
        </div>

        <!-- Total Pageviews -->
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fs-7 fw-bold">إجمالي مشاهدات الصفحات (Pageviews)</span>
                    <span class="p-2.5 rounded-3 bg-info bg-opacity-10 text-info">
                        <i class="bi bi-eye-fill fs-5"></i>
                    </span>
                </div>
                <h2 class="fw-black text-dark mb-1">{{ number_format($totalPageviews) }}</h2>
                <small class="text-muted fs-8">معدل {{ $uniqueVisitors > 0 ? round($totalPageviews / $uniqueVisitors, 1) : 1 }} صفحة لكل زائر</small>
            </div>
        </div>

        <!-- Total Conversions -->
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fs-7 fw-bold">إجمالي التحويلات (Conversions)</span>
                    <span class="p-2.5 rounded-3 bg-success bg-opacity-10 text-success">
                        <i class="bi bi-cart-check-fill fs-5"></i>
                    </span>
                </div>
                <h2 class="fw-black text-success mb-1">{{ number_format($totalConversions) }}</h2>
                <small class="text-muted fs-8">{{ $ordersCount }} طلب + {{ $bookingsCount }} استشارة + {{ $videoPurchasesCount }} كورس</small>
            </div>
        </div>

        <!-- Conversion Rate -->
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fs-7 fw-bold">معدل التحويل العام (CR %)</span>
                    <span class="p-2.5 rounded-3 bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-graph-up fs-5"></i>
                    </span>
                </div>
                <h2 class="fw-black text-dark mb-1">{{ $conversionRate }}%</h2>
                <small class="text-muted fs-8">نسبة الزوار الذين تحولوا إلى عملاء مشترين</small>
            </div>
        </div>
    </div>

    <!-- 2. Traffic Over Time Chart -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 px-4 border-0 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                <i class="bi bi-activity text-primary"></i>
                <span>منحنى الزيارات اليومية وتفاعل المستخدمين</span>
            </h6>
            <div class="d-flex align-items-center gap-3 fs-8 fw-bold">
                <span class="d-flex align-items-center gap-1.5"><span class="badge rounded-circle p-1 bg-primary" style="width: 8px; height: 8px;"></span> المشاهدات (Pageviews)</span>
                <span class="d-flex align-items-center gap-1.5"><span class="badge rounded-circle p-1 bg-success" style="width: 8px; height: 8px;"></span> الزوار الفريدون (Visitors)</span>
            </div>
        </div>
        <div class="card-body p-4 pt-1">
            <div style="height: 280px; position: relative;">
                <canvas id="trafficTrendChart"></canvas>
            </div>
        </div>
    </div>

    <!-- 3. Sources & Devices Breakdown -->
    <div class="row g-4 mb-4">
        <!-- Traffic Sources -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 px-4 border-0">
                    <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-diagram-2 text-primary"></i>
                        <span>مصادر الزيارات والحملات الإعلانية (Traffic Channels)</span>
                    </h6>
                </div>
                <div class="card-body p-4 pt-1">
                    @php
                        $totalSourceVisits = $sourcesStats->sum('count');
                    @endphp

                    @if($sourcesStats->isNotEmpty())
                        <div class="d-flex flex-column gap-3">
                            @foreach($sourcesStats as $source)
                                @php
                                    $percent = $totalSourceVisits > 0 ? round(($source->count / $totalSourceVisits) * 100, 1) : 0;
                                    $label = $sourceLabelsMapping[$source->source] ?? ucfirst($source->source);
                                    
                                    $color = 'bg-primary';
                                    if ($source->source === 'facebook') $color = 'bg-primary';
                                    elseif ($source->source === 'tiktok') $color = 'bg-dark';
                                    elseif ($source->source === 'instagram') $color = 'bg-danger';
                                    elseif ($source->source === 'google') $color = 'bg-warning';
                                    elseif ($source->source === 'whatsapp') $color = 'bg-success';
                                    elseif ($source->source === 'direct') $color = 'bg-secondary';
                                @endphp
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-1 fs-7">
                                        <span class="fw-bold text-dark">{{ $label }}</span>
                                        <span class="text-muted font-monospace fs-8">{{ number_format($source->count) }} زيارة ({{ $percent }}%)</span>
                                    </div>
                                    <div class="progress" style="height: 8px; border-radius: 4px;">
                                        <div class="progress-bar {{ $color }}" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-funnel display-5 text-muted text-opacity-50 mb-2 d-block"></i>
                            <p class="fs-7 mb-0">سيتم تسجيل وتصنيف مصادر الترافيك بمجرد دخول أول زائر.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Devices & Platforms -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 px-4 border-0">
                    <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-phone text-primary"></i>
                        <span>توزيع الأجهزة (Devices Breakdown)</span>
                    </h6>
                </div>
                <div class="card-body p-4 pt-1">
                    @php
                        $mobileCount = $deviceStats['mobile'] ?? 0;
                        $desktopCount = $deviceStats['desktop'] ?? 0;
                        $tabletCount = $deviceStats['tablet'] ?? 0;
                        $totalDevices = $mobileCount + $desktopCount + $tabletCount;

                        $mobilePercent = $totalDevices > 0 ? round(($mobileCount / $totalDevices) * 100, 1) : 0;
                        $desktopPercent = $totalDevices > 0 ? round(($desktopCount / $totalDevices) * 100, 1) : 0;
                        $tabletPercent = $totalDevices > 0 ? round(($tabletCount / $totalDevices) * 100, 1) : 0;
                    @endphp

                    <div class="row g-3 text-center my-3">
                        <div class="col-4">
                            <div class="p-3 bg-light rounded-4">
                                <i class="bi bi-phone fs-2 text-primary d-block mb-1"></i>
                                <span class="fs-8 text-muted d-block">موبايل</span>
                                <h4 class="fw-black mb-0 text-dark">{{ $mobilePercent }}%</h4>
                                <small class="text-muted fs-8 font-monospace">{{ $mobileCount }}</small>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="p-3 bg-light rounded-4">
                                <i class="bi bi-laptop fs-2 text-info d-block mb-1"></i>
                                <span class="fs-8 text-muted d-block">كمبيوتر</span>
                                <h4 class="fw-black mb-0 text-dark">{{ $desktopPercent }}%</h4>
                                <small class="text-muted fs-8 font-monospace">{{ $desktopCount }}</small>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="p-3 bg-light rounded-4">
                                <i class="bi bi-tablet fs-2 text-warning d-block mb-1"></i>
                                <span class="fs-8 text-muted d-block">تابلت</span>
                                <h4 class="fw-black mb-0 text-dark">{{ $tabletPercent }}%</h4>
                                <small class="text-muted fs-8 font-monospace">{{ $tabletCount }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-light border rounded-3 p-3 fs-8 text-muted mb-0">
                        <i class="bi bi-info-circle-fill text-primary me-1"></i>
                        <span>أغلب أولياء الأمور يتصفحون المتجر عبر <strong>الموبايل</strong>، مما يؤكد أهمية مقاطع <strong>الريلز السريعة</strong> وسلاسة تجربة الهاتف.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Top Pages Visited Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white py-3 px-4 border-0 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                <i class="bi bi-file-earmark-text text-primary"></i>
                <span>أكثر الصفحات والمسارات زيارة (Top Visited URLs)</span>
            </h6>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted fs-7 text-nowrap">
                    <tr>
                        <th class="ps-4">المسار (URL Path)</th>
                        <th>نوع الصفحة</th>
                        <th>عدد المشاهدات</th>
                        <th class="text-end pe-4">معاينة مباشرة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topPages as $page)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark fs-7 font-monospace">/{{ ltrim($page->path, '/') }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border rounded-pill px-2.5 py-1 fs-8">
                                    {{ ucfirst(str_replace('_', ' ', $page->page_type)) }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-black text-dark fs-7">{{ number_format($page->count) }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ url($page->path) }}" target="_blank" class="btn btn-sm btn-light border py-1 px-2.5 text-muted" title="فتح الصفحة">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted fs-7">
                                لم يتم تسجيل زيارات صفحات بعد في هذه الفترة.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<!-- Chart.js CDN for Analytics Graph -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('trafficTrendChart');
        if (!ctx) return;

        const labels = {{ Js::from($chartLabels) }};
        const pageviews = {{ Js::from($chartPageviews) }};
        const visitors = {{ Js::from($chartVisitors) }};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels.length ? labels : ['اليوم'],
                datasets: [
                    {
                        label: 'مشاهدات الصفحات',
                        data: pageviews.length ? pageviews : [0],
                        borderColor: '#2563ea',
                        backgroundColor: 'rgba(37, 99, 234, 0.08)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2.5,
                        pointRadius: 3,
                    },
                    {
                        label: 'الزوار الفريدون',
                        data: visitors.length ? visitors : [0],
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.08)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2.5,
                        pointRadius: 3,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });
    });
</script>
@endpush

@endsection

