<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Booking;
use App\Models\Product;
use App\Models\User;
use App\Models\CustomerProfile;
use App\Models\Download;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Sales & Revenue KPIs
        $totalSales = Order::where('payment_status', 'paid')->sum('total');
        
        $startThisMonth = Carbon::now()->startOfMonth();
        $startLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endLastMonth = Carbon::now()->subMonth()->endOfMonth();

        $thisMonthSales = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', $startThisMonth)
            ->sum('total');

        $lastMonthSales = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startLastMonth, $endLastMonth])
            ->sum('total');

        $salesGrowth = 0;
        if ($lastMonthSales > 0) {
            $salesGrowth = round((($thisMonthSales - $lastMonthSales) / $lastMonthSales) * 100, 1);
        } elseif ($thisMonthSales > 0) {
            $salesGrowth = 100;
        }

        // 2. Orders Statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::whereIn('status', ['pending', 'processing'])->count();
        $completedOrders = Order::where('status', 'delivered')->count();
        $ordersRequiringProof = Order::whereNotNull('payment_screenshot')
            ->where('payment_status', 'pending')
            ->count();

        // 3. Consultation Bookings KPIs
        $totalBookings = Booking::count();
        $newBookingsCount = Booking::where('status', 'new')->count();
        $confirmedBookingsCount = Booking::where('status', 'confirmed')->count();
        $todayBookingsCount = Booking::whereDate('booking_date', Carbon::today())->count();

        // 4. Products & Stock Alerts
        $activeProductsCount = Product::where('is_active', true)->count();
        $lowStockProducts = Product::where('type', 'physical')
            ->where('stock', '<=', 5)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();
        $lowStockCount = Product::where('type', 'physical')->where('stock', '<=', 5)->count();
        $digitalProductsCount = Product::where('type', 'digital')->count();

        // 5. Customers & Downloads
        $totalCustomers = User::where('email', '!=', 'admin@2morro.com')
            ->where('email', 'not like', '%@2morro.com')
            ->count();
        
        $totalDownloadsCount = class_exists(Download::class) ? Download::sum('download_count') : 0;
        $pendingReviewsCount = class_exists(Review::class) ? Review::where('is_approved', false)->count() : 0;

        // 6. Recent Operational Feeds
        $recentOrders = Order::with('items.product')->latest()->take(6)->get();
        $recentBookings = Booking::latest()->take(6)->get();
        $topProducts = Product::where('is_active', true)->take(5)->get();

        // 7. Monthly Sales Trend (Last 6 Months)
        $isSqlite = DB::connection()->getDriverName() === 'sqlite';
        $monthExpr = $isSqlite ? "strftime('%m', created_at)" : "DATE_FORMAT(created_at, '%m')";

        $monthlyStats = Order::select(
            DB::raw("{$monthExpr} as month"),
            DB::raw("SUM(CASE WHEN payment_status = 'paid' THEN total ELSE 0 END) as sales"),
            DB::raw("COUNT(*) as orders_count")
        )
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $monthsNames = [
            '01' => 'يناير', '02' => 'فبراير', '03' => 'مارس',
            '04' => 'أبريل', '05' => 'مايو', '06' => 'يونيو',
            '07' => 'يوليو', '08' => 'أغسطس', '09' => 'سبتمبر',
            '10' => 'أكتوبر', '11' => 'نوفمبر', '12' => 'ديسمبر'
        ];

        $salesChartLabels = [];
        $salesChartValues = [];
        $ordersChartValues = [];

        foreach ($monthlyStats as $row) {
            $salesChartLabels[] = $monthsNames[$row->month] ?? $row->month;
            $salesChartValues[] = (float) $row->sales;
            $ordersChartValues[] = (int) $row->orders_count;
        }

        if (empty($salesChartLabels)) {
            $salesChartLabels = ['مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس'];
            $salesChartValues = [1200, 2400, 3100, 4800, 6200, 8900];
            $ordersChartValues = [5, 9, 14, 22, 28, 37];
        }

        // 8. Payment Methods Distribution
        $paymentDistribution = Order::select('payment_method', DB::raw('count(*) as count'))
            ->groupBy('payment_method')
            ->get()
            ->pluck('count', 'payment_method')
            ->toArray();

        $paymentLabels = [
            'cod' => 'الدفع عند الاستلام (COD)',
            'instapay' => 'إنستاباي (InstaPay)',
            'wallet' => 'فودافون ومحافظ كاش',
        ];

        $paymentChartData = [
            'labels' => array_values($paymentLabels),
            'values' => [
                $paymentDistribution['cod'] ?? 0,
                $paymentDistribution['instapay'] ?? 0,
                $paymentDistribution['wallet'] ?? 0,
            ]
        ];

        // 9. Branch Bookings Distribution
        $branchDistribution = Booking::select('branch', DB::raw('count(*) as count'))
            ->groupBy('branch')
            ->get()
            ->pluck('count', 'branch')
            ->toArray();

        $branchLabels = [
            'ibrahimya' => 'فرع الإبراهيمية',
            'bitash' => 'فرع أول البيطاش',
            'sidi_beshr' => 'فرع سيدي بشر',
            'online' => 'استشارة أونلاين',
        ];

        $branchChartData = [
            'labels' => array_values($branchLabels),
            'values' => [
                $branchDistribution['ibrahimya'] ?? ($branchDistribution['الإبراهيمية'] ?? 0),
                $branchDistribution['bitash'] ?? ($branchDistribution['البيطاش'] ?? 0),
                $branchDistribution['sidi_beshr'] ?? ($branchDistribution['سيدي بشر'] ?? 0),
                $branchDistribution['online'] ?? ($branchDistribution['أونلاين'] ?? 0),
            ]
        ];

        // 10. Customer Segments (CRM)
        $segmentsDistribution = CustomerProfile::select('segment', DB::raw('count(*) as count'))
            ->groupBy('segment')
            ->get()
            ->pluck('count', 'segment')
            ->toArray();

        $segmentsLabels = [
            'parent' => 'أولياء أمور',
            'specialist' => 'أخصائيين',
            'nursery' => 'حضانات ومراكز',
            'school' => 'مدارس ومؤسسات',
        ];

        $segmentStats = [];
        foreach ($segmentsLabels as $key => $label) {
            $segmentStats[$label] = $segmentsDistribution[$key] ?? 0;
        }

        return view('admin.dashboard', compact(
            'totalSales',
            'thisMonthSales',
            'salesGrowth',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'ordersRequiringProof',
            'totalBookings',
            'newBookingsCount',
            'confirmedBookingsCount',
            'todayBookingsCount',
            'activeProductsCount',
            'lowStockProducts',
            'lowStockCount',
            'digitalProductsCount',
            'totalCustomers',
            'totalDownloadsCount',
            'pendingReviewsCount',
            'recentOrders',
            'recentBookings',
            'topProducts',
            'salesChartLabels',
            'salesChartValues',
            'ordersChartValues',
            'paymentChartData',
            'branchChartData',
            'segmentStats'
        ));
    }
}
