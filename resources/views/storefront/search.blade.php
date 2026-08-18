@extends('layouts.storefront')

@section('title', 'تصفح منتجات تمورو | أدوات وشيتات تعليمية')

@section('content')
<div class="bg-white py-8">
    <div class="max-w-7xl mx-auto px-4">
        
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-4" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1 text-slate-400 hover:text-[#2563EB] transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span>الرئيسية</span>
            </a>
            <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            <a href="{{ route('search') }}" class="{{ !request('category') && !request('q') ? 'text-[#2563EB] font-bold' : 'text-slate-400 hover:text-[#2563EB]' }}">المتجر</a>
            @if(request('category'))
                @php $catObj = $categories->firstWhere('slug', request('category')); @endphp
                <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                <span class="text-[#2563EB] font-bold">{{ $catObj ? $catObj->name : request('category') }}</span>
            @elseif(request('q'))
                <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                <span class="text-[#2563EB] font-bold">بحث: "{{ request('q') }}"</span>
            @endif
        </nav>

        <!-- Dynamic Catalog Banner Header from Settings -->
        @php
            $catalogBannerImg = \App\Models\Setting::get('catalog_banner_image', 'images/hero-child.jpg');
            $catalogBannerVer = file_exists(public_path($catalogBannerImg)) ? filemtime(public_path($catalogBannerImg)) : time();
            $catObj = request('category') ? $categories->firstWhere('slug', request('category')) : null;
        @endphp
        <div class="relative rounded-[32px] overflow-hidden min-h-[220px] sm:min-h-[260px] flex items-center bg-cover bg-center mb-8 shadow-md border border-slate-100"
             style="background-image: url('{{ asset($catalogBannerImg) }}?v={{ $catalogBannerVer }}');">
            
            <!-- Subtle dark gradient overlay for text readability -->
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/85 via-slate-950/50 to-transparent"></div>

            <div class="relative z-10 w-full px-6 sm:px-10 lg:px-12 py-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-6 text-right">
                
                <div class="max-w-2xl">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-1.5 bg-[#EF4444] text-white text-xs font-black px-3.5 py-1 rounded-full shadow-md mb-3">
                        <span>⚡ @if(request('q')) نتائج البحث @elseif(request('category')) {{ $catObj ? $catObj->name : 'قسم مختار' }} @else كتالوج متجر تمورو @endif</span>
                    </div>

                    <!-- Dynamic Title -->
                    <h1 class="text-2xl sm:text-4xl font-black text-white leading-tight drop-shadow-md">
                        @if(request('q'))
                            نتائج البحث عن: <span class="text-cyan-300">"{{ request('q') }}"</span>
                        @elseif(request('category'))
                            {{ $catObj ? $catObj->name : 'تصفح القسم' }}
                        @else
                            {{ \App\Models\Setting::get('catalog_banner_title', 'استكشف أفضل الأدوات والأنشطة التعليمية') }}
                        @endif
                    </h1>

                    <p class="text-xs sm:text-sm text-slate-100 font-semibold mt-2 leading-relaxed max-w-xl drop-shadow-sm">
                        {{ \App\Models\Setting::get('catalog_banner_subtitle', 'اختر ما يناسب عمر واحتياج طفلك لتطوير مهاراته خطوة بخطوة.') }}
                    </p>

                    <div class="inline-flex items-center gap-2 mt-3 text-xs font-bold text-slate-200">
                        <span>تم العثور على <b class="text-white bg-white/20 px-2 py-0.5 rounded-md">{{ $products->total() }}</b> منتج</span>
                    </div>
                </div>

                <!-- Sorting Pill Dropdown -->
                <form action="{{ route('search') }}" method="GET" id="sortForm" class="flex items-center gap-2 bg-black/50 backdrop-blur-md px-4 py-2.5 rounded-2xl border border-white/25 text-white text-xs shadow-lg">
                    @foreach(request()->except(['sort', 'page']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    
                    <span class="font-bold whitespace-nowrap flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path></svg>
                        <span>ترتيب حسب:</span>
                    </span>
                    <select name="sort" onchange="document.getElementById('sortForm').submit()" class="bg-transparent border-0 text-xs font-black text-cyan-200 focus:ring-0 p-0 cursor-pointer">
                        <option value="latest" class="bg-slate-900 text-white" {{ request('sort') === 'latest' ? 'selected' : '' }}>الأحدث أولاً</option>
                        <option value="price_asc" class="bg-slate-900 text-white" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>السعر: الأقل أولاً</option>
                        <option value="price_desc" class="bg-slate-900 text-white" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>السعر: الأعلى أولاً</option>
                    </select>
                </form>

            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Filters Sidebar (Right Column in RTL, span 3) -->
            <aside class="lg:col-span-3 bg-slate-50 p-6 rounded-3xl border border-slate-200 h-fit">
                <div class="flex justify-between items-center pb-4 border-b border-slate-200 mb-6">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        تصفية النتائج
                    </h3>
                    @if(request()->anyFilled(['q', 'category', 'age', 'need', 'skill', 'type']))
                        <a href="{{ route('search') }}" class="text-[10px] font-extrabold text-red-500 hover:underline">مسح الكل</a>
                    @endif
                </div>

                <!-- 1. Category Filter -->
                <div class="mb-6 pb-6 border-b border-slate-200">
                    <h4 class="text-xs font-bold text-slate-700 mb-3">القسم الرئيسي</h4>
                    <div class="flex flex-col gap-2 text-xs">
                        <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="flex items-center justify-between font-semibold {{ !request('category') ? 'text-brand-blue font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                            <span>كل الأقسام</span>
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ request()->fullUrlWithQuery(['category' => $cat->slug]) }}" class="flex items-center justify-between font-semibold {{ request('category') === $cat->slug ? 'text-brand-blue font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                                <span>{{ $cat->name }}</span>
                                <span class="text-[10px] bg-slate-200/50 py-0.5 px-2 rounded-full font-bold text-slate-400">{{ $cat->products()->count() }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- 2. Age Groups Filter -->
                <div class="mb-6 pb-6 border-b border-slate-200">
                    <h4 class="text-xs font-bold text-slate-700 mb-3">حسب عمر الطفل</h4>
                    <div class="flex flex-col gap-2.5 text-xs font-semibold">
                        <a href="{{ request()->fullUrlWithQuery(['age' => null]) }}" class="flex items-center gap-2 {{ !request('age') ? 'text-brand-blue font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ !request('age') ? 'bg-brand-blue' : 'bg-slate-300' }}"></span>
                            <span>الكل</span>
                        </a>
                        @foreach($ageGroups as $age)
                            <a href="{{ request()->fullUrlWithQuery(['age' => $age->slug]) }}" class="flex items-center gap-2 {{ request('age') === $age->slug ? 'text-brand-blue font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ request('age') === $age->slug ? 'bg-brand-blue' : 'bg-slate-300' }}"></span>
                                <span>{{ $age->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- 3. Needs Filter -->
                <div class="mb-6 pb-6 border-b border-slate-200">
                    <h4 class="text-xs font-bold text-slate-700 mb-3">حسب احتياج طفلك</h4>
                    <div class="flex flex-col gap-2.5 text-xs font-semibold">
                        <a href="{{ request()->fullUrlWithQuery(['need' => null]) }}" class="flex items-center gap-2 {{ !request('need') ? 'text-brand-blue font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ !request('need') ? 'bg-brand-blue' : 'bg-slate-300' }}"></span>
                            <span>الكل</span>
                        </a>
                        @foreach($needs as $need)
                            <a href="{{ request()->fullUrlWithQuery(['need' => $need->slug]) }}" class="flex items-center gap-2 {{ request('need') === $need->slug ? 'text-brand-blue font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ request('need') === $need->slug ? 'bg-brand-blue' : 'bg-slate-300' }}"></span>
                                <span>{{ $need->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- 4. Skills Filter -->
                <div class="mb-6 pb-6 border-b border-slate-200">
                    <h4 class="text-xs font-bold text-slate-700 mb-3">حسب المهارة المستهدفة</h4>
                    <div class="flex flex-col gap-2.5 text-xs font-semibold">
                        <a href="{{ request()->fullUrlWithQuery(['skill' => null]) }}" class="flex items-center gap-2 {{ !request('skill') ? 'text-brand-blue font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ !request('skill') ? 'bg-brand-blue' : 'bg-slate-300' }}"></span>
                            <span>الكل</span>
                        </a>
                        @foreach($skills as $skill)
                            <a href="{{ request()->fullUrlWithQuery(['skill' => $skill->slug]) }}" class="flex items-center gap-2 {{ request('skill') === $skill->slug ? 'text-brand-blue font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ request('skill') === $skill->slug ? 'bg-brand-blue' : 'bg-slate-300' }}"></span>
                                <span>{{ $skill->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- 5. Product Type Filter -->
                <div>
                    <h4 class="text-xs font-bold text-slate-700 mb-3">طبيعة المنتج</h4>
                    <div class="flex flex-col gap-2.5 text-xs font-semibold">
                        <a href="{{ request()->fullUrlWithQuery(['type' => null]) }}" class="flex items-center gap-2 {{ !request('type') ? 'text-brand-blue font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ !request('type') ? 'bg-brand-blue' : 'bg-slate-300' }}"></span>
                            <span>الكل</span>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['type' => 'physical']) }}" class="flex items-center gap-2 {{ request('type') === 'physical' ? 'text-brand-blue font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request('type') === 'physical' ? 'bg-brand-blue' : 'bg-slate-300' }}"></span>
                            <span>أدوات مادية وملموسة</span>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['type' => 'digital']) }}" class="flex items-center gap-2 {{ request('type') === 'digital' ? 'text-brand-blue font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request('type') === 'digital' ? 'bg-brand-blue' : 'bg-slate-300' }}"></span>
                            <span>شيتات رقمية قابلة للطباعة</span>
                        </a>
                    </div>
                </div>

            </aside>

            <!-- Catalog Grid (Left Column, span 9) -->
            <div class="lg:col-span-9 flex flex-col justify-between">
                
                @if($products->isEmpty())
                    <!-- Empty State -->
                    <div class="bg-slate-50 rounded-3xl border border-slate-200 py-16 px-6 text-center flex flex-col items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                            🔍
                        </div>
                        <h3 class="text-base font-bold text-slate-700">لم نعثر على أي منتجات مطابقة للتصفية</h3>
                        <p class="text-xs text-slate-400 max-w-sm">جرب إزالة بعض الفلاتر المحددة أو ابحث بكلمات مختلفة مثل: "لغة"، "تأسيس"، "تخاطب".</p>
                        <a href="{{ route('search') }}" class="bg-[#102A63] hover:bg-slate-800 text-white font-bold text-xs py-2 px-6 rounded-full mt-4 transition-all">تصفح كل المنتجات</a>
                    </div>
                @else
                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            @include('storefront.partials.product-card', ['product' => $product])
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12 flex justify-center">
                        {{ $products->links() }}
                    </div>
                @endif

            </div>

        </div>

    </div>
</div>
@endsection
