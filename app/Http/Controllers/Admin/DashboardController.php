<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\GeneraleSetting;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdraw;
use App\Repositories\FlashSaleRepository;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $generaleSetting = function_exists('generaleSetting') ? generaleSetting('setting') : null;
        if ($generaleSetting instanceof \__PHP_Incomplete_Class) {
            \Illuminate\Support\Facades\Cache::forget('generale_setting');
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

        $hasOrderShop = $shop && Schema::hasColumn('orders', 'shop_id');
        $hasProductShop = $shop && Schema::hasColumn('products', 'shop_id');

        if (! $generaleSetting || $generaleSetting?->shop_type != 'single') {
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

        $productObject = Schema::hasTable('products') ? Product::when($hasProductShop, function ($query) use ($shop) {
            return $query->where('shop_id', $shop?->id);
        }) : null;

        $hasOrderItems = Schema::hasTable('order_products') || Schema::hasTable('order_items');
        $topSellingProducts = ($productObject && Schema::hasTable('orders') && $hasOrderItems) 
            ? (clone $productObject)->withCount('orders')->orderBy('orders_count', 'desc')->limit(8)->get() 
            : ($productObject ? (clone $productObject)->latest('id')->limit(8)->get() : collect([]));

        $topReviewProducts = ($productObject && Schema::hasTable('reviews')) 
            ? (clone $productObject)->withAvg('reviews as average_rating', 'rating')->orderBy('average_rating', 'desc')->limit(8)->get() 
            : ($productObject ? (clone $productObject)->latest('id')->limit(8)->get() : collect([]));

        $hasShopOrders = Schema::hasTable('shops') && Schema::hasTable('orders') && Schema::hasColumn('orders', 'shop_id');
        $topShops = $hasShopOrders 
            ? Shop::withCount('orders')->orderBy('orders_count', 'desc')->limit(8)->get() 
            : (Schema::hasTable('shops') ? Shop::limit(8)->get() : collect([]));

        $latestOrders = Schema::hasTable('orders') ? Order::when($hasOrderShop, function ($query) use ($shop) {
            return $query->where('shop_id', $shop?->id);
        })->latest('id')->limit(6)->get() : collect([]);

        $topFavorites = ($productObject && Schema::hasTable('favorites')) 
            ? (clone $productObject)->whereHas('favorites')->withCount('favorites')->orderBy('favorites_count', 'desc')->limit(8)->get() 
            : collect([]);

        $pendingWithdraw = Schema::hasTable('withdraws') ? Withdraw::where('status', 'pending')->sum('amount') : 0;
        $alreadyWithdraw = Schema::hasTable('withdraws') ? Withdraw::where('status', 'approved')->sum('amount') : 0;
        $deniedWithdraw = Schema::hasTable('withdraws') ? Withdraw::where('status', 'denied')->sum('amount') : 0;

        $totalCommission = Schema::hasTable('transactions') ? Transaction::where('is_commission', true)->sum('amount') : 0;

        $flashSale = (Schema::hasTable('flash_sales') && class_exists(FlashSaleRepository::class)) 
            ? FlashSaleRepository::getIncoming()->first() 
            : null;

        $statusCounts = [];
        $statusColumn = Schema::hasColumn('orders', 'order_status') ? 'order_status' : (Schema::hasColumn('orders', 'status') ? 'status' : null);

        foreach ($orderStatuses as $status) {
            $varName = \Illuminate\Support\Str::camel($status->value);
            $count = 0;
            if (Schema::hasTable('orders') && $statusColumn) {
                $count = \Illuminate\Support\Facades\Cache::remember('admin_status_' . $varName, 60 * 24 * 7, function () use ($status, $statusColumn, $hasOrderShop, $shop) {
                    return Order::when($hasOrderShop, fn($q) => $q->where('shop_id', $shop?->id))
                        ->where($statusColumn, $status->value)
                        ->count();
                });
            }
            $statusCounts[$varName] = $count;
        }

        return view('admin.dashboard', array_merge(compact(
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

    public function orderStatistics()
    {
        $type = request('type');
        $date = request('date');
        $generaleSetting = function_exists('generaleSetting') ? generaleSetting('setting') : null;
        if ($generaleSetting instanceof \__PHP_Incomplete_Class) {
            \Illuminate\Support\Facades\Cache::forget('generale_setting');
            $generaleSetting = Schema::hasTable('generate_settings') ? GeneraleSetting::first() : null;
        }
        $shop = $generaleSetting?->shop_type == 'single' ? (function_exists('generaleSetting') ? generaleSetting('shop') : null) : null;
        $hasOrderShop = $shop && Schema::hasColumn('orders', 'shop_id');

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
                $count = Order::when($hasOrderShop, function ($query) use ($shop) {
                    return $query->where('shop_id', $shop?->id);
                })->whereDate('created_at', $date)->count();

                $labels = [\Carbon\Carbon::parse($date)->format('l')];
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

            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                $datesAndDays[] = [
                    'date' => $date->toDateString(),
                    'label' => $date->format('l'),
                    'value' => Order::when($hasOrderShop, function ($query) use ($shop) {
                        return $query->where('shop_id', $shop?->id);
                    })->whereDate('created_at', $date->toDateString())->count(),
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

            for ($date = $startDate; $date->lte($endDate); $date->addMonth()) {
                $datesAndMonths[] = [
                    'date' => $date->toDateString(),
                    'label' => $date->format('M'),
                    'value' => Order::when($hasOrderShop, function ($query) use ($shop) {
                        return $query->where('shop_id', $shop?->id);
                    })->whereMonth('created_at', $date->month)
                        ->whereYear('created_at', $date->year)
                        ->count(),
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

            for ($date = now()->startOfYear(); $date->year >= now()->subYears(6)->year; $date->subYear()) {
                $datesAndYears[] = [
                    'date' => $date->toDateString(),
                    'label' => $date->format('Y'),
                    'value' => Order::when($hasOrderShop, function ($query) use ($shop) {
                        return $query->where('shop_id', $shop?->id);
                    })->whereYear('created_at', $date->year)->count(),
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
