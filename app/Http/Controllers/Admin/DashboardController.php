<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\CustomerProfile;
use App\Models\CrmLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistics
        $totalSales = Order::where('payment_status', 'paid')->sum('total');
        $totalOrders = Order::count();
        $totalCustomers = User::whereDoesntHave('profile', function($q) {
            // Or we filter out emails with @2morro.com
        })->where('email', '!=', 'admin@2morro.com')
          ->where('email', 'not like', '%@2morro.com')
          ->count();

        $recentOrders = Order::latest()->take(5)->get();

        // 2. Customer Segments distribution
        $segmentsDistribution = CustomerProfile::select('segment', DB::raw('count(*) as count'))
            ->groupBy('segment')
            ->get()
            ->pluck('count', 'segment')
            ->toArray();

        // Ensure all segments exist in the distribution
        $segmentsLabels = [
            'parent' => 'أولياء أمور',
            'specialist' => 'أخصائيين',
            'nursery' => 'حضانات / مراكز',
            'school' => 'مدارس / مؤسسات',
        ];
        
        $segmentStats = [];
        foreach ($segmentsLabels as $key => $label) {
            $segmentStats[$label] = $segmentsDistribution[$key] ?? 0;
        }

        // 3. Sales chart data (last 6 months - compatible with MySQL, MariaDB, and SQLite)
        $isSqlite = DB::connection()->getDriverName() === 'sqlite';
        $monthExpr = $isSqlite ? "strftime('%m', created_at)" : "DATE_FORMAT(created_at, '%m')";

        $salesData = Order::select(
            DB::raw("{$monthExpr} as month"),
            DB::raw('SUM(total) as total')
        )
        ->where('payment_status', 'paid')
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Map months to Arabic names
        $monthsNames = [
            '01' => 'يناير', '02' => 'فبراير', '03' => 'مارس',
            '04' => 'أبريل', '05' => 'مايو', '06' => 'يونيو',
            '07' => 'يوليو', '08' => 'أغسطس', '09' => 'سبتمبر',
            '10' => 'أكتوبر', '11' => 'نوفمبر', '12' => 'ديسمبر'
        ];

        $chartLabels = [];
        $chartValues = [];

        foreach ($salesData as $row) {
            $chartLabels[] = $monthsNames[$row->month] ?? $row->month;
            $chartValues[] = (float) $row->total;
        }

        // If no sales data, put defaults for visual representation
        if (empty($chartLabels)) {
            $chartLabels = ['مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس'];
            $chartValues = [250, 420, 310, 680, 520, 890]; // values just to show chart
        }

        return view('admin.dashboard', compact(
            'totalSales',
            'totalOrders',
            'totalCustomers',
            'recentOrders',
            'segmentStats',
            'chartLabels',
            'chartValues'
        ));
    }
}
