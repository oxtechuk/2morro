@extends('layouts.storefront')

@section('title', 'تصفح منتجات تمورو | أدوات وشيتات تعليمية')

@section('content')
<div class="bg-white py-6 sm:py-8" x-data="{ mobileFilterOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-4" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1 text-slate-400 hover:text-[#2563ea] transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span>الرئيسية</span>
            </a>
            <svg class="w-3 h-3 text-slate-300 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            <a href="{{ route('search') }}" class="{{ !request('category') && !request('q') ? 'text-[#2563ea] font-bold' : 'text-slate-400 hover:text-[#2563ea]' }}">المتجر والكتالوج</a>
            @if(request('category'))
                @php $catObj = $categories->firstWhere('slug', request('category')); @endphp
                <svg class="w-3 h-3 text-slate-300 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                <span class="text-[#2563ea] font-bold">{{ $catObj ? $catObj->name : request('category') }}</span>
            @elseif(request('q'))
                <svg class="w-3 h-3 text-slate-300 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                <span class="text-[#2563ea] font-bold">بحث: "{{ request('q') }}"</span>
            @endif
        </nav>

        <!-- Dynamic Catalog Banner Header -->
        @php
            $catalogBannerImg = \App\Models\Setting::get('catalog_banner_image', 'images/hero-child.jpg');
            $catalogBannerVer = file_exists(public_path($catalogBannerImg)) ? filemtime(public_path($catalogBannerImg)) : time();
            $catObj = request('category') ? $categories->firstWhere('slug', request('category')) : null;
        @endphp
        <div class="relative rounded-3xl overflow-hidden min-h-[180px] sm:min-h-[240px] flex items-center bg-cover bg-center mb-6 sm:mb-8 shadow-md border border-slate-100"
             style="background-image: url('{{ asset($catalogBannerImg) }}?v={{ $catalogBannerVer }}');">
            
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/85 via-slate-950/50 to-transparent"></div>

            <div class="relative z-10 w-full px-5 sm:px-10 lg:px-12 py-6 sm:py-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 sm:gap-6 text-right">
                
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-1.5 bg-[#EF4444] text-white text-[11px] sm:text-xs font-black px-3 py-0.5 sm:py-1 rounded-full shadow-md mb-2 sm:mb-3">
                        <span>@if(request('q')) نتائج البحث @elseif(request('category')) {{ $catObj ? $catObj->name : 'قسم مختار' }} @else كتالوج متجر تمورو @endif</span>
                    </div>

                    <h1 class="text-xl sm:text-3xl lg:text-4xl font-black text-white leading-tight drop-shadow-md">
                        @if(request('q'))
                            نتائج البحث عن: <span class="text-cyan-300">"{{ request('q') }}"</span>
                        @elseif(request('category'))
                            {{ $catObj ? $catObj->name : 'تصفح القسم' }}
                        @else
                            {{ \App\Models\Setting::get('catalog_banner_title', 'استكشف أفضل الأدوات والأنشطة التعليمية') }}
                        @endif
                    </h1>

                    <p class="text-xs sm:text-sm text-slate-100 font-semibold mt-1.5 leading-relaxed max-w-xl drop-shadow-xs">
                        {{ \App\Models\Setting::get('catalog_banner_subtitle', 'اختر ما يناسب عمر واحتياج طفلك لتطوير مهاراته خطوة بخطوة.') }}
                    </p>

                    <div class="inline-flex items-center gap-2 mt-2.5 text-xs font-bold text-slate-200">
                        <span>تم العثور على <b class="text-white bg-white/20 px-2 py-0.5 rounded-md">{{ $products->total() }}</b> منتج</span>
                    </div>
                </div>

                <!-- Sorting Pill Dropdown -->
                <form action="{{ route('search') }}" method="GET" id="sortForm" class="flex items-center gap-2 bg-black/60 backdrop-blur-md px-3.5 py-2 rounded-2xl border border-white/25 text-white text-xs shadow-lg self-stretch sm:self-auto justify-between sm:justify-start">
                    @foreach(request()->except(['sort', 'page']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    
                    <span class="font-bold whitespace-nowrap flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path></svg>
                        <span>ترتيب:</span>
                    </span>
                    <select name="sort" onchange="document.getElementById('sortForm').submit()" class="bg-transparent border-0 text-xs font-black text-cyan-200 focus:ring-0 p-0 cursor-pointer">
                        <option value="latest" class="bg-slate-900 text-white" {{ request('sort') === 'latest' ? 'selected' : '' }}>الأحدث أولاً</option>
                        <option value="price_asc" class="bg-slate-900 text-white" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>السعر: الأقل</option>
                        <option value="price_desc" class="bg-slate-900 text-white" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>السعر: الأعلى</option>
                    </select>
                </form>

            </div>
        </div>

        <!-- Mobile Filter Action Bar (Visible only on mobile) -->
        <div class="lg:hidden flex items-center justify-between gap-3 mb-5 p-3 rounded-2xl bg-slate-50 border border-slate-200">
            <button @click="mobileFilterOpen = true" class="flex-1 py-2.5 px-4 bg-[#2563ea] text-white text-xs font-black rounded-xl flex items-center justify-center gap-2 shadow-xs active:scale-95 transition-transform">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                <span>تصفية وفلترة المنتجات</span>
                @php
                    $filterCount = 0;
                    if(request('category')) $filterCount++;
                    if(request('age')) $filterCount++;
                    if(request('need')) $filterCount++;
                    if(request('skill')) $filterCount++;
                    if(request('type')) $filterCount++;
                @endphp
                @if($filterCount > 0)
                    <span class="w-5 h-5 rounded-full bg-white text-[#2563ea] text-[10px] font-black flex items-center justify-center">
                        {{ $filterCount }}
                    </span>
                @endif
            </button>

            @if(request()->anyFilled(['q', 'category', 'age', 'need', 'skill', 'type']))
                <a href="{{ route('search') }}" class="py-2.5 px-4 bg-red-50 text-red-600 text-xs font-bold rounded-xl hover:bg-red-100 transition-colors whitespace-nowrap">
                    مسح الفلاتر
                </a>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Filters Sidebar (Desktop View, span 3) -->
            <aside class="hidden lg:block lg:col-span-3 bg-slate-50 p-6 rounded-3xl border border-slate-200 h-fit">
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
                        <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="flex items-center justify-between font-semibold {{ !request('category') ? 'text-[#2563ea] font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                            <span>كل الأقسام</span>
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ request()->fullUrlWithQuery(['category' => $cat->slug]) }}" class="flex items-center justify-between font-semibold {{ request('category') === $cat->slug ? 'text-[#2563ea] font-bold' : 'text-slate-500 hover:text-slate-800' }}">
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
                        <a href="{{ request()->fullUrlWithQuery(['age' => null]) }}" class="flex items-center gap-2 {{ !request('age') ? 'text-[#2563ea] font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ !request('age') ? 'bg-[#2563ea]' : 'bg-slate-300' }}"></span>
                            <span>الكل</span>
                        </a>
                        @foreach($ageGroups as $age)
                            <a href="{{ request()->fullUrlWithQuery(['age' => $age->slug]) }}" class="flex items-center gap-2 {{ request('age') === $age->slug ? 'text-[#2563ea] font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ request('age') === $age->slug ? 'bg-[#2563ea]' : 'bg-slate-300' }}"></span>
                                <span>{{ $age->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- 3. Needs Filter -->
                <div class="mb-6 pb-6 border-b border-slate-200">
                    <h4 class="text-xs font-bold text-slate-700 mb-3">حسب احتياج طفلك</h4>
                    <div class="flex flex-col gap-2.5 text-xs font-semibold">
                        <a href="{{ request()->fullUrlWithQuery(['need' => null]) }}" class="flex items-center gap-2 {{ !request('need') ? 'text-[#2563ea] font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ !request('need') ? 'bg-[#2563ea]' : 'bg-slate-300' }}"></span>
                            <span>الكل</span>
                        </a>
                        @foreach($needs as $need)
                            <a href="{{ request()->fullUrlWithQuery(['need' => $need->slug]) }}" class="flex items-center gap-2 {{ request('need') === $need->slug ? 'text-[#2563ea] font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ request('need') === $need->slug ? 'bg-[#2563ea]' : 'bg-slate-300' }}"></span>
                                <span>{{ $need->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- 4. Skills Filter -->
                <div class="mb-6 pb-6 border-b border-slate-200">
                    <h4 class="text-xs font-bold text-slate-700 mb-3">حسب المهارة المستهدفة</h4>
                    <div class="flex flex-col gap-2.5 text-xs font-semibold">
                        <a href="{{ request()->fullUrlWithQuery(['skill' => null]) }}" class="flex items-center gap-2 {{ !request('skill') ? 'text-[#2563ea] font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ !request('skill') ? 'bg-[#2563ea]' : 'bg-slate-300' }}"></span>
                            <span>الكل</span>
                        </a>
                        @foreach($skills as $skill)
                            <a href="{{ request()->fullUrlWithQuery(['skill' => $skill->slug]) }}" class="flex items-center gap-2 {{ request('skill') === $skill->slug ? 'text-[#2563ea] font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ request('skill') === $skill->slug ? 'bg-[#2563ea]' : 'bg-slate-300' }}"></span>
                                <span>{{ $skill->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- 5. Product Type Filter -->
                <div>
                    <h4 class="text-xs font-bold text-slate-700 mb-3">طبيعة المنتج</h4>
                    <div class="flex flex-col gap-2.5 text-xs font-semibold">
                        <a href="{{ request()->fullUrlWithQuery(['type' => null]) }}" class="flex items-center gap-2 {{ !request('type') ? 'text-[#2563ea] font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ !request('type') ? 'bg-[#2563ea]' : 'bg-slate-300' }}"></span>
                            <span>الكل</span>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['type' => 'physical']) }}" class="flex items-center gap-2 {{ request('type') === 'physical' ? 'text-[#2563ea] font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request('type') === 'physical' ? 'bg-[#2563ea]' : 'bg-slate-300' }}"></span>
                            <span>أدوات مادية وملموسة</span>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['type' => 'digital']) }}" class="flex items-center gap-2 {{ request('type') === 'digital' ? 'text-[#2563ea] font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request('type') === 'digital' ? 'bg-[#2563ea]' : 'bg-slate-300' }}"></span>
                            <span>شيتات رقمية قابلة للطباعة</span>
                        </a>
                    </div>
                </div>

            </aside>

            <!-- Catalog Grid (2 columns on mobile, 3 on desktop) -->
            <div class="lg:col-span-9 flex flex-col justify-between">
                
                @if($products->isEmpty())
                    <!-- Empty State -->
                    <div class="bg-slate-50 rounded-3xl border border-slate-200 py-16 px-6 text-center flex flex-col items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-700">لم نعثر على أي منتجات مطابقة للتصفية</h3>
                        <p class="text-xs text-slate-400 max-w-sm">جرب إزالة بعض الفلاتر المحددة أو ابحث بكلمات مختلفة مثل: "لغة"، "تأسيس"، "تخاطب".</p>
                        <a href="{{ route('search') }}" class="bg-[#2563ea] hover:bg-blue-700 text-white font-bold text-xs py-2 px-6 rounded-full mt-4 transition-all">تصفح كل المنتجات</a>
                    </div>
                @else
                    <!-- Products Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-5">
                        @foreach($products as $product)
                            @include('storefront.partials.product-card', ['product' => $product])
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-10 flex justify-center">
                        {{ $products->links() }}
                    </div>
                @endif

            </div>

        </div>

    </div>

    <!-- Mobile Filter Bottom Sheet Modal -->
    <div x-show="mobileFilterOpen" 
         x-cloak
         class="fixed inset-0 z-50 lg:hidden overflow-hidden" 
         role="dialog" 
         aria-modal="true">
        
        <!-- Backdrop -->
        <div x-show="mobileFilterOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileFilterOpen = false"
             class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs transition-opacity"></div>

        <!-- Slide-Up Drawer -->
        <div class="fixed inset-x-0 bottom-0 max-h-[85vh] bg-white rounded-t-3xl shadow-2xl flex flex-col overflow-hidden"
             x-show="mobileFilterOpen"
             x-transition:enter="transform transition ease-in-out duration-300"
             x-transition:enter-start="translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transform transition ease-in-out duration-200"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="translate-y-full">
            
            <!-- Header -->
            <div class="p-4 px-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-[#2563ea] rounded-full"></span>
                    <h3 class="text-sm font-black text-slate-800">تصفية وفلترة المنتجات</h3>
                </div>
                <button @click="mobileFilterOpen = false" class="w-8 h-8 rounded-full bg-slate-200/80 text-slate-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Scrollable Content -->
            <div class="p-6 overflow-y-auto space-y-6 text-right">
                
                <!-- 1. Categories -->
                <div>
                    <h4 class="text-xs font-black text-slate-700 mb-2.5">القسم</h4>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold {{ !request('category') ? 'bg-[#2563ea] text-white' : 'bg-slate-100 text-slate-700' }}">
                            الكل
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ request()->fullUrlWithQuery(['category' => $cat->slug]) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold {{ request('category') === $cat->slug ? 'bg-[#2563ea] text-white' : 'bg-slate-100 text-slate-700' }}">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- 2. Age Groups -->
                <div>
                    <h4 class="text-xs font-black text-slate-700 mb-2.5">عمر الطفل</h4>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ request()->fullUrlWithQuery(['age' => null]) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold {{ !request('age') ? 'bg-[#2563ea] text-white' : 'bg-slate-100 text-slate-700' }}">
                            الكل
                        </a>
                        @foreach($ageGroups as $age)
                            <a href="{{ request()->fullUrlWithQuery(['age' => $age->slug]) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold {{ request('age') === $age->slug ? 'bg-[#2563ea] text-white' : 'bg-slate-100 text-slate-700' }}">
                                {{ $age->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- 3. Needs -->
                <div>
                    <h4 class="text-xs font-black text-slate-700 mb-2.5">الاحتياج والتحدي</h4>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ request()->fullUrlWithQuery(['need' => null]) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold {{ !request('need') ? 'bg-[#2563ea] text-white' : 'bg-slate-100 text-slate-700' }}">
                            الكل
                        </a>
                        @foreach($needs as $need)
                            <a href="{{ request()->fullUrlWithQuery(['need' => $need->slug]) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold {{ request('need') === $need->slug ? 'bg-[#2563ea] text-white' : 'bg-slate-100 text-slate-700' }}">
                                {{ $need->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- 4. Skills -->
                <div>
                    <h4 class="text-xs font-black text-slate-700 mb-2.5">المهارة</h4>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ request()->fullUrlWithQuery(['skill' => null]) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold {{ !request('skill') ? 'bg-[#2563ea] text-white' : 'bg-slate-100 text-slate-700' }}">
                            الكل
                        </a>
                        @foreach($skills as $skill)
                            <a href="{{ request()->fullUrlWithQuery(['skill' => $skill->slug]) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold {{ request('skill') === $skill->slug ? 'bg-[#2563ea] text-white' : 'bg-slate-100 text-slate-700' }}">
                                {{ $skill->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Footer Action -->
            <div class="p-4 border-t border-slate-100 bg-slate-50 flex items-center gap-3">
                <button @click="mobileFilterOpen = false" class="flex-1 py-3 bg-[#2563ea] text-white text-xs font-black rounded-xl text-center shadow-xs">
                    عرض النتائج ({{ $products->total() }} منتج)
                </button>
                @if(request()->anyFilled(['q', 'category', 'age', 'need', 'skill', 'type']))
                    <a href="{{ route('search') }}" class="py-3 px-4 bg-slate-200 text-slate-700 text-xs font-bold rounded-xl text-center">
                        إعادة ضبط
                    </a>
                @endif
            </div>

        </div>

    </div>

</div>
@endsection
