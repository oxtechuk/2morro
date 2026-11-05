<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteVisit;
use App\Models\Order;
use App\Models\Booking;
use App\Models\Product;
use App\Models\DoctorVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Display traffic analytics dashboard.
     */
    public function index(Request $request)
    {
        $period = $request->get('period', '30_days');

        switch ($period) {
            case 'today':
                $startDate = Carbon::today();
                $endDate   = Carbon::now();
                $prevStartDate = Carbon::yesterday();
                $prevEndDate   = Carbon::yesterday()->endOfDay();
                break;
            case '7_days':
                $startDate = Carbon::now()->subDays(7)->startOfDay();
                $endDate   = Carbon::now();
                $prevStartDate = Carbon::now()->subDays(14)->startOfDay();
                $prevEndDate   = Carbon::now()->subDays(7)->endOfDay();
                break;
            case 'this_month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate   = Carbon::now();
                $prevStartDate = Carbon::now()->subMonth()->startOfMonth();
                $prevEndDate   = Carbon::now()->subMonth()->endOfMonth();
                break;
            case '30_days':
            default:
                $startDate = Carbon::now()->subDays(30)->startOfDay();
                $endDate   = Carbon::now();
                $prevStartDate = Carbon::now()->subDays(60)->startOfDay();
                $prevEndDate   = Carbon::now()->subDays(30)->endOfDay();
                break;
        }

        // 1. Core KPIs
        $totalPageviews = SiteVisit::whereBetween('created_at', [$startDate, $endDate])->count();
        $uniqueVisitors = SiteVisit::whereBetween('created_at', [$startDate, $endDate])
            ->distinct('ip_hash')
            ->count('ip_hash');

        $prevUniqueVisitors = SiteVisit::whereBetween('created_at', [$prevStartDate, $prevEndDate])
            ->distinct('ip_hash')
            ->count('ip_hash');

        $growth = 0;
        if ($prevUniqueVisitors > 0) {
            $growth = round((($uniqueVisitors - $prevUniqueVisitors) / $prevUniqueVisitors) * 100, 1);
        } elseif ($uniqueVisitors > 0) {
            $growth = 100;
        }

        // Conversions in same period
        $ordersCount = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $bookingsCount = Booking::whereBetween('created_at', [$startDate, $endDate])->count();
        $videoPurchasesCount = DB::table('doctor_video_access')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $totalConversions = $ordersCount + $bookingsCount + $videoPurchasesCount;
        $conversionRate = $uniqueVisitors > 0 ? round(($totalConversions / $uniqueVisitors) * 100, 2) : 0;

        // 2. Daily Traffic Chart (Pageviews vs Unique Visitors)
        $isSqlite = DB::connection()->getDriverName() === 'sqlite';
        $dateExpr = $isSqlite ? "strftime('%Y-%m-%d', created_at)" : "DATE(created_at)";

        $dailyStats = SiteVisit::select(
            DB::raw("{$dateExpr} as date"),
            DB::raw("COUNT(*) as pageviews"),
            DB::raw("COUNT(DISTINCT ip_hash) as visitors")
        )
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

        $chartLabels = [];
        $chartPageviews = [];
        $chartVisitors = [];

        foreach ($dailyStats as $row) {
            $chartLabels[] = Carbon::parse($row->date)->format('m/d');
            $chartPageviews[] = (int) $row->pageviews;
            $chartVisitors[] = (int) $row->visitors;
        }

        // 3. Traffic Sources Breakdown
        $sourcesStats = SiteVisit::select('source', DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('source')
            ->orderByDesc('count')
            ->get();

        $sourceLabelsMapping = [
            'direct'    => 'زيارات مباشرة (Direct)',
            'facebook'  => 'فيسبوك (Meta / Facebook Ads)',
            'instagram' => 'إنستجرام (Instagram)',
            'tiktok'    => 'تيك توك (TikTok Ads / Reels)',
            'google'    => 'بحث جوجل (Google Organic / Ads)',
            'whatsapp'  => 'واتساب (WhatsApp)',
            'linktree'  => 'لينكتري (Linktree)',
            'youtube'   => 'يوتيوب (YouTube)',
            'referral'  => 'مواقع أخرى (Referrals)',
        ];

        // 4. Device Breakdown
        $deviceStats = SiteVisit::select('device_type', DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('device_type')
            ->orderByDesc('count')
            ->pluck('count', 'device_type')
            ->toArray();

        // 5. Top Visited Pages
        $topPages = SiteVisit::select('path', 'page_type', DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('path', 'page_type')
            ->orderByDesc('count')
            ->take(8)
            ->get();

        // 6. Top Visited Products & Videos
        $topProducts = Product::where('is_active', true)->take(5)->get();
        $topVideos   = DoctorVideo::published()->orderByDesc('views_count')->take(5)->get();

        return view('admin.analytics.index', compact(
            'period',
            'totalPageviews',
            'uniqueVisitors',
            'growth',
            'ordersCount',
            'bookingsCount',
            'videoPurchasesCount',
            'totalConversions',
            'conversionRate',
            'chartLabels',
            'chartPageviews',
            'chartVisitors',
            'sourcesStats',
            'sourceLabelsMapping',
            'deviceStats',
            'topPages',
            'topProducts',
            'topVideos'
        ));
    }
}

