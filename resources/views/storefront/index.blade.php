@extends('layouts.storefront')

@section('title', '2morro | أدوات وشيتات تعليمية تنمي مهارات طفلك')

@section('content')
<div class="bg-white">

    <!-- 1. Touch-Swipe Responsive Hero Slider (سليدر متجاوب بمقاس 1670x941 بدون فلاتر وبأعلى دقة) -->
    <div class="w-full relative overflow-hidden bg-transparent mb-4 sm:mb-6 select-none"
         x-data="{ 
            currentSlide: 0, 
            totalSlides: {{ $banners->count() > 0 ? $banners->count() : 1 }},
            touchStartX: 0,
            touchEndX: 0,
            timer: null,
            next() {
                this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                this.resetTimer();
            },
            prev() {
                this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
                this.resetTimer();
            },
            handleTouchStart(e) {
                this.touchStartX = e.changedTouches[0].screenX;
            },
            handleTouchEnd(e) {
                this.touchEndX = e.changedTouches[0].screenX;
                if (this.touchStartX - this.touchEndX > 45) {
                    this.next();
                } else if (this.touchEndX - this.touchStartX > 45) {
                    this.prev();
                }
            },
            startTimer() {
                if (this.totalSlides > 1) {
                    this.timer = setInterval(() => {
                        this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                    }, 5500);
                }
            },
            resetTimer() {
                if (this.timer) {
                    clearInterval(this.timer);
                    this.startTimer();
                }
            }
         }"
         x-init="startTimer()"
         @touchstart.passive="handleTouchStart($event)"
         @touchend.passive="handleTouchEnd($event)">
        
        <div class="relative w-full max-w-7xl mx-auto overflow-hidden bg-slate-100 rounded-2xl sm:rounded-3xl shadow-sm min-h-[220px] sm:min-h-[360px] md:min-h-[460px] lg:min-h-[520px]"
             style="aspect-ratio: 1670 / 941; width: 100%;">
            
            @forelse($banners as $index => $banner)
                @php
                    $bannerImg = asset($banner->image) . '?v=' . (file_exists(public_path($banner->image)) ? filemtime(public_path($banner->image)) : time());
                    $bannerLink = $banner->button_link ?: ($banner->secondary_button_link ?: '#');
                    $hasText = !empty($banner->title) || !empty($banner->subtitle) || !empty($banner->badge_text);
                @endphp
                <div x-show="currentSlide === {{ $index }}"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 scale-[1.01]"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-300 absolute inset-0"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="w-full h-full absolute inset-0 flex items-center justify-center overflow-hidden"
                     style="{{ $index === 0 ? '' : 'display: none;' }}">

                    <!-- Direct Banner Image with exact 1670x941 fit -->
                    <img src="{{ $bannerImg }}" 
                         alt="{{ $banner->title ?: 'بنر العرض' }}" 
                         class="w-full h-full object-cover object-center select-none pointer-events-none"
                         loading="{{ $index === 0 ? 'eager' : 'lazy' }}">

                    <!-- Clickable Whole Banner Link (If link is set without text buttons) -->
                    @if(!empty($banner->button_link) && empty($banner->button_text))
                        <a href="{{ $banner->button_link }}" class="absolute inset-0 z-10 block" aria-label="{{ $banner->title ?: 'عرض البانر' }}"></a>
                    @endif

                    <!-- Slide Text & Button Overlay (Rendered only when text exists) -->
                    @if($hasText || !empty($banner->button_text) || !empty($banner->secondary_button_text))
                        <div class="absolute inset-0 z-20 flex items-center px-6 sm:px-12 lg:px-16 pointer-events-none {{ $banner->text_position === 'center' ? 'justify-center text-center' : ($banner->text_position === 'left' ? 'justify-start text-left' : 'justify-end text-right') }}">
                            <div class="max-w-xl pointer-events-auto">
                                <!-- Badge -->
                                @if($banner->badge_text)
                                    <div class="inline-flex items-center gap-1.5 bg-[#EF4444] text-white text-[11px] sm:text-xs font-black px-3 sm:px-4 py-1 rounded-full shadow-md mb-2 sm:mb-3">
                                        <span>{{ $banner->badge_text }}</span>
                                    </div>
                                @endif

                                <!-- Title -->
                                @if($banner->title)
                                    <h1 class="text-xl sm:text-3xl lg:text-[40px] font-black text-slate-900 leading-tight drop-shadow-xs">
                                        {{ $banner->title }}
                                    </h1>
                                @endif

                                <!-- Subtitle -->
                                @if($banner->subtitle)
                                    <p class="text-slate-800 font-bold text-xs sm:text-base mt-2 sm:mt-3 leading-relaxed max-w-lg">
                                        {{ $banner->subtitle }}
                                    </p>
                                @endif

                                <!-- Action Buttons -->
                                @if(!empty($banner->button_text) || !empty($banner->secondary_button_text))
                                    <div class="flex flex-wrap items-center gap-3 mt-4 sm:mt-6 {{ $banner->text_position === 'center' ? 'justify-center' : '' }}">
                                        @if($banner->button_text)
                                            <a href="{{ $banner->button_link ?: route('search') }}" class="bg-[#2563ea] hover:bg-blue-700 text-white text-xs sm:text-sm font-black py-2.5 sm:py-3 px-6 sm:px-8 rounded-full flex items-center justify-center gap-2 transition-all shadow-md hover:scale-105 active:scale-95">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                                <span>{{ $banner->button_text }}</span>
                                            </a>
                                        @endif

                                        @if($banner->secondary_button_text)
                                            <a href="{{ $banner->secondary_button_link ?: route('search') }}" class="bg-white/95 hover:bg-white text-slate-800 border border-slate-200 text-xs sm:text-sm font-black py-2.5 sm:py-3 px-5 sm:px-6 rounded-full flex items-center justify-center gap-1.5 transition-all shadow-sm hover:scale-105 active:scale-95">
                                                <span>{{ $banner->secondary_button_text }}</span>
                                                <svg class="w-3.5 h-3.5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>
            @empty
                @php
                    $fallbackImage = \App\Models\Setting::get('hero_image', 'images/hero-child.jpg');
                    $fallbackVersion = file_exists(public_path($fallbackImage)) ? filemtime(public_path($fallbackImage)) : time();
                @endphp
                <div class="w-full h-full relative flex items-center justify-center">
                    <img src="{{ asset($fallbackImage) }}?v={{ $fallbackVersion }}" alt="بانر رئيسي" class="w-full h-full object-cover object-center">
                    <div class="absolute inset-0 z-10 flex items-center px-6 sm:px-12 text-right">
                        <div class="max-w-xl">
                            <span class="bg-[#EF4444] text-white text-xs font-black px-3.5 py-1 rounded-full shadow-md">مركز تمورو التعليمي</span>
                            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-slate-900 mt-3 leading-tight">{{ \App\Models\Setting::get('hero_title', 'أدوات تعليمية تنمي مهارات طفلك') }}</h1>
                            <p class="text-slate-700 font-bold text-xs sm:text-base mt-2.5 max-w-xl">{{ \App\Models\Setting::get('hero_subtitle', 'تعلَم.. استمتع.. وتطور كل يوم مع أفضل الوسائل والألعاب التعليمية.') }}</p>
                            <a href="{{ \App\Models\Setting::get('hero_btn1_link', '/search') }}" class="bg-[#2563ea] text-white text-xs sm:text-sm font-black py-3 px-7 rounded-full inline-block mt-5 shadow-md">{{ \App\Models\Setting::get('hero_btn1_text', 'تسوق الآن') }}</a>
                        </div>
                    </div>
                </div>
            @endforelse

            <!-- Navigation Controls (Arrows & Dots) -->
            @if($banners->count() > 1)
                <!-- Prev / Next Floating Arrows -->
                <div class="absolute bottom-4 left-4 sm:left-8 z-30 flex items-center gap-1.5 bg-black/40 backdrop-blur-md p-1 rounded-full border border-white/20 shadow-lg">
                    <button @click="next()" title="التالي" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white/20 hover:bg-[#2563ea] text-white flex items-center justify-center transition-all shadow-xs active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button @click="prev()" title="السابق" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white/20 hover:bg-[#2563ea] text-white flex items-center justify-center transition-all shadow-xs active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>

                <!-- Indicator Dots -->
                <div class="absolute bottom-4 inset-x-0 z-30 flex items-center justify-center gap-1.5 pointer-events-none">
                    @foreach($banners as $index => $banner)
                        <button @click="currentSlide = {{ $index }}; resetTimer();" 
                                :class="currentSlide === {{ $index }} ? 'w-6 sm:w-8 bg-[#2563ea]' : 'w-2 sm:w-2.5 bg-white/60 hover:bg-white'" 
                                class="h-2 rounded-full transition-all pointer-events-auto shadow-sm"></button>
                    @endforeach
                </div>
            @endif

        </div>
    </div>

    <!-- 2. Needs and Skills Quick Carousel (Smooth Touch Scrolling Chip Bar) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-2 scroll-smooth">
            
            <!-- 1. أدوات تعليمية -->
            <a href="{{ route('search', ['category' => 'educational-tools']) }}" class="flex-shrink-0 bg-[#FFF1F2] border border-red-100 hover:border-red-300 p-2.5 px-3.5 rounded-2xl flex items-center gap-2 group transition-all duration-200 hover:-translate-y-0.5 shadow-2xs">
                <div class="w-7 h-7 rounded-xl bg-red-100 text-red-500 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-700 whitespace-nowrap">أدوات تعليمية</span>
            </a>

            <!-- 2. مهارات ما قبل المدرسة -->
            <a href="{{ route('search') }}" class="flex-shrink-0 bg-[#FFFBEB] border border-amber-100 hover:border-amber-300 p-2.5 px-3.5 rounded-2xl flex items-center gap-2 group transition-all duration-200 hover:-translate-y-0.5 shadow-2xs">
                <div class="w-7 h-7 rounded-xl bg-amber-100 text-amber-500 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-700 whitespace-nowrap">ما قبل المدرسة</span>
            </a>

            <!-- 3. تنمية اللغة -->
            <a href="{{ route('search', ['skill' => 'language-development']) }}" class="flex-shrink-0 bg-[#F0FDF4] border border-green-100 hover:border-green-300 p-2.5 px-3.5 rounded-2xl flex items-center gap-2 group transition-all duration-200 hover:-translate-y-0.5 shadow-2xs">
                <div class="w-7 h-7 rounded-xl bg-green-100 text-green-500 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-700 whitespace-nowrap">تنمية اللغة والنطق</span>
            </a>

            <!-- 4. صعوبات التعلم -->
            <a href="{{ route('search', ['skill' => 'learning-difficulties']) }}" class="flex-shrink-0 bg-[#EFF6FF] border border-blue-100 hover:border-blue-300 p-2.5 px-3.5 rounded-2xl flex items-center gap-2 group transition-all duration-200 hover:-translate-y-0.5 shadow-2xs">
                <div class="w-7 h-7 rounded-xl bg-blue-100 text-blue-500 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-700 whitespace-nowrap">صعوبات التعلم</span>
            </a>

            <!-- 5. فرط الحركة -->
            <a href="{{ route('search', ['need' => 'adhd']) }}" class="flex-shrink-0 bg-[#FFF7ED] border border-orange-100 hover:border-orange-300 p-2.5 px-3.5 rounded-2xl flex items-center gap-2 group transition-all duration-200 hover:-translate-y-0.5 shadow-2xs">
                <div class="w-7 h-7 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-700 whitespace-nowrap">تعديل السلوك وADHD</span>
            </a>

            <!-- 6. ضعف الانتباه -->
            <a href="{{ route('search', ['skill' => 'attention-focus']) }}" class="flex-shrink-0 bg-[#FAF5FF] border border-purple-100 hover:border-purple-300 p-2.5 px-3.5 rounded-2xl flex items-center gap-2 group transition-all duration-200 hover:-translate-y-0.5 shadow-2xs">
                <div class="w-7 h-7 rounded-xl bg-purple-100 text-purple-500 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-700 whitespace-nowrap">التركيز والانتباه</span>
            </a>

            <!-- 7. التوحد -->
            <a href="{{ route('search', ['need' => 'autism']) }}" class="flex-shrink-0 bg-[#F0FDFA] border border-teal-100 hover:border-teal-300 p-2.5 px-3.5 rounded-2xl flex items-center gap-2 group transition-all duration-200 hover:-translate-y-0.5 shadow-2xs">
                <div class="w-7 h-7 rounded-xl bg-teal-100 text-teal-500 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-700 whitespace-nowrap">طيف التوحد</span>
            </a>

            <!-- 8. حجز موعد تقييم -->
            <a href="{{ route('booking.index') }}" class="flex-shrink-0 bg-amber-50 border border-amber-200 hover:border-amber-400 p-2.5 px-3.5 rounded-2xl flex items-center gap-2 group transition-all duration-200 hover:-translate-y-0.5 shadow-2xs">
                <div class="w-7 h-7 rounded-xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <span class="text-xs font-black text-amber-800 whitespace-nowrap">حجز استشارة وتقييم</span>
            </a>

        </div>
    </div>

    <!-- 3. Promotions & Featured Product Groups Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6 items-stretch">
            
            <!-- Side Promo Banner Card (3 cols on desktop) -->
            <div class="lg:col-span-3 rounded-3xl p-5 sm:p-6 text-white flex flex-col justify-between text-center relative overflow-hidden shadow-md group transition-all duration-300 hover:shadow-xl min-h-[340px] lg:min-h-[420px]
                @if(($promoSettings['deals_gradient'] ?? 'blue') === 'purple')
                    bg-gradient-to-b from-[#4F46E5] to-[#312E81]
                @elseif(($promoSettings['deals_gradient'] ?? 'blue') === 'coral')
                    bg-gradient-to-b from-[#EA580C] to-[#9A3412]
                @elseif(($promoSettings['deals_gradient'] ?? 'blue') === 'emerald')
                    bg-gradient-to-b from-[#059669] to-[#064E3B]
                @elseif(($promoSettings['deals_gradient'] ?? 'blue') === 'dark')
                    bg-gradient-to-b from-[#1E293B] to-[#0F172A]
                @else
                    bg-gradient-to-b from-[#2563ea] to-[#1E3A8A]
                @endif
            ">
                <!-- Background Glow Circles -->
                <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full bg-white/10 blur-md pointer-events-none"></div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 rounded-full bg-cyan-400/20 blur-md pointer-events-none"></div>

                <!-- Banner Header -->
                <div class="relative z-10 space-y-1">
                    <span class="inline-block px-3 py-1 rounded-full bg-white/15 backdrop-blur-sm text-[11px] font-black text-white/90 border border-white/20 mb-1">
                        عروض وتخفيضات الأسبوع
                    </span>
                    <h3 class="text-xl sm:text-2xl font-black text-white leading-tight">
                        {{ $promoSettings['deals_title'] }}
                    </h3>
                    <p class="text-xs text-blue-100 font-bold">
                        {{ $promoSettings['deals_subtitle'] }}
                    </p>
                    <div class="pt-1">
                        <span class="inline-block text-4xl sm:text-5xl font-black text-white tracking-tight drop-shadow-sm">
                            {{ $promoSettings['deals_discount'] }}
                        </span>
                    </div>
                </div>

                <!-- Banner Image (Maximized full clean display) -->
                <div class="my-auto py-1 flex-1 flex items-center justify-center relative z-10 w-full">
                    @php
                        $promoImg = $promoSettings['deals_image'] ?: 'images/promo-gift.jpg';
                        $promoImgUrl = str_starts_with($promoImg, 'http') ? $promoImg : asset($promoImg);
                    @endphp
                    <div class="w-full h-72 sm:h-80 lg:h-96 flex items-center justify-center group-hover:scale-105 transition-transform duration-500">
                        <img src="{{ $promoImgUrl }}" 
                             alt="{{ $promoSettings['deals_title'] }}" 
                             onerror="this.onerror=null; this.src='{{ asset('images/promo-gift.jpg') }}';"
                             class="w-full h-full max-h-[300px] sm:max-h-[350px] lg:max-h-[400px] object-contain drop-shadow-2xl">
                    </div>
                </div>

                <!-- Action Button -->
                <div class="relative z-10 pt-1">
                    <a href="{{ $promoSettings['deals_btn_link'] }}" class="w-full bg-white hover:bg-slate-100 text-[#2563ea] font-black text-xs py-3 px-6 rounded-2xl inline-flex items-center justify-center gap-1.5 transition-all shadow-sm hover:scale-[1.02] active:scale-95">
                        <span>{{ $promoSettings['deals_btn_text'] }}</span>
                        <svg class="w-3.5 h-3.5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Products Area: 2 Balanced Groups (9 cols on desktop) -->
            <div class="lg:col-span-9 grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
                
                <!-- Group 1: الأكثر مبيعاً -->
                <div class="bg-slate-50/70 p-3.5 sm:p-5 rounded-3xl border border-slate-100 flex flex-col justify-between">
                    <!-- Group Header -->
                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-200/70">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-4 bg-[#EF4444] rounded-full"></span>
                            <h2 class="text-sm sm:text-base font-black text-slate-800">
                                {{ $promoSettings['group1_title'] }}
                            </h2>
                        </div>
                        <a href="{{ $promoSettings['group1_link'] }}" class="text-[11px] font-bold text-slate-500 hover:text-[#2563ea] flex items-center gap-1 transition-colors group">
                            <span>عرض الكل</span>
                            <svg class="w-3 h-3 rotate-180 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>

                    <!-- 2x2 Products Grid on Mobile & Desktop -->
                    <div class="grid grid-cols-2 gap-2.5 sm:gap-3.5">
                        @foreach($bestSellers->take(4) as $product)
                            @include('storefront.partials.product-card', ['product' => $product])
                        @endforeach
                    </div>
                </div>

                <!-- Group 2: الجديد لدينا -->
                <div class="bg-slate-50/70 p-3.5 sm:p-5 rounded-3xl border border-slate-100 flex flex-col justify-between">
                    <!-- Group Header -->
                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-200/70">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-4 bg-[#2563ea] rounded-full"></span>
                            <h2 class="text-sm sm:text-base font-black text-slate-800">
                                {{ $promoSettings['group2_title'] }}
                            </h2>
                        </div>
                        <a href="{{ $promoSettings['group2_link'] }}" class="text-[11px] font-bold text-slate-500 hover:text-[#2563ea] flex items-center gap-1 transition-colors group">
                            <span>عرض الكل</span>
                            <svg class="w-3 h-3 rotate-180 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>

                    <!-- 2x2 Products Grid on Mobile & Desktop -->
                    <div class="grid grid-cols-2 gap-2.5 sm:gap-3.5">
                        @foreach($newArrivals->take(4) as $product)
                            @include('storefront.partials.product-card', ['product' => $product])
                        @endforeach
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- 4. All Products Catalog with Instant Smart Tab Filtering -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 border-t border-slate-100"
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
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-3 mb-6">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-6 bg-[#2563ea] rounded-full"></span>
                    <h2 class="text-lg sm:text-xl font-black text-[#2563ea]">جميع المنتجات والأدوات التعليمية</h2>
                </div>
                <p class="text-xs text-slate-500 font-semibold mt-1">تصفح حلولنا المتنوعة لتطوير مهارات طفلك حسب احتياجه وعمره</p>
            </div>

            <!-- Responsive Filter Tabs Pills (Horizontal swipeable on mobile) -->
            <div class="flex items-center gap-1.5 sm:gap-2 overflow-x-auto no-scrollbar py-1">
                <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-[#2563ea] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all whitespace-nowrap">
                    الكل
                </button>
                <button @click="activeTab = 'tools'" :class="activeTab === 'tools' ? 'bg-[#2563ea] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all whitespace-nowrap">
                    الأدوات المادية
                </button>
                <button @click="activeTab = 'digital'" :class="activeTab === 'digital' ? 'bg-[#2563ea] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all whitespace-nowrap">
                    شيتات PDF
                </button>
                <button @click="activeTab = 'bundles'" :class="activeTab === 'bundles' ? 'bg-[#2563ea] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all whitespace-nowrap">
                    باقات التوفير
                </button>
                <button @click="activeTab = 'speech'" :class="activeTab === 'speech' ? 'bg-[#2563ea] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all whitespace-nowrap">
                    النطق والتخاطب
                </button>
                <button @click="activeTab = 'focus'" :class="activeTab === 'focus' ? 'bg-[#2563ea] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all whitespace-nowrap">
                    التركيز والانتباه
                </button>
                <button @click="activeTab = 'learning'" :class="activeTab === 'learning' ? 'bg-[#2563ea] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all whitespace-nowrap">
                    صعوبات التعلم
                </button>
            </div>
        </div>

        <!-- 2-Column on Mobile, 4-Column on Desktop Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-5">
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
        <div class="flex items-center justify-center mt-8 sm:mt-10">
            <a href="{{ route('search') }}" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 border-2 border-slate-200 hover:border-[#2563ea] text-slate-700 hover:text-[#2563ea] font-extrabold text-xs sm:text-sm py-3 px-8 sm:px-10 rounded-full transition-all shadow-xs group">
                <span>تصفح جميع المنتجات ({{ \App\Models\Product::where('is_active', true)->count() }} منتج)</span>
                <svg class="w-4 h-4 rotate-180 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>

    </div>

    <!-- 5. Triple Vibrant Feature Banners (الكروت الثلاثية الملونة المطابقة للنموذج) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 lg:gap-6">
            
            @foreach(['card1', 'card2', 'card3'] as $cKey)
                @php
                    $card = $featureCards[$cKey];
                    $cardImg = $card['image'];
                    $cardImgVer = file_exists(public_path($cardImg)) ? filemtime(public_path($cardImg)) : time();
                @endphp
                <a href="{{ $card['btn_link'] }}" class="group block relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-xl"
                   style="background-color: {{ $card['bg'] }} !important; border-radius: 26px !important; height: 200px !important; min-height: 200px !important; max-height: 200px !important; text-decoration: none !important;">
                    
                    <div style="display: flex !important; align-items: center !important; justify-content: space-between !important; height: 100% !important; padding: 20px 24px !important; position: relative !important;">
                        
                        <!-- Text Content (Right in RTL) -->
                        <div style="flex: 1 1 auto !important; max-width: 60% !important; display: flex !important; flex-direction: column !important; justify-content: space-between !important; height: 100% !important; z-index: 10 !important; text-align: right !important;">
                            <div>
                                <h3 style="color: #ffffff !important; font-size: 1.15rem !important; font-weight: 900 !important; line-height: 1.25 !important; margin-bottom: 5px !important; text-shadow: 0 1px 3px rgba(0,0,0,0.3) !important;">
                                    {{ $card['title'] }}
                                </h3>
                                <p style="color: rgba(255,255,255,0.92) !important; font-size: 0.75rem !important; font-weight: 600 !important; line-height: 1.4 !important; margin: 0 !important; text-shadow: 0 1px 2px rgba(0,0,0,0.2) !important;">
                                    {{ $card['subtitle'] }}
                                </p>
                            </div>

                            <div style="margin-top: auto !important; padding-top: 8px !important;">
                                <span style="display: inline-flex !important; align-items: center !important; gap: 6px !important; background-color: #ffffff !important; color: #0f172a !important; border-radius: 9999px !important; padding: 6px 16px !important; font-size: 0.75rem !important; font-weight: 900 !important; box-shadow: 0 1px 3px rgba(0,0,0,0.15) !important;">
                                    <span>{{ $card['btn_text'] }}</span>
                                    <svg style="width: 12px; height: 12px; transform: rotate(180deg);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </span>
                            </div>
                        </div>

                        <!-- 3D Toy Image (Left in RTL) -->
                        <div style="position: absolute !important; left: 12px !important; top: 0 !important; bottom: 0 !important; width: 40% !important; display: flex !important; align-items: center !important; justify-content: center !important; pointer-events: none !important; z-index: 10 !important;">
                            <img src="{{ asset($cardImg) }}?v={{ $cardImgVer }}" alt="{{ $card['title'] }}" style="max-height: 150px !important; max-width: 100% !important; object-fit: contain !important; filter: drop-shadow(0 6px 10px rgba(0,0,0,0.25)) !important;" class="group-hover:scale-105 transition-transform duration-500">
                        </div>

                    </div>

                    <!-- Subtle Corner Glow -->
                    <div style="position: absolute !important; top: -20px !important; right: -20px !important; width: 100px !important; height: 100px !important; border-radius: 9999px !important; background: rgba(255,255,255,0.12) !important; filter: blur(12px) !important; pointer-events: none !important;"></div>
                </a>
            @endforeach

        </div>
    </div>

    <!-- 6. Simple Sleek Bottom Banner (بانر عريض مع زرارين تفاعليين) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 mb-4">
        <div class="relative overflow-hidden rounded-3xl shadow-md border border-slate-200/80 group min-h-[220px] sm:min-h-[260px] md:min-h-[280px] flex items-center bg-slate-900">
            
            <!-- Banner Image -->
            <img src="{{ asset($bottomBanner['image']) }}" alt="{{ $bottomBanner['title'] }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
            
            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-950/50 to-transparent"></div>

            <!-- Content Area -->
            <div class="relative z-10 p-6 sm:p-10 md:p-12 max-w-2xl text-right text-white space-y-3 sm:space-y-4">
                
                <h2 class="text-xl sm:text-3xl md:text-4xl font-black text-white leading-tight" style="text-shadow: 0 2px 4px rgba(0,0,0,0.6);">
                    {{ $bottomBanner['title'] }}
                </h2>

                <p class="text-xs sm:text-sm md:text-base text-slate-200 font-medium leading-relaxed max-w-xl" style="text-shadow: 0 1px 3px rgba(0,0,0,0.8);">
                    {{ $bottomBanner['subtitle'] }}
                </p>

                <!-- 2 Clean Responsive Buttons -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3 pt-2">
                    <a href="{{ $bottomBanner['btn1_link'] }}" class="px-6 sm:px-8 py-3 rounded-2xl bg-[#2563ea] hover:bg-blue-700 text-white text-xs sm:text-sm font-black flex items-center justify-center gap-2 shadow-lg shadow-blue-600/30 transition-all hover:scale-[1.02] active:scale-95">
                        <span>{{ $bottomBanner['btn1_text'] }}</span>
                        <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>

                    <a href="{{ $bottomBanner['btn2_link'] }}" target="_blank" rel="noopener noreferrer" class="px-6 sm:px-8 py-3 rounded-2xl bg-white/95 hover:bg-white text-slate-900 text-xs sm:text-sm font-black flex items-center justify-center gap-2 shadow-md transition-all hover:scale-[1.02] active:scale-95">
                        <svg class="w-4 h-4 text-emerald-600 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.458L0 24zm6.002-3.693c1.615.957 3.178 1.462 4.736 1.463 5.485.002 9.948-4.463 9.95-9.953.001-2.66-1.025-5.16-2.887-7.026C16.001 2.923 13.506 1.897 10.85 1.897c-5.486 0-9.949 4.464-9.953 9.954-.001 2.052.541 4.06 1.567 5.814l-1.026 3.75 3.829-1.004z"></path></svg>
                        <span>{{ $bottomBanner['btn2_text'] }}</span>
                    </a>
                </div>

            </div>

        </div>
    </div>

    <!-- 7. Brands & Educational Partners Section (سكشن مستقل للبراندات والشركاء في الأسفل) -->
    @if(($topBrands->isNotEmpty() || $bottomBrands->isNotEmpty()))
    <div class="py-12 sm:py-16 my-4 relative overflow-hidden bg-gradient-to-b from-slate-100/70 via-white to-slate-100/60 border-t border-slate-200/80 marquee-container">
        
        <!-- Section Header -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-8">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-black bg-blue-50 text-[#2563ea] border border-blue-100 mb-2.5">
                <span class="w-2 h-2 rounded-full bg-[#2563ea]"></span>
                <span>العلامات التجارية وشركاء التعليم</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900">
                أبرز البراندات والوسائل المعتمدة
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 font-semibold mt-1.5">
                اضغط على أي علامة تجارية لاستعراض كافة منتجاتها وأدواتها التعليمية المتوفرة
            </p>
        </div>

        <!-- Disappearing Gradient Overlays at left and right -->
        <div class="pointer-events-none absolute left-0 top-0 bottom-0 w-16 sm:w-48 bg-gradient-to-r from-[#F8FAFC] via-[#F8FAFC]/80 to-transparent z-20"></div>
        <div class="pointer-events-none absolute right-0 top-0 bottom-0 w-16 sm:w-48 bg-gradient-to-l from-[#F8FAFC] via-[#F8FAFC]/80 to-transparent z-20"></div>

        <!-- RIBBON 1 (Top Strip: Tilted -1.5deg, Scrolling Forward) -->
        <div class="py-2.5 overflow-hidden transform -rotate-1 sm:-rotate-1.5 origin-center scale-105 my-2" dir="ltr">
            <div class="animate-marquee-forward flex items-center">
                @for($repeat = 0; $repeat < 6; $repeat++)
                    @foreach($topBrands as $b)
                        <a href="{{ $b->target_url }}" title="{{ $b->name }}" class="flex-shrink-0 mx-2.5 sm:mx-3.5 bg-white rounded-3xl p-3 sm:p-4 px-6 sm:px-8 border border-slate-200 shadow-2xs hover:shadow-xl hover:border-[#2563ea] hover:scale-105 transition-all duration-300 flex items-center justify-center min-w-[160px] sm:min-w-[210px] h-20 sm:h-24 group">
                            <img src="{{ asset($b->logo) }}" alt="{{ $b->name }}" class="max-h-12 sm:max-h-15 w-auto object-contain group-hover:scale-108 transition-transform duration-300">
                        </a>
                    @endforeach
                @endfor
            </div>
        </div>

        <!-- RIBBON 2 (Bottom Strip: Tilted +1.5deg, Scrolling Backward / Opposite) -->
        <div class="py-2.5 overflow-hidden transform rotate-1 sm:rotate-1.5 origin-center scale-105 my-2" dir="ltr">
            <div class="animate-marquee-backward flex items-center">
                @for($repeat = 0; $repeat < 6; $repeat++)
                    @foreach($bottomBrands as $b)
                        <a href="{{ $b->target_url }}" title="{{ $b->name }}" class="flex-shrink-0 mx-2.5 sm:mx-3.5 bg-white rounded-3xl p-3 sm:p-4 px-6 sm:px-8 border border-slate-200 shadow-2xs hover:shadow-xl hover:border-emerald-500 hover:scale-105 transition-all duration-300 flex items-center justify-center min-w-[160px] sm:min-w-[210px] h-20 sm:h-24 group">
                            <img src="{{ asset($b->logo) }}" alt="{{ $b->name }}" class="max-h-12 sm:max-h-15 w-auto object-contain group-hover:scale-108 transition-transform duration-300">
                        </a>
                    @endforeach
                @endfor
            </div>
        </div>

    </div>
    @endif

    <!-- Marquee Ribbons Keyframe CSS -->
    <style>
        @keyframes marquee-forward {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        @keyframes marquee-backward {
            0% { transform: translateX(-50%); }
            100% { transform: translateX(0%); }
        }
        .animate-marquee-forward {
            display: flex;
            width: max-content;
            animation: marquee-forward 28s linear infinite;
        }
        .animate-marquee-backward {
            display: flex;
            width: max-content;
            animation: marquee-backward 28s linear infinite;
        }
        .marquee-container:hover .animate-marquee-forward,
        .marquee-container:hover .animate-marquee-backward {
            animation-play-state: paused;
        }
    </style>
</div>
@endsection
