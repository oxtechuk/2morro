@extends('layouts.storefront')

@section('title', '2morro | أدوات وشيتات تعليمية تنمي مهارات طفلك')

@section('content')
<div class="bg-white">

    <!-- 1. Full-Width Hero Slider (سليدر عريض ومرتفع 100% Edge-to-Edge مع أزرار تنقل واضحة) -->
    <div class="w-full relative overflow-hidden bg-slate-900 mb-8 select-none"
         x-data="{ 
            currentSlide: 0, 
            totalSlides: {{ $banners->count() > 0 ? $banners->count() : 1 }},
            next() {
                this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
            },
            prev() {
                this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
            },
            autoSlide() {
                setInterval(() => {
                    this.next();
                }, 6000);
            }
         }"
         x-init="autoSlide()">
        
        <div class="relative w-full overflow-hidden bg-slate-900 group" style="min-height: 560px;">
            
            @forelse($banners as $index => $banner)
                <div x-show="currentSlide === {{ $index }}"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="w-full flex items-center bg-cover bg-center {{ $index === 0 ? '' : 'hidden' }}"
                     style="min-height: 560px; background-image: url('{{ asset($banner->image) }}?v={{ file_exists(public_path($banner->image)) ? filemtime(public_path($banner->image)) : time() }}'); background-size: cover; background-position: center;">

                    <!-- Slide Content (Centered within max-w-7xl container with high-contrast text) -->
                    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 py-16 sm:py-24 {{ $banner->text_position === 'center' ? 'text-center mx-auto' : ($banner->text_position === 'left' ? 'text-left' : 'text-right') }}">
                        
                        <div class="max-w-2xl {{ $banner->text_position === 'center' ? 'mx-auto' : '' }}">
                            <!-- Badge -->
                            @if($banner->badge_text)
                                <div class="inline-flex items-center gap-1.5 bg-[#EF4444] text-white text-xs font-black px-4 py-1.5 rounded-full shadow-lg mb-5">
                                    <span>{{ $banner->badge_text }}</span>
                                </div>
                            @endif

                            <!-- Title with Crisp Text Shadow for Maximum Readability -->
                            @if($banner->title)
                                <h1 class="text-3xl sm:text-5xl lg:text-[56px] font-black text-white leading-[1.2] drop-shadow-xl" style="text-shadow: 0 3px 15px rgba(0,0,0,0.85);">
                                    {{ $banner->title }}
                                </h1>
                            @endif

                            <!-- Subtitle -->
                            @if($banner->subtitle)
                                <p class="text-slate-100 font-bold text-sm sm:text-lg mt-4 leading-relaxed drop-shadow-lg max-w-xl {{ $banner->text_position === 'center' ? 'mx-auto' : '' }}" style="text-shadow: 0 2px 10px rgba(0,0,0,0.8);">
                                    {{ $banner->subtitle }}
                                </p>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex flex-wrap items-center gap-4 mt-8 {{ $banner->text_position === 'center' ? 'justify-center' : '' }}">
                                @if($banner->button_text)
                                    <a href="{{ $banner->button_link ?: route('search') }}" class="bg-[#2563EB] hover:bg-blue-600 text-white text-xs sm:text-sm font-black py-4 px-9 rounded-full flex items-center justify-center gap-2 transition-all shadow-2xl hover:shadow-blue-500/40 hover:scale-105">
                                        <svg class="w-4 h-4 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        {{ $banner->button_text }}
                                    </a>
                                @endif

                                @if($banner->secondary_button_text)
                                    <a href="{{ $banner->secondary_button_link ?: route('search') }}" class="bg-black/40 hover:bg-black/60 backdrop-blur-md text-white border border-white/40 text-xs sm:text-sm font-black py-4 px-7 rounded-full flex items-center justify-center gap-1.5 transition-all shadow-xl hover:scale-105">
                                        {{ $banner->secondary_button_text }}
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>
            @empty
                @php
                    $fallbackImage = \App\Models\Setting::get('hero_image', 'images/hero-child.jpg');
                    $fallbackVersion = file_exists(public_path($fallbackImage)) ? filemtime(public_path($fallbackImage)) : time();
                @endphp
                <!-- Fallback Default Slide if no banners are added -->
                <div class="w-full flex items-center bg-cover bg-center" style="min-height: 560px; background-image: url('{{ asset($fallbackImage) }}?v={{ $fallbackVersion }}'); background-size: cover; background-position: center;">
                    <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 py-16 text-right w-full">
                        <span class="bg-[#EF4444] text-white text-xs font-black px-4 py-1.5 rounded-full shadow-md">🚀 تمورو التعليمي</span>
                        <h1 class="text-3xl sm:text-5xl font-black text-white mt-4 leading-tight drop-shadow-xl" style="text-shadow: 0 3px 15px rgba(0,0,0,0.85);">{{ \App\Models\Setting::get('hero_title', 'أدوات تعليمية تنمي مهارات طفلك') }}</h1>
                        <p class="text-slate-100 font-bold text-sm sm:text-base mt-3 drop-shadow-lg max-w-xl" style="text-shadow: 0 2px 10px rgba(0,0,0,0.8);">{{ \App\Models\Setting::get('hero_subtitle', 'تعلَم.. استمتع.. وتطور كل يوم مع أفضل الوسائل والألعاب التعليمية.') }}</p>
                        <a href="{{ \App\Models\Setting::get('hero_btn1_link', '/search') }}" class="bg-[#2563EB] text-white text-sm font-black py-4 px-8 rounded-full inline-block mt-6 shadow-xl">{{ \App\Models\Setting::get('hero_btn1_text', 'تسوق الآن') }}</a>
                    </div>
                </div>
            @endforelse

            <!-- Navigation Controls (Bottom Corner Pill Navigation like Reference Image) -->
            @if($banners->count() > 1)
                <!-- Prev / Next Navigation Arrows (Bottom Left Corner) -->
                <div class="absolute bottom-8 left-8 sm:left-14 z-30 flex items-center gap-3 bg-black/60 backdrop-blur-md p-2 rounded-full border border-white/20 shadow-2xl">
                    <!-- Button to move forward (Next in RTL points left ←) -->
                    <button @click="next()" title="التالي" class="w-11 h-11 rounded-full bg-white/10 hover:bg-[#EF4444] text-white flex items-center justify-center transition-all duration-300 shadow-md hover:scale-105 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <!-- Button to move backward (Prev in RTL points right →) -->
                    <button @click="prev()" title="السابق" class="w-11 h-11 rounded-full bg-white/10 hover:bg-[#EF4444] text-white flex items-center justify-center transition-all duration-300 shadow-md hover:scale-105 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>

                <!-- Indicator Dots (Bottom Center) -->
                <div class="absolute bottom-8 inset-x-0 z-30 flex items-center justify-center gap-2 pointer-events-none">
                    @foreach($banners as $index => $banner)
                        <button @click="currentSlide = {{ $index }}" 
                                :class="currentSlide === {{ $index }} ? 'w-10 bg-[#EF4444]' : 'w-3 bg-white/50 hover:bg-white'" 
                                class="h-2.5 rounded-full transition-all pointer-events-auto shadow-lg"></button>
                    @endforeach
                </div>
            @endif

        </div>
    </div>

    <!-- 2. Needs and Skills Quick Carousel (8 Pastel Cards) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <div class="relative flex items-center">
            
            <button class="hidden md:flex w-7 h-7 rounded-full bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-600 items-center justify-center absolute -right-3.5 z-20 shadow-xs transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <div class="w-full grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-2.5 overflow-x-auto no-scrollbar py-1">
                
                <!-- 1. أدوات تعليمية -->
                <a href="{{ route('search', ['category' => 'educational-tools']) }}" class="bg-[#FFF1F2] border border-red-100 hover:border-red-300 p-3 rounded-2xl flex flex-col items-center justify-center text-center group transition-all duration-300 hover:-translate-y-0.5 shadow-xs">
                    <div class="w-9 h-9 rounded-full bg-red-100/80 text-red-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                    </div>
                    <span class="text-[11px] font-bold text-slate-700 mt-2 whitespace-nowrap">أدوات تعليمية</span>
                </a>

                <!-- 2. مهارات ما قبل المدرسة -->
                <a href="{{ route('search') }}" class="bg-[#FFFBEB] border border-amber-100 hover:border-amber-300 p-3 rounded-2xl flex flex-col items-center justify-center text-center group transition-all duration-300 hover:-translate-y-0.5 shadow-xs">
                    <div class="w-9 h-9 rounded-full bg-amber-100/80 text-amber-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    </div>
                    <span class="text-[11px] font-bold text-slate-700 mt-2 whitespace-nowrap">مهارات ما قبل المدرسة</span>
                </a>

                <!-- 3. تنمية اللغة -->
                <a href="{{ route('search', ['skill' => 'language-development']) }}" class="bg-[#F0FDF4] border border-green-100 hover:border-green-300 p-3 rounded-2xl flex flex-col items-center justify-center text-center group transition-all duration-300 hover:-translate-y-0.5 shadow-xs">
                    <div class="w-9 h-9 rounded-full bg-green-100/80 text-green-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <span class="text-[11px] font-bold text-slate-700 mt-2 whitespace-nowrap">تنمية اللغة</span>
                </a>

                <!-- 4. صعوبات التعلم -->
                <a href="{{ route('search', ['skill' => 'learning-difficulties']) }}" class="bg-[#EFF6FF] border border-blue-100 hover:border-blue-300 p-3 rounded-2xl flex flex-col items-center justify-center text-center group transition-all duration-300 hover:-translate-y-0.5 shadow-xs">
                    <div class="w-9 h-9 rounded-full bg-blue-100/80 text-blue-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <span class="text-[11px] font-bold text-slate-700 mt-2 whitespace-nowrap">صعوبات التعلم</span>
                </a>

                <!-- 5. فرط الحركة -->
                <a href="{{ route('search', ['need' => 'adhd']) }}" class="bg-[#FFF7ED] border border-orange-100 hover:border-orange-300 p-3 rounded-2xl flex flex-col items-center justify-center text-center group transition-all duration-300 hover:-translate-y-0.5 shadow-xs">
                    <div class="w-9 h-9 rounded-full bg-orange-100/80 text-orange-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="text-[11px] font-bold text-slate-700 mt-2 whitespace-nowrap">فرط الحركة</span>
                </a>

                <!-- 6. ضعف الانتباه -->
                <a href="{{ route('search', ['skill' => 'attention-focus']) }}" class="bg-[#FAF5FF] border border-purple-100 hover:border-purple-300 p-3 rounded-2xl flex flex-col items-center justify-center text-center group transition-all duration-300 hover:-translate-y-0.5 shadow-xs">
                    <div class="w-9 h-9 rounded-full bg-purple-100/80 text-purple-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </div>
                    <span class="text-[11px] font-bold text-slate-700 mt-2 whitespace-nowrap">ضعف الانتباه</span>
                </a>

                <!-- 7. التوحد -->
                <a href="{{ route('search', ['need' => 'autism']) }}" class="bg-[#F0FDFA] border border-teal-100 hover:border-teal-300 p-3 rounded-2xl flex flex-col items-center justify-center text-center group transition-all duration-300 hover:-translate-y-0.5 shadow-xs">
                    <div class="w-9 h-9 rounded-full bg-teal-100/80 text-teal-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path></svg>
                    </div>
                    <span class="text-[11px] font-bold text-slate-700 mt-2 whitespace-nowrap">التوحد</span>
                </a>

                <!-- 8. تأخر الكلام -->
                <a href="{{ route('search', ['need' => 'speech-delay']) }}" class="bg-[#FDF2F8] border border-pink-100 hover:border-pink-300 p-3 rounded-2xl flex flex-col items-center justify-center text-center group transition-all duration-300 hover:-translate-y-0.5 shadow-xs">
                    <div class="w-9 h-9 rounded-full bg-pink-100/80 text-pink-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="text-[11px] font-bold text-slate-700 mt-2 whitespace-nowrap">تأخر الكلام</span>
                </a>

            </div>

            <button class="hidden md:flex w-7 h-7 rounded-full bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-600 items-center justify-center absolute -left-3.5 z-20 shadow-xs transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>

        </div>
    </div>

    <!-- 3. Promotions & Product Carousels Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch">
            
            <!-- Right (in RTL): الأكثر مبيعاً (4 cols) -->
            <div class="lg:col-span-4 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-black text-slate-800 flex items-center gap-1.5">
                        الأكثر مبيعاً
                    </h2>
                    <a href="{{ route('search') }}" class="text-[11px] font-bold text-slate-500 hover:text-blue-600 flex items-center gap-1 transition-colors">
                        عرض الكل
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-3.5">
                    @foreach($bestSellers->take(4) as $product)
                        @include('storefront.partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>

            <!-- Middle: الجديد لدينا (5 cols) -->
            <div class="lg:col-span-5 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-black text-slate-800 flex items-center gap-1.5">
                        الجديد لدينا
                    </h2>
                    <a href="{{ route('search') }}" class="text-[11px] font-bold text-slate-500 hover:text-blue-600 flex items-center gap-1 transition-colors">
                        عرض الكل
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-3.5">
                    @foreach($newArrivals->take(4) as $product)
                        @include('storefront.partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>

            <!-- Left (in RTL): عروض الأسبوع (3 cols) -->
            <div class="lg:col-span-3 bg-gradient-to-b from-[#2563EB] to-[#1D4ED8] rounded-3xl p-5 text-white flex flex-col justify-between text-center relative overflow-hidden shadow-soft min-h-[380px]">
                
                <div class="absolute -top-8 -right-8 w-28 h-28 rounded-full bg-white/10 blur-sm"></div>
                <div class="absolute -bottom-8 -left-8 w-28 h-28 rounded-full bg-red-400/20 blur-sm"></div>

                <div class="relative z-10">
                    <h3 class="text-lg font-black text-white">عروض الأسبوع</h3>
                    <p class="text-xs text-blue-100 font-bold mt-1">خصومات تصل إلي</p>
                    <span class="inline-block text-4xl font-black text-white mt-1 tracking-tight">30%</span>
                </div>

                <div class="my-3 flex items-center justify-center relative z-10">
                    <img src="{{ asset('images/promo-gift.jpg') }}" alt="عروض الأسبوع" class="w-28 h-28 object-contain rounded-2xl drop-shadow-md">
                </div>

                <div class="relative z-10">
                    <a href="{{ route('search', ['category' => 'educational-bundles']) }}" class="w-full bg-white hover:bg-blue-50 text-[#102A63] font-bold text-xs py-2.5 px-6 rounded-full inline-flex items-center justify-center transition-colors shadow-sm">
                        تسوق الآن
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- 4. NEW: All Products Grid (شبكة كل المنتجات 4 في 3 بتصنيفات سريعة) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 border-t border-slate-100"
         x-data="{ 
            activeTab: 'all',
            filterProduct(type, cats, needs, skills) {
                if (this.activeTab === 'all') return true;
                if (this.activeTab === 'tools' && type === 'physical') return true;
                if (this.activeTab === 'digital' && type === 'digital') return true;
                if (this.activeTab === 'bundles' && (type === 'bundle' || cats.includes('educational-bundles'))) return true;
                if (this.activeTab === 'speech' && (needs.includes('speech-delay') || skills.includes('language-development'))) return true;
                if (this.activeTab === 'focus' && skills.includes('attention-focus')) return true;
                if (this.activeTab === 'learning' && skills.includes('learning-difficulties')) return true;
                if (this.activeTab === 'adhd' && needs.includes('adhd')) return true;
                return false;
            }
         }">
        
        <!-- Header & Filter Tabs -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-6 bg-[#2563EB] rounded-full"></span>
                    <h2 class="text-xl font-black text-[#102A63]">جميع المنتجات والأدوات التعليمية</h2>
                </div>
                <p class="text-xs text-slate-500 font-semibold mt-1">تصفح حلولنا التعليمية المتنوعة لتطوير مهارات طفلك حسب احتياجه</p>
            </div>

            <!-- Filter Tabs Pills -->
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1">
                <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-[#102A63] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-4 py-2 rounded-full text-xs font-bold transition-all whitespace-nowrap">
                    الكل
                </button>
                <button @click="activeTab = 'tools'" :class="activeTab === 'tools' ? 'bg-[#102A63] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-4 py-2 rounded-full text-xs font-bold transition-all whitespace-nowrap">
                    الأدوات التعليمية
                </button>
                <button @click="activeTab = 'digital'" :class="activeTab === 'digital' ? 'bg-[#102A63] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-4 py-2 rounded-full text-xs font-bold transition-all whitespace-nowrap">
                    شيتات رقمية PDF
                </button>
                <button @click="activeTab = 'bundles'" :class="activeTab === 'bundles' ? 'bg-[#102A63] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-4 py-2 rounded-full text-xs font-bold transition-all whitespace-nowrap">
                    باقات التوفير
                </button>
                <button @click="activeTab = 'speech'" :class="activeTab === 'speech' ? 'bg-[#102A63] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-4 py-2 rounded-full text-xs font-bold transition-all whitespace-nowrap">
                    تأخر النطق والتخاطب
                </button>
                <button @click="activeTab = 'focus'" :class="activeTab === 'focus' ? 'bg-[#102A63] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-4 py-2 rounded-full text-xs font-bold transition-all whitespace-nowrap">
                    التركيز والانتباه
                </button>
                <button @click="activeTab = 'learning'" :class="activeTab === 'learning' ? 'bg-[#102A63] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-4 py-2 rounded-full text-xs font-bold transition-all whitespace-nowrap">
                    صعوبات التعلم
                </button>
            </div>
        </div>

        <!-- 4x3 Grid (12 Products) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @foreach($allProducts->take(12) as $product)
                @php
                    $catSlugs = $product->categories->pluck('slug')->toArray();
                    $needSlugs = $product->needs->pluck('slug')->toArray();
                    $skillSlugs = $product->skills->pluck('slug')->toArray();
                @endphp
                <div x-show="filterProduct('{{ $product->type }}', {{ json_encode($catSlugs) }}, {{ json_encode($needSlugs) }}, {{ json_encode($skillSlugs) }})"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100">
                    @include('storefront.partials.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>

        <!-- Load More / Full Store Link -->
        <div class="flex items-center justify-center mt-10">
            <a href="{{ route('search') }}" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 border-2 border-slate-200 hover:border-blue-600 text-slate-700 hover:text-blue-600 font-extrabold text-xs sm:text-sm py-3 px-10 rounded-full transition-all shadow-xs group">
                <span>تصفح جميع المنتجات في المتجر ({{ \App\Models\Product::where('is_active', true)->count() }} منتج)</span>
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
        </div>

    </div>

    <!-- 5. Bottom 3-Feature Category Banners -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            
            <!-- Banner 1: باقات توفير -->
            <a href="{{ route('search', ['category' => 'educational-bundles']) }}" class="bg-[#FFF1F2] border border-red-100 hover:border-red-200 p-5 rounded-3xl flex items-center justify-between group transition-all duration-300 hover:shadow-soft relative overflow-hidden">
                <div class="flex flex-col text-right z-10">
                    <span class="text-sm font-black text-[#EF4444]">باقات توفير</span>
                    <h3 class="text-xs font-bold text-slate-700 mt-1 leading-snug">أدوات + شيتات + كورسات<br>بسعر أقل</h3>
                </div>
                <div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center overflow-hidden z-10 group-hover:scale-105 transition-transform">
                    <img src="{{ asset('images/promo-gift.jpg') }}" alt="باقات توفير" class="w-full h-full object-cover">
                </div>
            </a>

            <!-- Banner 2: شيتات جاهزة للطباعة -->
            <a href="{{ route('search', ['category' => 'digital-worksheets']) }}" class="bg-[#F0F9FF] border border-blue-100 hover:border-blue-200 p-5 rounded-3xl flex items-center justify-between group transition-all duration-300 hover:shadow-soft relative overflow-hidden">
                <div class="flex flex-col text-right z-10">
                    <span class="text-sm font-black text-[#2563EB]">شيتات جاهزة للطباعة</span>
                    <h3 class="text-xs font-bold text-slate-700 mt-1 leading-snug">تحميل فوري<br>مئات الشيتات التعليمية</h3>
                </div>
                <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center overflow-hidden z-10 group-hover:scale-105 transition-transform">
                    <img src="{{ asset('images/3d-printer.jpg') }}" alt="شيتات للطباعة" class="w-full h-full object-cover">
                </div>
            </a>

            <!-- Banner 3: برامج وكورسات -->
            <a href="{{ route('search', ['category' => 'courses']) }}" class="bg-[#F0FDFA] border border-teal-100 hover:border-teal-200 p-5 rounded-3xl flex items-center justify-between group transition-all duration-300 hover:shadow-soft relative overflow-hidden">
                <div class="flex flex-col text-right z-10">
                    <span class="text-sm font-black text-[#14B8A6]">برامج وكورسات</span>
                    <h3 class="text-xs font-bold text-slate-700 mt-1 leading-snug">تعلم بخطوات عملية<br>مع نخبة من المتخصصين</h3>
                </div>
                <div class="w-16 h-16 rounded-2xl bg-teal-100 flex items-center justify-center overflow-hidden z-10 group-hover:scale-105 transition-transform">
                    <img src="{{ asset('images/3d-laptop.jpg') }}" alt="برامج وكورسات" class="w-full h-full object-cover">
                </div>
            </a>

        </div>
    </div>

</div>
@endsection
