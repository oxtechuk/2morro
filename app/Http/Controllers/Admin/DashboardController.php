<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Booking;
use App\Models\Product;
use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerProfile;
use App\Models\Category;
use App\Models\Shop;
use App\Models\GeneraleSetting;
use App\Models\Transaction;
use App\Models\Withdraw;
use App\Models\Download;
use App\Models\Review;
use App\Repositories\FlashSaleRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
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

    /**
     * Show the ReadyCMS / Multi-Vendor template dashboard.
     */
    public function templateDashboard()
    {
        $generaleSetting = function_exists('generaleSetting') ? generaleSetting('setting') : null;
        if ($generaleSetting instanceof \__PHP_Incomplete_Class) {
            Cache::forget('generale_setting');
            $generaleSetting = Schema::hasTable('generate_settings') ? GeneraleSetting::first() : null;
        }
        $businessModel = $generaleSetting?->shop_type ?? 'single';

        $totalCustomer = Schema::hasTable('customers') 
            ? Customer::count() 
            : (Schema::hasTable('users') ? User::count() : 0);

        $totalRider = Schema::hasTable('drivers') 
            ? \App\Models\Driver::count() 
            : (Schema::hasTable('users') && Schema::hasColumn('users', 'role') ? User::where('role', 'driver')->count() : 0);

        $shop = null;
        $hasOrderShop = false;
        $hasProductShop = false;

        if (!$generaleSetting || $generaleSetting?->shop_type != 'single') {
            $totalShop = Schema::hasTable('shops') ? Shop::count() : 1;
            $totalOrder = Schema::hasTable('orders') ? Order::count() : 0;
            $totalProduct = Schema::hasTable('products') ? Product::count() : 0;
            $totalCategories = Schema::hasTable('categories') ? Category::count() : 0;
        } else {
            $shop = function_exists('generaleSetting') ? generaleSetting('shop') : null;
            $hasOrderShop = $shop && Schema::hasColumn('orders', 'shop_id');
            $hasProductShop = $shop && Schema::hasColumn('products', 'shop_id');
            $totalShop = 0;
            $totalOrder = Schema::hasTable('orders') ? Order::when($hasOrderShop, fn($q) => $q->where('shop_id', $shop?->id))->count() : 0;
            $totalProduct = Schema::hasTable('products') ? Product::when($hasProductShop, fn($q) => $q->where('shop_id', $shop?->id))->count() : 0;
            $totalCategories = Schema::hasTable('categories') ? Category::count() : 0;
        }

        $orderStatuses = enum_exists(OrderStatus::class) ? OrderStatus::cases() : [];

        $hasCustomerOrders = Schema::hasTable('customers') && Schema::hasTable('orders') && (
            Schema::hasColumn('orders', 'customer_id') ||
            (Schema::hasColumn('customers', 'user_id') && Schema::hasColumn('orders', 'user_id'))
        );

        $topCustomers = $hasCustomerOrders 
            ? Customer::withCount('orders')->orderBy('orders_count', 'desc')->limit(8)->get() 
            : (Schema::hasTable('customers') ? Customer::limit(8)->get() : collect([]));

        $topSellingProducts = Schema::hasTable('products') ? Product::take(4)->get() : collect([]);
        $topReviewProducts = Schema::hasTable('products') ? Product::take(4)->get() : collect([]);
        $topShops = Schema::hasTable('shops') ? Shop::take(4)->get() : collect([]);

        $latestOrders = Schema::hasTable('orders')
            ? Order::when($hasOrderShop, fn($q) => $q->where('shop_id', $shop?->id))->latest()->limit(5)->get()
            : collect([]);

        $topFavorites = collect([]);
        $pendingWithdraw = 0;
        $alreadyWithdraw = 0;
        $deniedWithdraw = 0;
        $totalCommission = 0;
        $flashSale = null;

        $statusCounts = [];
        $statusColumn = Schema::hasTable('orders') && Schema::hasColumn('orders', 'order_status') ? 'order_status' : 'status';

        $defaultKeys = ['pending', 'confirm', 'processing', 'pickup', 'onTheWay', 'delivered', 'cancelled'];
        foreach ($defaultKeys as $dk) {
            $statusCounts[$dk] = 0;
        }

        foreach ($orderStatuses as $status) {
            $varName = \Illuminate\Support\Str::camel($status->value);
            $count = 0;
            if (Schema::hasTable('orders')) {
                $count = Cache::remember('admin_status_' . $varName, 60 * 24 * 7, function () use ($status, $statusColumn, $hasOrderShop, $shop) {
                    return Order::when($hasOrderShop, fn($q) => $q->where('shop_id', $shop?->id))
                        ->where($statusColumn, $status->value)
                        ->count();
                });
            }
            $statusCounts[$varName] = $count;
        }

        return view('admin.dashboard-template', array_merge(compact(
            'generaleSetting',
            'businessModel',
            'totalShop',
            'totalOrder',
            'totalCustomer',
            'totalProduct',
            'orderStatuses',
            'topCustomers',
            'topSellingProducts',
            'topReviewProducts',
            'topShops',
            'latestOrders',
            'topFavorites',
            'pendingWithdraw',
            'alreadyWithdraw',
            'deniedWithdraw',
            'totalCommission',
            'totalCategories',
            'flashSale',
            'totalRider'
        ), $statusCounts));
    }

    /**
     * Order statistics for AJAX chart requests.
     */
    public function orderStatistics()
    {
        $type = request('type', 'yearly');
        $date = request('date');

        if (!Schema::hasTable('orders')) {
            return response()->json([
                'message' => 'no orders',
                'data' => ['labels' => [], 'values' => [], 'total' => 0]
            ]);
        }

        if ($type == 'daily') {
            $startDate = now()->startOfWeek();
            $endDate = now()->endOfWeek();
            $datesAndDays = [];

            if ($date) {
                $count = Order::whereDate('created_at', $date)->count();
                $labels = [Carbon::parse($date)->format('l')];
                $values = [$count];

                return response()->json([
                    'message' => 'single day order statistics',
                    'data' => [
                        'labels' => $labels,
                        'values' => $values,
                        'total' => array_sum($values),
                    ]
                ]);
            }

            for ($d = $startDate; $d->lte($endDate); $d->addDay()) {
                $datesAndDays[] = [
                    'date' => $d->toDateString(),
                    'label' => $d->format('l'),
                    'value' => Order::whereDate('created_at', $d->toDateString())->count(),
                ];
            }

            $labels = array_column($datesAndDays, 'label');
            $values = array_column($datesAndDays, 'value');

            return response()->json([
                'message' => 'daily order statistics',
                'data' => [
                    'labels' => $labels,
                    'values' => $values,
                    'total' => array_sum($values),
                ]
            ]);
        } elseif ($type == 'monthly') {
            $startDate = now()->startOfYear();
            $endDate = now()->endOfYear();
            $datesAndMonths = [];

            for ($d = $startDate; $d->lte($endDate); $d->addMonth()) {
                $datesAndMonths[] = [
                    'date' => $d->toDateString(),
                    'label' => $d->format('M'),
                    'value' => Order::whereMonth('created_at', $d->month)->whereYear('created_at', $d->year)->count(),
                ];
            }

            $labels = array_column($datesAndMonths, 'label');
            $values = array_column($datesAndMonths, 'value');

            return response()->json([
                'message' => 'monthly order statistics',
                'data' => [
                    'labels' => $labels,
                    'values' => $values,
                    'total' => array_sum($values),
                ]
            ]);
        } else {
            $datesAndYears = [];

            for ($d = now()->startOfYear(); $d->year >= now()->subYears(6)->year; $d->subYear()) {
                $datesAndYears[] = [
                    'date' => $d->toDateString(),
                    'label' => $d->format('Y'),
                    'value' => Order::whereYear('created_at', $d->year)->count(),
                ];
            }

            $labels = array_column($datesAndYears, 'label');
            $values = array_column($datesAndYears, 'value');

            return response()->json([
                'message' => 'yearly order statistics',
                'data' => [
                    'labels' => $labels,
                    'values' => $values,
                    'total' => array_sum($values),
                ]
            ]);
        }
    }
}
