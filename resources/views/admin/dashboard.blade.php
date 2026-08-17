@extends('admin.layouts.layout')

@section('title', 'الرئيسية | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold mb-1">الرئيسية</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page">الإحصائيات العامة</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row">
        <!-- Sales Stat Card -->
        <div class="col-md-4 col-sm-12">
            <div class="card stat-card text-white bg-primary">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white-50 fw-semibold mb-2">إجمالي المبيعات المؤكدة</h6>
                        <h3 class="fw-bold mb-1">{{ number_format($totalSales, 2) }} ج.م</h3>
                        <p class="text-white-50 fs-7 mb-0">المبيعات المدفوعة بالكامل</p>
                    </div>
                    <span class="fs-1 opacity-75"><i class="bi bi-wallet2"></i></span>
                </div>
            </div>
        </div>

        <!-- Orders Stat Card -->
        <div class="col-md-4 col-sm-12">
            <div class="card stat-card text-white bg-info">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white-50 fw-semibold mb-2">إجمالي عدد الطلبات</h6>
                        <h3 class="fw-bold mb-1">{{ $totalOrders }}</h3>
                        <p class="text-white-50 fs-7 mb-0">كل طلبات المتجر</p>
                    </div>
                    <span class="fs-1 opacity-75"><i class="bi bi-cart3"></i></span>
                </div>
            </div>
        </div>

        <!-- Customers Stat Card -->
        <div class="col-md-4 col-sm-12">
            <div class="card stat-card text-white bg-success">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white-50 fw-semibold mb-2">إجمالي العملاء المسجلين</h6>
                        <h3 class="fw-bold mb-1">{{ $totalCustomers }}</h3>
                        <p class="text-white-50 fs-7 mb-0">المستخدمين المسجلين في المتجر</p>
                    </div>
                    <span class="fs-1 opacity-75"><i class="bi bi-people"></i></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row">
        <!-- Sales Trend -->
        <div class="col-lg-8 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title fw-bold mb-0">مؤشر مبيعات الأشهر السابقة</h5>
                    <span class="badge bg-light text-primary">آخر 6 أشهر</span>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" style="max-height: 320px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Customer Segments -->
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title fw-bold mb-0">توزيع شرائح العملاء (CRM)</h5>
                </div>
                <div class="card-body">
                    <canvas id="segmentsChart" style="max-height: 220px; margin-bottom: 20px;"></canvas>
                    
                    <ul class="list-group list-group-flush fs-7">
                        @foreach($segmentStats as $label => $count)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>{{ $label }}</span>
                                <span class="badge bg-secondary rounded-pill">{{ $count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-bold mb-0">آخر الطلبات المستلمة</h5>
                    <a href="{{ route('admin.crm.index') }}" class="btn btn-sm btn-outline-primary">إدارة العملاء والطلبات</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">رقم الطلب</th>
                                    <th>العميل</th>
                                    <th>المحافظة</th>
                                    <th>طريقة الدفع</th>
                                    <th>حالة الدفع</th>
                                    <th>حالة الطلب</th>
                                    <th>الإجمالي</th>
                                    <th class="pe-4 text-end">التاريخ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary">#{{ $order->order_number }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ $order->customer_name }}</div>
                                            <small class="text-muted">{{ $order->customer_phone }}</small>
                                        </td>
                                        <td>{{ $order->shipping_governorate }}</td>
                                        <td>
                                            @if($order->payment_method === 'cod')
                                                <span class="badge bg-secondary-subtle text-secondary">الدفع عند الاستلام</span>
                                            @else
                                                <span class="badge bg-primary-subtle text-primary">دفع إلكتروني</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->payment_status === 'paid')
                                                <span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>مدفوع</span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning"><i class="bi bi-clock me-1"></i>معلق</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->status === 'delivered')
                                                <span class="badge bg-success">تم التسليم</span>
                                            @elseif($order->status === 'shipped')
                                                <span class="badge bg-info">تم الشحن</span>
                                            @elseif($order->status === 'cancelled')
                                                <span class="badge bg-danger">ملغي</span>
                                            @else
                                                <span class="badge bg-warning text-dark">قيد المعالجة</span>
                                            @endif
                                        </td>
                                        <td class="fw-bold">{{ number_format($order->total, 2) }} ج.م</td>
                                        <td class="pe-4 text-end text-muted">{{ $order->created_at->format('Y/m/d H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            <i class="bi bi-inbox fs-2 d-block mb-2"></i> لا توجد طلبات مسجلة بعد.
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
@endsection

@section('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // 1. Sales Trend Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'المبيعات بالشهر (ج.م)',
                data: {!! json_encode($chartValues) !!},
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // 2. Customer Segments Donut Chart
    const segmentsCtx = document.getElementById('segmentsChart').getContext('2d');
    new Chart(segmentsCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($segmentStats)) !!},
            datasets: [{
                data: {!! json_encode(array_values($segmentStats)) !!},
                backgroundColor: ['#4f46e5', '#06b6d4', '#10b981', '#f59e0b'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '70%'
        }
    });
</script>
@endsection
