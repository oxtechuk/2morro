@extends('admin.layouts.layout')

@section('title', 'لوحة التحكم المركزية | تمورو')

@section('content')
<div class="container-fluid p-0">
    
    <!-- 1. Hero Control & Quick Actions Header -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" 
         style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #2563ea 100%); color: #ffffff;">
        <div class="card-body p-4 p-md-5 d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-4">
            <div>
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white bg-opacity-15 text-white fs-7 fw-bold mb-2">
                    <span class="spinner-grow spinner-grow-sm text-warning" role="status"></span>
                    <span>النظام متصل • مركز ومتجر 2morro</span>
                </div>
                <h2 class="fw-black mb-1 text-white">لوحة الإدارة والتحكم الشاملة</h2>
                <p class="text-white-50 fs-6 mb-0">مرحباً بك، يمكنك متابعة المبيعات الحية، حجوزات الاستشارات، والطلبات وإدارتها لحظياً.</p>
            </div>

            <!-- Quick Action Buttons -->
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.products.create') }}" class="btn btn-light fw-bold fs-7 rounded-3 shadow-sm d-flex align-items-center gap-1.5 hover-scale">
                    <i class="bi bi-plus-circle-fill text-primary"></i>
                    <span>إضافة منتج</span>
                </a>
                <a href="{{ route('admin.bookings.create') }}" class="btn btn-warning fw-bold fs-7 rounded-3 shadow-sm d-flex align-items-center gap-1.5 text-dark hover-scale">
                    <i class="bi bi-calendar-plus-fill"></i>
                    <span>حجز استشارة يدوي</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-light fw-bold fs-7 rounded-3 d-flex align-items-center gap-1.5">
                    <i class="bi bi-bag-check"></i>
                    <span>الطلبات</span>
                </a>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-dark bg-black bg-opacity-30 border-white border-opacity-25 fw-bold fs-7 rounded-3 text-white d-flex align-items-center gap-1.5">
                    <i class="bi bi-box-arrow-up-right"></i>
                    <span>المتجر</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. Dynamic 6 KPI Cards Grid -->
    <div class="row g-3 mb-4">
        
        <!-- KPI 1: Paid Sales -->
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-xs rounded-4 h-100 p-3 bg-white hover-shadow transition">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-7 fw-bold d-block mb-1">إجمالي المبيعات المحصلة</span>
                        <h3 class="fw-black text-dark mb-1">{{ number_format($totalSales, 2) }} <small class="fs-6 text-muted">ج.م</small></h3>
                        <div class="d-flex align-items-center gap-1 fs-8">
                            <span class="badge {{ $salesGrowth >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} fw-bold">
                                {{ $salesGrowth >= 0 ? '+' : '' }}{{ $salesGrowth }}% هذا الشهر
                            </span>
                            <span class="text-muted">مقارنة بالشهر السابق</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center fs-3 flex-shrink-0" style="width: 52px; height: 52px;">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI 2: Total & Pending Orders -->
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-xs rounded-4 h-100 p-3 bg-white hover-shadow transition">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-7 fw-bold d-block mb-1">الطلبات والمبيعات</span>
                        <h3 class="fw-black text-dark mb-1">{{ $totalOrders }} <small class="fs-6 text-muted">طلب</small></h3>
                        <div class="d-flex align-items-center gap-1 fs-8">
                            <span class="badge bg-warning-subtle text-warning-emphasis fw-bold">
                                {{ $pendingOrders }} معلق بانتظار التجهيز
                            </span>
                            @if($ordersRequiringProof > 0)
                                <span class="badge bg-danger-subtle text-danger fw-bold">
                                    {{ $ordersRequiringProof }} إيصال للمراجعة
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-3 bg-info-subtle text-info d-flex align-items-center justify-content-center fs-3 flex-shrink-0" style="width: 52px; height: 52px;">
                        <i class="bi bi-cart3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI 3: Consultation Bookings -->
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-xs rounded-4 h-100 p-3 bg-white hover-shadow transition">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-7 fw-bold d-block mb-1">حجوزات الاستشارات والتقييم</span>
                        <h3 class="fw-black text-dark mb-1">{{ $totalBookings }} <small class="fs-6 text-muted">حجز</small></h3>
                        <div class="d-flex align-items-center gap-1 fs-8">
                            <span class="badge bg-amber-subtle text-amber fw-bold" style="background-color: #FEF3C7; color: #B45309;">
                                {{ $newBookingsCount }} جديد بحاجة للتأكيد
                            </span>
                            @if($todayBookingsCount > 0)
                                <span class="badge bg-primary-subtle text-primary fw-bold">
                                    {{ $todayBookingsCount }} مواعيد اليوم
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-3 bg-warning-subtle text-warning d-flex align-items-center justify-content-center fs-3 flex-shrink-0" style="width: 52px; height: 52px;">
                        <i class="bi bi-calendar2-heart"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI 4: Active Products & Low Stock -->
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-xs rounded-4 h-100 p-3 bg-white hover-shadow transition">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-7 fw-bold d-block mb-1">الكتالوج والمنتجات النشطة</span>
                        <h3 class="fw-black text-dark mb-1">{{ $activeProductsCount }} <small class="fs-6 text-muted">منتج</small></h3>
                        <div class="d-flex align-items-center gap-1 fs-8">
                            @if($lowStockCount > 0)
                                <span class="badge bg-danger text-white fw-bold">
                                    {{ $lowStockCount }} منخفض المخزون
                                </span>
                            @else
                                <span class="badge bg-success-subtle text-success fw-bold">
                                    المخزون متوفر
                                </span>
                            @endif
                            <span class="text-muted">{{ $digitalProductsCount }} شيتات رقمية</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center fs-3 flex-shrink-0" style="width: 52px; height: 52px;">
                        <i class="bi bi-box-seam"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI 5: Registered Customers -->
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-xs rounded-4 h-100 p-3 bg-white hover-shadow transition">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-7 fw-bold d-block mb-1">العملاء والمسجلين</span>
                        <h3 class="fw-black text-dark mb-1">{{ $totalCustomers }} <small class="fs-6 text-muted">عميل</small></h3>
                        <div class="d-flex align-items-center gap-1 fs-8">
                            <span class="badge bg-purple-subtle text-purple fw-bold" style="background-color: #F3E8FF; color: #7E22CE;">
                                عملاء متفاعلين
                            </span>
                            <a href="{{ route('admin.crm.index') }}" class="text-primary text-decoration-none fw-bold">إدارة CRM &larr;</a>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-3 text-purple d-flex align-items-center justify-content-center fs-3 flex-shrink-0" style="width: 52px; height: 52px; background-color: #F3E8FF; color: #7E22CE;">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI 6: Digital Downloads & PDF Activity -->
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-xs rounded-4 h-100 p-3 bg-white hover-shadow transition">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-7 fw-bold d-block mb-1">تحميلات الشيتات الرقمية</span>
                        <h3 class="fw-black text-dark mb-1">{{ $totalDownloadsCount }} <small class="fs-6 text-muted">تحميل</small></h3>
                        <div class="d-flex align-items-center gap-1 fs-8">
                            <span class="badge bg-teal-subtle text-teal fw-bold" style="background-color: #CCFBF1; color: #0F766E;">
                                وصول رقمي فوري 100%
                            </span>
                            <span class="text-muted">مشفر ومؤمن</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-3 d-flex align-items-center justify-content-center fs-3 flex-shrink-0" style="width: 52px; height: 52px; background-color: #CCFBF1; color: #0F766E;">
                        <i class="bi bi-file-earmark-arrow-down"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- 3. Interactive Charts Grid (3 Columns / Cards) -->
    <div class="row g-3 mb-4">
        
        <!-- Chart 1: Sales & Orders Monthly Trend (8 cols) -->
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-xs rounded-4 h-100 p-4 bg-white">
                <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 pb-3 mb-3 border-bottom">
                    <div>
                        <h5 class="fw-black text-dark mb-0">مؤشر الإيرادات وحجم الطلبات</h5>
                        <p class="text-muted fs-8 mb-0">تطور حركة المبيعات الفعلية خلال الأشهر الماضية</p>
                    </div>
                    <span class="badge bg-primary-subtle text-primary fs-7 px-3 py-1.5 rounded-pill">آخر 6 أشهر</span>
                </div>
                <div style="min-height: 280px; height: 280px;">
                    <canvas id="salesTrendsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Chart 2: Payment Methods Distribution (4 cols) -->
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-xs rounded-4 h-100 p-4 bg-white">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                    <h5 class="fw-black text-dark mb-0">طرق الدفع المستخدمة</h5>
                    <span class="badge bg-light text-muted fs-8">نسبة التحصيل</span>
                </div>
                <div style="min-height: 220px; height: 220px;">
                    <canvas id="paymentMethodsChart"></canvas>
                </div>
                <div class="mt-3 pt-3 border-top d-flex justify-content-around text-center fs-8 text-muted">
                    <div>
                        <span class="d-block fw-bold text-dark">{{ $paymentChartData['values'][0] }}</span>
                        <span>COD</span>
                    </div>
                    <div>
                        <span class="d-block fw-bold text-primary">{{ $paymentChartData['values'][1] }}</span>
                        <span>InstaPay</span>
                    </div>
                    <div>
                        <span class="d-block fw-bold text-danger">{{ $paymentChartData['values'][2] }}</span>
                        <span>محافظ كاش</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- 4. Operational Feeds: Recent Orders & Recent Bookings -->
    <div class="row g-3 mb-4">
        
        <!-- Live Table: Recent Orders (7 cols) -->
        <div class="col-12 col-xl-7">
            <div class="card border-0 shadow-xs rounded-4 h-100 p-4 bg-white">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <span class="w-2 h-4 bg-primary rounded-pill"></span>
                        <h5 class="fw-black text-dark mb-0">أحدث طلبات المتجر</h5>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-light fw-bold text-primary rounded-3 fs-8">
                        عرض كافة الطلبات &larr;
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-right fs-7">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">رقم الطلب</th>
                                <th class="border-0">العميل</th>
                                <th class="border-0">الإجمالي</th>
                                <th class="border-0">الدفع</th>
                                <th class="border-0">الإيصال</th>
                                <th class="border-0">الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td class="fw-black text-primary">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-decoration-none">
                                            {{ $order->order_number }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-col">
                                            <span class="fw-bold text-dark">{{ $order->customer_name }}</span>
                                            <span class="text-muted fs-8 font-monospace" dir="ltr">{{ $order->customer_phone }}</span>
                                        </div>
                                    </td>
                                    <td class="fw-bold text-dark">
                                        {{ number_format($order->total, 2) }} ج.م
                                    </td>
                                    <td>
                                        @if($order->payment_method === 'cod')
                                            <span class="badge bg-secondary-subtle text-secondary fs-8">عند الاستلام</span>
                                        @elseif($order->payment_method === 'instapay')
                                            <span class="badge bg-purple-subtle text-purple fs-8" style="background-color: #F3E8FF; color: #7E22CE;">إنستاباي</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger fs-8">فودافون كاش</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->payment_screenshot)
                                            <a href="{{ asset('storage/' . $order->payment_screenshot) }}" target="_blank" class="btn btn-xs btn-outline-primary py-0 px-2 fs-8 rounded-pill" title="مشاهدة صورة التحويل">
                                                <i class="bi bi-image"></i> فحص
                                            </a>
                                        @else
                                            <span class="text-muted fs-8">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->status === 'delivered')
                                            <span class="badge bg-success-subtle text-success fs-8">مكتمل</span>
                                        @elseif($order->status === 'cancelled')
                                            <span class="badge bg-danger-subtle text-danger fs-8">ملغي</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning-emphasis fs-8">قيد التنفيذ</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted fs-7">لا توجد طلبات مسجلة بعد</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Live Table: Recent Consultation Bookings (5 cols) -->
        <div class="col-12 col-xl-5">
            <div class="card border-0 shadow-xs rounded-4 h-100 p-4 bg-white">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <span class="w-2 h-4 bg-warning rounded-pill"></span>
                        <h5 class="fw-black text-dark mb-0">أحدث حجوزات الاستشارات</h5>
                    </div>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-light fw-bold text-dark rounded-3 fs-8">
                        عرض الكل &larr;
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-right fs-7">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">الطفل والسن</th>
                                <th class="border-0">الفرع</th>
                                <th class="border-0">الموعد</th>
                                <th class="border-0 text-center">واتساب</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBookings as $booking)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark">{{ $booking->child_name ?: $booking->parent_name }}</span>
                                            <span class="text-muted fs-8">{{ $booking->child_age ? 'عمر: ' . $booking->child_age : 'استشارة' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark fs-8 border">
                                            @if($booking->branch === 'ibrahimya' || $booking->branch === 'الإبراهيمية') الإبراهيمية
                                            @elseif($booking->branch === 'bitash' || $booking->branch === 'البيطاش') البيطاش
                                            @elseif($booking->branch === 'sidi_beshr' || $booking->branch === 'سيدي بشر') سيدي بشر
                                            @else أونلاين @endif
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark fs-8">{{ $booking->booking_date ? $booking->booking_date->format('Y-m-d') : '-' }}</span>
                                            <span class="text-muted fs-8 font-monospace">{{ $booking->booking_time ?: '' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $cleanPhone = preg_replace('/[^0-9]/', '', $booking->parent_phone);
                                            if(str_starts_with($cleanPhone, '01')) {
                                                $cleanPhone = '20' . substr($cleanPhone, 1);
                                            }
                                        @endphp
                                        <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode('مرحباً أستاذ/ة ' . $booking->parent_name . '، بخصوص موعد تقييم الطفل ' . $booking->child_name . ' في مركز 2morro...') }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-success rounded-circle p-1 d-inline-flex align-items-center justify-content-center text-white" 
                                           style="width: 28px; height: 28px;" 
                                           title="مراسلة واتساب فورية">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted fs-7">لا توجد حجوزات مسجلة بعد</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <!-- 5. Low Stock Alerts & Quick Customer Segments -->
    <div class="row g-3">
        
        <!-- Low Stock Alert Card (6 cols) -->
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-xs rounded-4 p-4 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <span class="w-2 h-4 bg-danger rounded-pill"></span>
                        <h5 class="fw-black text-dark mb-0">نواقص وتنبيهات المخزون (Low Stock)</h5>
                    </div>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-light fw-bold text-danger rounded-3 fs-8">
                        إدارة المخزون &larr;
                    </a>
                </div>

                @if($lowStockProducts->isNotEmpty())
                    <div class="list-group list-group-flush fs-7">
                        @foreach($lowStockProducts as $lp)
                            <div class="list-group-item d-flex align-items-center justify-content-between px-0 py-2 border-bottom">
                                <div class="d-flex align-items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-2 bg-light border p-1 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                        @if($lp->images && count($lp->images) > 0)
                                            <img src="{{ asset('storage/' . $lp->images[0]) }}" class="w-100 h-100 object-fit-contain">
                                        @else
                                            <i class="bi bi-box text-muted"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.products.edit', $lp->id) }}" class="fw-bold text-dark text-decoration-none hover-primary">
                                            {{ $lp->name }}
                                        </a>
                                        <span class="text-muted fs-8 d-block">{{ number_format($lp->price, 2) }} ج.م</span>
                                    </div>
                                </div>
                                <div>
                                    <span class="badge {{ $lp->stock <= 0 ? 'bg-danger' : 'bg-warning text-dark' }} fw-black px-2.5 py-1 rounded-pill">
                                        متبقي: {{ $lp->stock }} قطع
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 text-success fs-7">
                        <i class="bi bi-check-circle-fill fs-3 d-block mb-1"></i>
                        جميع المنتجات المادية متوفرة بمخزون كافٍ ومريح.
                    </div>
                @endif
            </div>
        </div>

        <!-- Consultation Bookings By Branch (6 cols) -->
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-xs rounded-4 p-4 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                    <h5 class="fw-black text-dark mb-0">حجوزات الاستشارات حسب الفروع</h5>
                    <span class="badge bg-light text-muted fs-8">توزيع الفروع</span>
                </div>
                <div style="min-height: 200px; height: 200px;">
                    <canvas id="branchDistributionChart"></canvas>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@section('scripts')
<!-- Chart.js Script Integration -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. Dual Monthly Sales & Orders Chart
        const salesCtx = document.getElementById('salesTrendsChart');
        if (salesCtx) {
            new Chart(salesCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($salesChartLabels) !!},
                    datasets: [
                        {
                            label: 'المبيعات (ج.م)',
                            data: {!! json_encode($salesChartValues) !!},
                            backgroundColor: 'rgba(37, 99, 234, 0.85)',
                            borderColor: '#2563ea',
                            borderWidth: 1,
                            borderRadius: 8,
                            yAxisID: 'y'
                        },
                        {
                            label: 'عدد الطلبات',
                            data: {!! json_encode($ordersChartValues) !!},
                            type: 'line',
                            borderColor: '#F59E0B',
                            backgroundColor: '#F59E0B',
                            borderWidth: 3,
                            tension: 0.35,
                            pointRadius: 4,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { position: 'top', labels: { font: { family: 'Cairo', weight: 'bold' } } }
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            grid: { color: 'rgba(0,0,0,0.05)' },
                            ticks: { font: { family: 'Cairo' } }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            grid: { drawOnChartArea: false },
                            ticks: { font: { family: 'Cairo' } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Cairo', weight: 'bold' } }
                        }
                    }
                }
            });
        }

        // 2. Payment Methods Doughnut Chart
        const paymentCtx = document.getElementById('paymentMethodsChart');
        if (paymentCtx) {
            new Chart(paymentCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($paymentChartData['labels']) !!},
                    datasets: [{
                        data: {!! json_encode($paymentChartData['values']) !!},
                        backgroundColor: ['#64748B', '#7E22CE', '#EF4444'],
                        borderWidth: 3,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { font: { family: 'Cairo', size: 11, weight: 'bold' } } }
                    },
                    cutout: '70%'
                }
            });
        }

        // 3. Branch Distribution Chart
        const branchCtx = document.getElementById('branchDistributionChart');
        if (branchCtx) {
            new Chart(branchCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($branchChartData['labels']) !!},
                    datasets: [{
                        data: {!! json_encode($branchChartData['values']) !!},
                        backgroundColor: ['#2563ea', '#00A896', '#8B5CF6', '#F59E0B'],
                        borderWidth: 3,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { font: { family: 'Cairo', size: 11, weight: 'bold' } } }
                    },
                    cutout: '65%'
                }
            });
        }

    });
</script>
@endsection
