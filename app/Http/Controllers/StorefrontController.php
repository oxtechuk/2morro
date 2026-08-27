<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\AgeGroup;
use App\Models\Skill;
use App\Models\Need;
use App\Models\Review;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Models\Banner;

class StorefrontController extends Controller
{
    // Homepage
    public function index()
    {
        $categories = Category::where('is_active', true)->get();
        $ageGroups = AgeGroup::all();
        $skills = Skill::all();
        $needs = Need::all();

        // Get active banners for Hero Slider
        $banners = Banner::active()->get();

        // 1. Promo Section Dynamic Settings
        $promoSettings = [
            'deals_title' => \App\Models\Setting::get('promo_deals_title', 'عروض الأسبوع'),
            'deals_subtitle' => \App\Models\Setting::get('promo_deals_subtitle', 'خصومات تصل إلي'),
            'deals_discount' => \App\Models\Setting::get('promo_deals_discount', '30%'),
            'deals_btn_text' => \App\Models\Setting::get('promo_deals_btn_text', 'تسوق الآن'),
            'deals_btn_link' => \App\Models\Setting::get('promo_deals_btn_link', '/search?category=educational-bundles'),
            'deals_image' => \App\Models\Setting::get('promo_deals_image', 'images/promo-gift.jpg'),
            'deals_gradient' => \App\Models\Setting::get('promo_deals_gradient', 'blue'),
            'group1_title' => \App\Models\Setting::get('promo_group1_title', 'الأكثر مبيعاً'),
            'group1_link' => \App\Models\Setting::get('promo_group1_link', '/search'),
            'group2_title' => \App\Models\Setting::get('promo_group2_title', 'الجديد لدينا'),
            'group2_link' => \App\Models\Setting::get('promo_group2_link', '/search'),
        ];

        // 2. Load Group 1 Products (Bestsellers or Custom Selected)
        $group1Source = \App\Models\Setting::get('promo_group1_source', 'bestsellers');
        $group1RawIds = \App\Models\Setting::get('promo_group1_product_ids', '[]');
        $group1Ids = is_array($group1RawIds) ? $group1RawIds : (json_decode($group1RawIds, true) ?: []);

        if ($group1Source === 'custom' && !empty($group1Ids)) {
            $bestSellers = Product::where('is_active', true)->whereIn('id', $group1Ids)->take(4)->get();
            if ($bestSellers->isEmpty()) {
                $bestSellers = Product::where('is_active', true)->take(4)->get();
            }
        } else {
            $bestSellers = Product::where('is_active', true)
                ->where('badge', 'الأكثر مبيعاً')
                ->take(4)
                ->get();
            if ($bestSellers->isEmpty()) {
                $bestSellers = Product::where('is_active', true)->take(4)->get();
            }
        }

        // 3. Load Group 2 Products (New Arrivals or Custom Selected)
        $group2Source = \App\Models\Setting::get('promo_group2_source', 'newest');
        $group2RawIds = \App\Models\Setting::get('promo_group2_product_ids', '[]');
        $group2Ids = is_array($group2RawIds) ? $group2RawIds : (json_decode($group2RawIds, true) ?: []);

        if ($group2Source === 'custom' && !empty($group2Ids)) {
            $newArrivals = Product::where('is_active', true)->whereIn('id', $group2Ids)->take(4)->get();
            if ($newArrivals->isEmpty()) {
                $newArrivals = Product::where('is_active', true)->latest()->take(4)->get();
            }
        } else {
            $newArrivals = Product::where('is_active', true)
                ->latest()
                ->take(4)
                ->get();
        }

        // Get all products for the 4x3 filtered section
        $allProducts = Product::where('is_active', true)
            ->with(['categories', 'skills', 'needs', 'ageGroups'])
            ->latest()
            ->take(16)
            ->get();

        // Get approved reviews
        $reviews = Review::where('is_approved', true)->latest()->take(6)->get();

        // Homepage bottom sleek banner settings
        $bottomBanner = [
            'image' => \App\Models\Setting::get('home_bottom_banner_image', 'images/hero-child.jpg'),
            'title' => \App\Models\Setting::get('home_bottom_banner_title', 'مركز 2morro لتنمية مهارات الطفل'),
            'subtitle' => \App\Models\Setting::get('home_bottom_banner_subtitle', 'جلسات تخاطب وتعديل سلوك وتدخل مبكر وتقييمات شاملة في المركز وأونلاين بإشراف أ. هبة الله أكرم'),
            'btn1_text' => \App\Models\Setting::get('home_bottom_banner_btn1_text', 'حجز استشارة وتقييم'),
            'btn1_link' => \App\Models\Setting::get('home_bottom_banner_btn1_link', '/booking'),
            'btn2_text' => \App\Models\Setting::get('home_bottom_banner_btn2_text', 'تواصل واتساب'),
            'btn2_link' => \App\Models\Setting::get('home_bottom_banner_btn2_link', 'https://wa.me/201550504512'),
        ];

        // Homepage Triple Feature Cards (Matching attached reference mockup: Blue, Teal, Red)
        $featureCards = [
            'card1' => [
                'title' => \App\Models\Setting::get('feature_card_1_title', 'ألعاب تنمية المهارات'),
                'subtitle' => \App\Models\Setting::get('feature_card_1_subtitle', 'عروض وتخفيضات مذهلة على ألعاب الطفل!'),
                'btn_text' => \App\Models\Setting::get('feature_card_1_btn_text', 'عرض المجموعة'),
                'btn_link' => \App\Models\Setting::get('feature_card_1_btn_link', '/search?category=educational-tools'),
                'image' => \App\Models\Setting::get('feature_card_1_image', 'images/card-truck.jpg'),
                'bg' => \App\Models\Setting::get('feature_card_1_bg', '#0052CC'),
            ],
            'card2' => [
                'title' => \App\Models\Setting::get('feature_card_2_title', 'مجموعة تنمية الذكاء'),
                'subtitle' => \App\Models\Setting::get('feature_card_2_subtitle', 'خصم 15% على أدوات وألعاب الطفل!'),
                'btn_text' => \App\Models\Setting::get('feature_card_2_btn_text', 'عرض المجموعة'),
                'btn_link' => \App\Models\Setting::get('feature_card_2_btn_link', '/search?category=educational-bundles'),
                'image' => \App\Models\Setting::get('feature_card_2_image', 'images/card-blocks.jpg'),
                'bg' => \App\Models\Setting::get('feature_card_2_bg', '#00A896'),
            ],
            'card3' => [
                'title' => \App\Models\Setting::get('feature_card_3_title', 'باقات وعروض التوفير'),
                'subtitle' => \App\Models\Setting::get('feature_card_3_subtitle', 'خصم 15% على الأدوات والوسائل التعليمية!'),
                'btn_text' => \App\Models\Setting::get('feature_card_3_btn_text', 'عرض المجموعة'),
                'btn_link' => \App\Models\Setting::get('feature_card_3_btn_link', '/search?category=digital-worksheets'),
                'image' => \App\Models\Setting::get('feature_card_3_image', 'images/card-dino.jpg'),
                'bg' => \App\Models\Setting::get('feature_card_3_bg', '#e96e1e'),
            ],
        ];

        // Homepage Brands / Partners (Top & Bottom Opposite Marquee Rows)
        $topBrands = \App\Models\Brand::where('is_active', true)->where('row', 'top')->orderBy('sort_order', 'asc')->get();
        $bottomBrands = \App\Models\Brand::where('is_active', true)->where('row', 'bottom')->orderBy('sort_order', 'asc')->get();

        if ($topBrands->isEmpty() && $bottomBrands->isEmpty()) {
            $allBrands = \App\Models\Brand::where('is_active', true)->orderBy('sort_order', 'asc')->get();
            $topBrands = $allBrands;
            $bottomBrands = $allBrands;
        } elseif ($bottomBrands->isEmpty()) {
            $bottomBrands = $topBrands;
        } elseif ($topBrands->isEmpty()) {
            $topBrands = $bottomBrands;
        }

        return view('storefront.index', compact(
            'banners',
            'promoSettings',
            'bottomBanner',
            'featureCards',
            'topBrands',
            'bottomBrands',
            'categories',
            'ageGroups',
            'skills',
            'needs',
            'newArrivals',
            'bestSellers',
            'allProducts',
            'reviews'
        ));
    }


    // Product Detail Page
    public function product(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        // Fetch related products (same category or needs)
        $relatedProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->whereHas('categories', function($q) use ($product) {
                $q->whereIn('categories.id', $product->categories->pluck('id'));
            })
            ->take(4)
            ->get();

        return view('storefront.product', compact('product', 'relatedProducts'));
    }

    // Catalog search and filter page
    public function search(Request $request)
    {
        $query = Product::where('is_active', true);

        // Keywords
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('short_description', 'like', "%{$q}%")
                    ->orWhereHas('skills', function($skillQ) use ($q) {
                        $skillQ->where('name', 'like', "%{$q}%");
                    })
                    ->orWhereHas('needs', function($needQ) use ($q) {
                        $needQ->where('name', 'like', "%{$q}%");
                    });
            });
        }

        // Filter by Brand
        if ($request->filled('brand')) {
            $brandSlug = $request->input('brand');
            $query->where(function($bQ) use ($brandSlug) {
                $bQ->whereHas('brand', function($q) use ($brandSlug) {
                    $q->where('slug', $brandSlug)->orWhere('name', 'like', "%{$brandSlug}%");
                })
                ->orWhere('name', 'like', "%{$brandSlug}%")
                ->orWhere('description', 'like', "%{$brandSlug}%");
            });
        }

        // Filter by Category
        if ($request->filled('category')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('slug', $request->input('category'));
            });
        }

        // Filter by Age
        if ($request->filled('age')) {
            $query->whereHas('ageGroups', function($q) use ($request) {
                $q->where('slug', $request->input('age'));
            });
        }

        // Filter by Need
        if ($request->filled('need')) {
            $query->whereHas('needs', function($q) use ($request) {
                $q->where('slug', $request->input('need'));
            });
        }

        // Filter by Skill
        if ($request->filled('skill')) {
            $query->whereHas('skills', function($q) use ($request) {
                $q->where('slug', $request->input('skill'));
            });
        }

        // Filter by Type
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        if ($sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->get();
        $ageGroups = AgeGroup::all();
        $skills = Skill::all();
        $needs = Need::all();

        return view('storefront.search', compact(
            'products',
            'categories',
            'ageGroups',
            'skills',
            'needs'
        ));
    }

    // Dynamic XML Sitemap
    public function sitemap()
    {
        $products = Product::where('is_active', true)->latest()->get();
        $categories = Category::where('is_active', true)->get();
        $ageGroups = AgeGroup::all();
        $skills = Skill::all();
        $needs = Need::all();

        return response()->view('storefront.sitemap', compact(
            'products',
            'categories',
            'ageGroups',
            'skills',
            'needs'
        ))->header('Content-Type', 'text/xml');
    }
}
