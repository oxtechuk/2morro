@extends('layouts.storefront')

@section('title', 'أقوى العروض والخصومات الحصرية 🔥 | متجر تمورو 2morro')

@section('content')
<div class="bg-slate-50/60 py-6 sm:py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-5" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1 text-slate-400 hover:text-[#2563ea] transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span>الرئيسية</span>
            </a>
            <svg class="w-3 h-3 text-slate-300 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            <span class="text-rose-600 font-black">صفحة العروض والخصومات</span>
        </nav>

        <!-- Hero Offers Banner -->
        <div class="relative rounded-3xl overflow-hidden min-h-[200px] sm:min-h-[260px] flex items-center bg-gradient-to-r from-rose-900 via-red-800 to-amber-700 p-6 sm:p-10 mb-8 shadow-xl text-white relative">
            <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px] opacity-10"></div>
            
            <div class="relative z-10 max-w-2xl text-right">
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md text-amber-200 text-xs sm:text-sm font-black px-3.5 py-1 rounded-full shadow-xs mb-3 border border-white/20">
                    <span class="animate-pulse text-base">🔥</span>
                    <span>عروض وتخفيضات حصرية ومؤقتة</span>
                </div>

                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white leading-tight drop-shadow-md">
                    وفر أكثر مع عروض <span class="text-amber-300">تمورو</span> الذهبية
                </h1>

                <p class="text-sm sm:text-base text-rose-100 font-semibold mt-2.5 leading-relaxed max-w-xl">
                    اكتشف أفضل الوسائل التعليمية، أدوات التخاطب وتعديل السلوك وباقات التوفير بأسعار مخفضة ونسب خصم تصل حتى 50%.
                </p>

                <div class="inline-flex items-center gap-3 mt-4 text-xs sm:text-sm font-bold">
                    <span class="bg-white text-rose-700 px-3 py-1 rounded-lg shadow-sm">
                        {{ $totalOffersCount }} منتج مخفض متاح الآن
                    </span>
                    <span class="text-rose-200 hidden sm:inline">| الشحن مجاني للطلبات فوق 550 ج.م داخل مصر</span>
                </div>
            </div>

            <!-- Background Aesthetic Decors -->
            <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-amber-400/20 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -top-10 -right-10 w-48 h-48 bg-rose-500/20 rounded-full blur-2xl pointer-events-none"></div>
        </div>

        <!-- Filter & Sorting Bar -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 shadow-sm border border-slate-200/80 mb-8 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
            
            <!-- Category Pills Filter -->
            <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 scrollbar-none text-xs sm:text-sm font-bold">
                <a href="{{ route('offers', array_merge(request()->except(['category', 'page']), ['category' => null])) }}" 
                   class="px-4 py-2 rounded-xl transition-all whitespace-nowrap {{ !$categorySlug ? 'bg-rose-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    جميع العروض ({{ $totalOffersCount }})
                </a>

                @foreach($categories as $category)
                    <a href="{{ route('offers', array_merge(request()->except(['category', 'page']), ['category' => $category->slug])) }}" 
                       class="px-4 py-2 rounded-xl transition-all whitespace-nowrap {{ $categorySlug === $category->slug ? 'bg-rose-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        {{ $category->name }} ({{ $category->products_count }})
                    </a>
                @endforeach
            </div>

            <!-- Sorting Select -->
            <div class="flex items-center gap-2 shrink-0">
                <label for="sort_by" class="text-xs font-bold text-slate-500 whitespace-nowrap">الترتيب حسب:</label>
                <form method="GET" action="{{ route('offers') }}" id="sortForm">
                    @if($categorySlug)
                        <input type="hidden" name="category" value="{{ $categorySlug }}">
                    @endif
                    <select name="sort" id="sort_by" onchange="document.getElementById('sortForm').submit();"
                            class="bg-slate-50 border border-slate-200 text-slate-800 text-xs sm:text-sm font-bold rounded-xl px-3 py-2 focus:ring-rose-500 focus:border-rose-500 cursor-pointer">
                        <option value="discount_desc" {{ $sortBy === 'discount_desc' ? 'selected' : '' }}>الأعلى خصماً %</option>
                        <option value="price_asc" {{ $sortBy === 'price_asc' ? 'selected' : '' }}>السعر: من الأقل للأعلى</option>
                        <option value="price_desc" {{ $sortBy === 'price_desc' ? 'selected' : '' }}>السعر: من الأعلى للأقل</option>
                        <option value="latest" {{ $sortBy === 'latest' ? 'selected' : '' }}>أحدث العروض المضافة</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
                @foreach($products as $product)
                    @include('storefront.partials.product-card', ['product' => $product])
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                {{ $products->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-3xl p-10 sm:p-16 text-center border border-slate-200 shadow-sm max-w-xl mx-auto">
                <div class="w-20 h-20 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                    🔥
                </div>
                <h3 class="text-lg sm:text-xl font-black text-slate-800 mb-2">لا توجد عروض في هذا القسم حالياً</h3>
                <p class="text-xs sm:text-sm text-slate-500 font-semibold mb-6">
                    يمكنك تصفح باقي الفئات أو استكشاف كتالوج المنتجات الكامل لاكتشاف أحدث الألعاب والوسائل المبتكرة.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('offers') }}" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-rose-600 text-white font-bold text-xs sm:text-sm hover:bg-rose-700 transition-colors shadow-sm">
                        عرض كل الخصومات
                    </a>
                    <a href="{{ route('search') }}" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs sm:text-sm hover:bg-slate-200 transition-colors">
                        الذهاب للمتجر الكامل
                    </a>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
