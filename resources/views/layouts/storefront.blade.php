<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', '2morro | أدوات تعليمية تنمي مهارات طفلك')</title>

        <!-- Favicon (Store Logo) -->
        @php
            $favLogo = \App\Models\Setting::get('store_logo', 'images/logo.png');
            $favVersion = file_exists(public_path($favLogo)) ? filemtime(public_path($favLogo)) : time();
        @endphp
        <link rel="icon" type="image/png" href="{{ asset($favLogo) }}?v={{ $favVersion }}">
        <link rel="shortcut icon" href="{{ asset($favLogo) }}?v={{ $favVersion }}">
        <link rel="apple-touch-icon" href="{{ asset($favLogo) }}?v={{ $favVersion }}">

        <!-- Google Fonts: Cairo -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Tailwind CSS & Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
            :root {
                --theme-blue: #2563ea;
                --theme-blue-hover: #1d4ed8;
            }
            body {
                font-family: 'Cairo', sans-serif;
            }
            .bg-\[\#1360e2\],
            .bg-\[\#2563eb\],
            .bg-\[\#2563ea\],
            .bg-theme-blue {
                background-color: #2563ea !important;
            }
            .text-\[\#1360e2\],
            .text-\[\#2563eb\],
            .text-\[\#2563ea\],
            .text-theme-blue {
                color: #2563ea !important;
            }
            .border-\[\#1360e2\],
            .border-\[\#2563eb\],
            .border-\[\#2563ea\],
            .border-theme-blue {
                border-color: #2563ea !important;
            }
            .hover\:bg-\[\#1360e2\]:hover,
            .hover\:bg-\[\#2563eb\]:hover,
            .hover\:bg-\[\#2563ea\]:hover {
                background-color: #1d4ed8 !important;
            }
            .hover\:text-\[\#1360e2\]:hover,
            .hover\:text-\[\#2563eb\]:hover,
            .hover\:text-\[\#2563ea\]:hover {
                color: #1d4ed8 !important;
            }
            @keyframes top-marquee {
                0% { transform: translateX(0%); }
                100% { transform: translateX(-50%); }
            }
            .animate-top-marquee {
                display: inline-flex;
                width: max-content;
                animation: top-marquee 20s linear infinite;
            }

            /* Skeleton Shimmer Loading Animations */
            @keyframes skeleton-shimmer {
                0% { background-position: -200% 0; }
                100% { background-position: 200% 0; }
            }
            .skeleton-shimmer {
                background: linear-gradient(90deg, #f8fafc 25%, #e2e8f0 50%, #f8fafc 75%);
                background-size: 200% 100%;
                animation: skeleton-shimmer 1.6s infinite linear;
            }
            .img-lazy-loading {
                opacity: 0;
                transition: opacity 0.3s ease-in;
            }
            .img-lazy-loaded {
                opacity: 1 !important;
            }
        </style>
        @yield('styles')
    </head>
    <body class="antialiased bg-[#F8FAFC] text-slate-800 font-sans selection:bg-blue-600 selection:text-white min-h-screen flex flex-col justify-between" 
          x-data="{ cartOpen: false, searchOpen: false, mobileMenuOpen: false }">
        
        @php
            $cart = session()->get('cart', []);
            $cartCount = count($cart);
            $cartTotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
            $storeLogo = \App\Models\Setting::get('store_logo', 'images/logo.png');
            $logoVersion = file_exists(public_path($storeLogo)) ? filemtime(public_path($storeLogo)) : time();
        @endphp

        <!-- Top Notification Banner (متحرك بسلاسة على الديسكتوب والموبايل) -->
        <div class="bg-[#2563ea] text-white text-[11px] font-bold py-1.5 px-2 overflow-hidden shadow-2xs select-none" style="background-color: #2563ea !important; color: #ffffff !important;" dir="ltr">
            <div class="flex overflow-hidden whitespace-nowrap w-full">
                <div class="inline-flex items-center animate-top-marquee gap-8" dir="rtl">
                    <span class="whitespace-nowrap">فروع مركز 2morro بالإسكندرية (الإبراهيمية - البيطاش - سيدي بشر) • جلسات وتقييمات في المركز وأونلاين • شحن مجاني للطلبات فوق 550 ج.م</span>
                    <span class="text-amber-300">•</span>
                    <span class="whitespace-nowrap">فروع مركز 2morro بالإسكندرية (الإبراهيمية - البيطاش - سيدي بشر) • جلسات وتقييمات في المركز وأونلاين • شحن مجاني للطلبات فوق 550 ج.م</span>
                    <span class="text-amber-300">•</span>
                    <span class="whitespace-nowrap">فروع مركز 2morro بالإسكندرية (الإبراهيمية - البيطاش - سيدي بشر) • جلسات وتقييمات في المركز وأونلاين • شحن مجاني للطلبات فوق 550 ج.م</span>
                    <span class="text-amber-300">•</span>
                    <span class="whitespace-nowrap">فروع مركز 2morro بالإسكندرية (الإبراهيمية - البيطاش - سيدي بشر) • جلسات وتقييمات في المركز وأونلاين • شحن مجاني للطلبات فوق 550 ج.م</span>
                    <span class="text-amber-300">•</span>
                </div>
            </div>
        </div>

        <!-- Sleek Compact Sticky Header (شريط مدمج ونحيف يحتوي على اللوجو والتصنيفات والسلة) -->
        <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-2xs transition-all">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="flex items-center justify-between h-15 sm:h-16 gap-4">
                    
                    <!-- 1. Right (RTL): 2morro Brand Logo -->
                    <div class="flex items-center gap-3">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-1.5 rounded-xl text-slate-700 hover:bg-slate-100 transition-colors" title="القائمة">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>

                        <a href="{{ route('home') }}" class="inline-flex items-center transition-transform hover:scale-105">
                            <img src="{{ asset($storeLogo) }}?v={{ $logoVersion }}" alt="2morro" style="max-height: 70px; height: 70px; width: auto; object-fit: contain;">
                        </a>
                    </div>

                    <!-- 2. Center: Categories Navigation & Dropdown -->
                    <nav class="hidden lg:flex items-center justify-center gap-1 xl:gap-2 text-[13px] font-bold text-slate-700">
                        
                        <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-xl hover:text-[#2563ea] hover:bg-slate-50 transition-colors {{ request()->routeIs('home') ? 'text-[#2563ea] bg-blue-50/80 font-black' : '' }}">
                            الرئيسية
                        </a>

                        <!-- Categories Dropdown (Alpine.js) -->
                        <div class="relative" x-data="{ catMenuOpen: false }" @click.away="catMenuOpen = false">
                            <button @click="catMenuOpen = !catMenuOpen" class="px-3 py-1.5 rounded-xl hover:text-[#2563ea] hover:bg-slate-50 transition-colors flex items-center gap-1.5 text-slate-800 font-extrabold">
                                <span>الأقسام والتصنيفات</span>
                                <svg class="w-3.5 h-3.5 text-slate-500 transition-transform duration-200" :class="catMenuOpen ? 'rotate-180 text-[#2563ea]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <!-- Dropdown Menu List -->
                            <div x-show="catMenuOpen" 
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-2"
                                 class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 text-right"
                                 x-cloak>
                                <a href="{{ route('search', ['category' => 'educational-tools']) }}" class="flex items-center justify-between px-4 py-2.5 hover:bg-blue-50 hover:text-[#2563ea] text-slate-700 text-xs font-bold transition-colors">
                                    <span>الأدوات التعليمية والوسائل</span>
                                    <svg class="w-3.5 h-3.5 text-slate-400 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                                <a href="{{ route('search', ['category' => 'digital-worksheets']) }}" class="flex items-center justify-between px-4 py-2.5 hover:bg-blue-50 hover:text-[#2563ea] text-slate-700 text-xs font-bold transition-colors">
                                    <span>شيتات وملفات PDF رقمية</span>
                                    <svg class="w-3.5 h-3.5 text-slate-400 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                                <a href="{{ route('search', ['category' => 'courses']) }}" class="flex items-center justify-between px-4 py-2.5 hover:bg-blue-50 hover:text-[#2563ea] text-slate-700 text-xs font-bold transition-colors">
                                    <span>الكورسات والبرامج التدريبية</span>
                                    <svg class="w-3.5 h-3.5 text-slate-400 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                                <a href="{{ route('search', ['category' => 'educational-bundles']) }}" class="flex items-center justify-between px-4 py-2.5 hover:bg-blue-50 hover:text-[#2563ea] text-slate-700 text-xs font-bold transition-colors">
                                    <span>باقات وعروض التوفير</span>
                                    <svg class="w-3.5 h-3.5 text-slate-400 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                                <div class="border-t border-slate-100 my-1"></div>
                                <a href="{{ route('booking.index') }}" class="flex items-center justify-between px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-900 text-xs font-black transition-colors rounded-xl mx-2">
                                    <span>حجز استشارة وتقييم</span>
                                    <span class="text-[10px] px-2 py-0.5 bg-amber-200 text-amber-900 rounded-md font-bold">متاح الآن</span>
                                </a>
                            </div>
                        </div>

                        <a href="{{ route('search', ['category' => 'educational-tools']) }}" class="px-3 py-1.5 rounded-xl hover:text-[#2563ea] hover:bg-slate-50 transition-colors whitespace-nowrap">
                            الأدوات التعليمية
                        </a>

                        <a href="{{ route('search', ['category' => 'digital-worksheets']) }}" class="px-3 py-1.5 rounded-xl hover:text-[#2563ea] hover:bg-slate-50 transition-colors whitespace-nowrap">
                            الشيتات الرقمية
                        </a>

                        <a href="{{ route('search', ['category' => 'educational-bundles']) }}" class="px-3 py-1.5 rounded-xl hover:text-[#2563ea] hover:bg-slate-50 transition-colors whitespace-nowrap">
                            باقات التوفير
                        </a>

                        <a href="{{ route('booking.index') }}" class="px-3.5 py-1.5 rounded-xl text-amber-800 bg-amber-50 hover:bg-amber-100 font-extrabold transition-colors whitespace-nowrap">
                            حجز استشارة
                        </a>

                    </nav>

                    <!-- 3. Left (RTL): Search, User Account, & Shopping Cart -->
                    <div class="flex items-center gap-1.5 sm:gap-2.5">
                        
                        <!-- Search Icon -->
                        <button @click="searchOpen = !searchOpen" title="بحث في المتجر" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl text-slate-700 hover:text-[#2563ea] hover:bg-slate-100 flex items-center justify-center transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>

                        <!-- User Account / My Account Dropdown -->
                        <div class="relative" x-data="{ userMenuOpen: false }" @click.away="userMenuOpen = false">
                            @auth
                                <button @click="userMenuOpen = !userMenuOpen" title="حسابي" class="inline-flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-[#2563ea] transition-all border border-slate-200/80">
                                    <span class="w-6 h-6 rounded-full bg-[#2563ea] text-white text-xs font-black flex items-center justify-center">
                                        {{ mb_substr(Auth::user()->name, 0, 1) }}
                                    </span>
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="userMenuOpen" 
                                     x-cloak
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 translate-y-2"
                                     class="absolute left-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 text-right">
                                    <div class="px-4 py-2.5 border-b border-slate-100">
                                        <div class="text-xs font-black text-slate-800">{{ Auth::user()->name }}</div>
                                        <div class="text-[11px] text-slate-400 truncate">{{ Auth::user()->email }}</div>
                                    </div>

                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 hover:bg-blue-50 text-[#2563ea] text-xs font-bold transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                            <span>لوحة التحكم (المدير)</span>
                                        </a>
                                    @endif

                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 hover:bg-slate-50 text-slate-700 text-xs font-bold transition-colors">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        <span>تعديل الحساب</span>
                                    </a>

                                    <div class="border-t border-slate-100 my-1"></div>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 hover:bg-red-50 text-red-600 text-xs font-bold transition-colors text-right">
                                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            <span>تسجيل الخروج</span>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <a href="{{ route('login') }}" title="تسجيل الدخول / حسابي" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl text-slate-700 hover:text-[#2563ea] hover:bg-slate-100 flex items-center justify-center transition-colors">
                                    <svg class="w-5 h-5 sm:w-5.5 sm:h-5.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </a>
                            @endauth
                        </div>

                        <!-- Corrected High-Quality Cart Button & Badge -->
                        <button @click="cartOpen = true" title="سلة المشتريات" class="relative inline-flex items-center justify-center w-10 h-10 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-blue-50/90 hover:bg-blue-100 text-[#2563ea] hover:text-blue-700 border border-blue-100 shadow-2xs transition-all group">
                            <!-- Clean Shopping Cart Bag SVG -->
                            <svg class="w-5 h-5 sm:w-5.5 sm:h-5.5 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>

                            <!-- Accurate Pin-point Badge on top corner -->
                            <span class="absolute -top-1.5 -left-1.5 min-w-[18px] sm:min-w-[20px] h-[18px] sm:h-5 px-1 bg-[#EF4444] text-white text-[10px] sm:text-[11px] font-black rounded-full flex items-center justify-center shadow-xs border-2 border-white ring-1 ring-red-100">
                                {{ $cartCount }}
                            </span>
                        </button>

                    </div>

                </div>

            </div>

            <!-- Sleek Dropdown Search Overlay -->
            <div x-show="searchOpen" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="border-t border-slate-100 bg-white/98 backdrop-blur-lg py-3 px-4 sm:px-8 shadow-md">
                <div class="max-w-3xl mx-auto flex items-center gap-3">
                    <form action="{{ route('search') }}" method="GET" class="flex-1 relative flex items-center bg-[#F8FAFC] border border-slate-200 focus-within:border-blue-600 focus-within:ring-2 focus-within:ring-blue-100 rounded-full h-10 px-4">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="ابحث عن منتج، شيت رقمي، أو مهارة مستهدفة..." class="w-full bg-transparent border-0 text-sm font-semibold focus:ring-0 text-slate-800 placeholder-slate-400 px-2">
                        <button type="submit" class="text-white font-bold text-xs bg-[#2563ea] hover:bg-blue-700 px-4 py-1.5 rounded-full transition-colors">بحث</button>
                    </form>
                    <button @click="searchOpen = false" class="p-2 text-slate-400 hover:text-slate-600 text-lg font-bold">✕</button>
                </div>
            </div>

            <!-- Mobile Navigation Drawer -->
            <div x-show="mobileMenuOpen" 
                 x-cloak
                 class="lg:hidden border-t border-slate-100 bg-white px-4 py-4 space-y-2.5 shadow-lg">
                <a href="{{ route('home') }}" class="block text-sm font-black text-blue-600 py-2 border-b border-slate-50">الرئيسية</a>
                <a href="{{ route('search', ['category' => 'educational-tools']) }}" class="block text-sm font-bold text-slate-700 py-2 border-b border-slate-50">الأدوات التعليمية</a>
                <a href="{{ route('search', ['category' => 'digital-worksheets']) }}" class="block text-sm font-bold text-slate-700 py-2 border-b border-slate-50">الشيتات التعليمية</a>
                <a href="{{ route('search', ['category' => 'courses']) }}" class="block text-sm font-bold text-slate-700 py-2 border-b border-slate-50">الكورسات والبرامج</a>
                <a href="{{ route('search', ['category' => 'educational-bundles']) }}" class="block text-sm font-bold text-slate-700 py-2 border-b border-slate-50">الباقات والعروض</a>
                <a href="{{ route('booking.index') }}" class="block text-sm font-bold text-amber-700 py-2 border-b border-slate-50">حجز استشارة وتقييم</a>
                <a href="https://linktr.ee/hebaalla?subscribe" target="_blank" class="block text-sm font-black text-emerald-600 py-2 border-b border-slate-50">صفحة روابط المركز (Linktree)</a>

                @auth
                    <div class="pt-2 border-t border-slate-100">
                        <div class="text-xs font-bold text-slate-400 mb-1">حسابي ({{ Auth::user()->name }})</div>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block text-sm font-bold text-[#2563ea] py-1.5">لوحة التحكم (المدير)</a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="block text-sm font-bold text-slate-700 py-1.5">تعديل الملف الشخصي</a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-1">
                            @csrf
                            <button type="submit" class="text-sm font-bold text-red-600 py-1.5 w-full text-right">تسجيل الخروج</button>
                        </form>
                    </div>
                @else
                    <div class="pt-2 border-t border-slate-100 flex items-center gap-3">
                        <a href="{{ route('login') }}" class="flex-1 bg-[#2563ea] text-white text-center py-2 rounded-xl text-xs font-bold">تسجيل الدخول</a>
                        <a href="{{ route('register') }}" class="flex-1 bg-slate-100 text-slate-700 text-center py-2 rounded-xl text-xs font-bold">إنشاء حساب</a>
                    </div>
                @endauth
            </div>

        </header>

        <!-- Main Content Area -->
        <main class="flex-grow pb-16 md:pb-0">
            @yield('content')
        </main>

        <!-- Slide-Over Cart Drawer -->
        <div class="fixed inset-0 overflow-hidden z-[100]" style="display: none;" x-show="cartOpen" x-transition>
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity" @click="cartOpen = false"></div>

                <div class="fixed inset-y-0 left-0 pl-10 max-w-full flex">
                    <div class="w-screen max-w-md bg-white shadow-2xl flex flex-col justify-between"
                         @click.away="cartOpen = false"
                         x-show="cartOpen"
                         x-transition:enter="transform transition ease-in-out duration-300"
                         x-transition:enter-start="-translate-x-full"
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transform transition ease-in-out duration-300"
                         x-transition:leave-start="translate-x-0"
                         x-transition:leave-end="-translate-x-full">
                        
                        <div class="p-5 border-b border-slate-200 flex justify-between items-center bg-slate-50">
                            <h3 class="text-sm font-bold text-slate-800 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-[#2563ea]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                <span>سلة المشتريات</span>
                            </h3>
                            <button @click="cartOpen = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">✕</button>
                        </div>

                        <div class="flex-grow overflow-y-auto p-5 flex flex-col gap-4">
                            @if(empty($cart))
                                <div class="flex flex-col items-center justify-center gap-4 text-center my-auto">
                                    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    </div>
                                    <p class="text-sm font-bold text-slate-600">سلة المشتريات فارغة حالياً</p>
                                    <a href="{{ route('search') }}" class="text-xs bg-[#2563ea] text-white px-5 py-2.5 rounded-full font-bold hover:bg-blue-700 transition-colors shadow-xs">
                                        تصفح المنتجات الآن
                                    </a>
                                </div>
                            @else
                                @foreach($cart as $id => $item)
                                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100 last:border-0">
                                        <div class="w-12 h-12 bg-slate-50 border border-slate-200 rounded-xl overflow-hidden p-1 flex-shrink-0 flex items-center justify-center">
                                            @if($item['image'])
                                                <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-contain">
                                            @else
                                                📄
                                            @endif
                                        </div>
                                        <div class="flex-grow leading-tight">
                                            <h4 class="text-xs font-bold text-slate-700">{{ $item['name'] }}</h4>
                                            <span class="text-[10px] text-slate-400 font-semibold mt-1">{{ number_format($item['price'], 2) }} ج.م</span>
                                            
                                            <div class="flex items-center gap-3 mt-2">
                                                <form action="{{ route('cart.update') }}" method="POST" class="flex items-center border border-slate-200 rounded-lg overflow-hidden text-xs">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                                    <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="px-2 py-0.5 hover:bg-slate-100">-</button>
                                                    <span class="px-3 py-0.5 bg-slate-50 font-bold">{{ $item['quantity'] }}</span>
                                                    <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="px-2 py-0.5 hover:bg-slate-100">+</button>
                                                </form>

                                                <form action="{{ route('cart.remove') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                                    <button type="submit" class="text-[10px] text-red-500 hover:underline">حذف</button>
                                                </form>
                                            </div>
                                        </div>
                                        <span class="text-xs font-bold text-slate-800 flex-shrink-0">{{ number_format($item['price'] * $item['quantity'], 2) }} ج.م</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        @if(!empty($cart))
                            <div class="p-5 border-t border-slate-200 bg-slate-50 flex flex-col gap-3">
                                <div class="flex justify-between items-center text-xs font-bold">
                                    <span class="text-slate-500">المجموع الفرعي:</span>
                                    <span class="text-slate-800 text-sm font-black">{{ number_format($cartTotal, 2) }} ج.م</span>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <form action="{{ route('cart.clear') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full border border-slate-300 hover:bg-slate-100 text-slate-600 font-bold text-xs py-2 rounded-xl transition-colors">تفريغ</button>
                                    </form>
                                    <a href="{{ route('checkout.index') }}" class="w-full bg-[#1360e2] hover:bg-slate-800 text-white font-bold text-xs py-2 rounded-xl text-center flex items-center justify-center transition-colors">إتمام الشراء</a>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- COMPLETE MODERN CRISP FOOTER (تصميم أنيق عالي التباين وواضح بالكامل) -->
        <!-- ========================================================================= -->
        <footer class="bg-[#F8FAFC] text-slate-700 border-t border-slate-200/90 mt-10 sm:mt-16 pt-8 sm:pt-12 pb-8 px-4 sm:px-6 lg:px-8 relative">
            <div class="max-w-7xl mx-auto">
                
                <!-- 1. Top Feature Highlights (مزايا وخدمات المركز المعتمدة) -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-5 pb-8 sm:pb-10 border-b border-slate-200 text-right">
                    
                    <!-- Feature 1 -->
                    <div class="bg-white border border-slate-200/90 shadow-2xs p-3 sm:p-4 rounded-2xl flex items-center gap-3 transition-all duration-200 hover:shadow-xs hover:border-blue-300">
                        <div class="w-10 sm:w-11 h-10 sm:h-11 rounded-xl bg-blue-50 text-[#2563ea] flex items-center justify-center flex-shrink-0 border border-blue-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs sm:text-sm font-black text-slate-900">شحن سريع ومجاني</span>
                            <span class="text-[10px] sm:text-xs text-slate-500 font-semibold">للطلبات فوق 550 ج.م</span>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white border border-slate-200/90 shadow-2xs p-3 sm:p-4 rounded-2xl flex items-center gap-3 transition-all duration-200 hover:shadow-xs hover:border-emerald-300">
                        <div class="w-10 sm:w-11 h-10 sm:h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 border border-emerald-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs sm:text-sm font-black text-slate-900">إشراف وتأهيل معتمد</span>
                            <span class="text-[10px] sm:text-xs text-slate-500 font-semibold">أ. هبة الله أكرم</span>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white border border-slate-200/90 shadow-2xs p-3 sm:p-4 rounded-2xl flex items-center gap-3 transition-all duration-200 hover:shadow-xs hover:border-amber-300">
                        <div class="w-10 sm:w-11 h-10 sm:h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0 border border-amber-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs sm:text-sm font-black text-slate-900">جلسات واستشارات</span>
                            <span class="text-[10px] sm:text-xs text-slate-500 font-semibold">بالفروع وأونلاين</span>
                        </div>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-white border border-slate-200/90 shadow-2xs p-3 sm:p-4 rounded-2xl flex items-center gap-3 transition-all duration-200 hover:shadow-xs hover:border-purple-300">
                        <div class="w-10 sm:w-11 h-10 sm:h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center flex-shrink-0 border border-purple-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs sm:text-sm font-black text-slate-900">دفع آمن وسهل</span>
                            <span class="text-[10px] sm:text-xs text-slate-500 font-semibold">انستاباي ومحافظ وكاش</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Main Footer Grid -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-10 py-8 sm:py-12 text-right">
                    
                    <!-- Col 1: Brand Info, Vision & Social Channels (4 cols) -->
                    <div class="md:col-span-4 flex flex-col gap-3.5">
                        <div class="inline-block bg-white p-2 rounded-2xl self-start shadow-xs border border-slate-200">
                            <img src="{{ asset($storeLogo) }}?v={{ $logoVersion }}" alt="2morro" style="max-height: 52px; width: auto; object-fit: contain;" class="h-10 sm:h-12 w-auto object-contain">
                        </div>
                        
                        <p class="text-xs sm:text-sm text-slate-600 font-semibold leading-relaxed">
                            <b class="text-slate-900 font-extrabold">مركز ومتجر 2morro:</b> تأهيل وتنمية مهارات الأطفال وتوفير أفضل الوسائل والألعاب التعليمية والشيتات الرقمية التفاعلية بإشراف أ. هبة الله أكرم.
                        </p>

                        <!-- Linktree Official Button -->
                        <div class="pt-0.5">
                            <a href="https://linktr.ee/hebaalla?subscribe" target="_blank" rel="noopener noreferrer" 
                               class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 text-xs font-black transition-all shadow-2xs group">
                                <svg class="w-4 h-4 text-emerald-600 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                <span>صفحة روابط المركز الرسمية (Linktree)</span>
                            </a>
                        </div>
                        
                        <!-- Social Media Network Badges -->
                        <div class="flex flex-wrap items-center gap-2 pt-1">
                            <!-- WhatsApp -->
                            <a href="https://wa.me/201550504512" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white border border-emerald-200 flex items-center justify-center transition-all duration-200 shadow-2xs hover:scale-105" title="واتساب (01550504512)">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.458L0 24zm6.002-3.693c1.615.957 3.178 1.462 4.736 1.463 5.485.002 9.948-4.463 9.95-9.953.001-2.66-1.025-5.16-2.887-7.026C16.001 2.923 13.506 1.897 10.85 1.897c-5.486 0-9.949 4.464-9.953 9.954-.001 2.052.541 4.06 1.567 5.814l-1.026 3.75 3.829-1.004z"></path></svg>
                            </a>
                            <!-- Facebook -->
                            <a href="https://www.facebook.com/2morroo" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white border border-blue-200 flex items-center justify-center transition-all duration-200 shadow-2xs hover:scale-105" title="فيسبوك">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M9 8H7v3h2v9h3v-9h3.6L15 8h-3V6.5C12 5.67 12.5 5 13.5 5H15V2h-2.5C9.5 2 9 3.5 9 5.5V8z"></path></svg>
                            </a>
                            <!-- Instagram -->
                            <a href="https://www.instagram.com/hebaallaakrm/" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-pink-50 text-pink-600 hover:bg-pink-600 hover:text-white border border-pink-200 flex items-center justify-center transition-all duration-200 shadow-2xs hover:scale-105" title="انستجرام">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"></path></svg>
                            </a>
                            <!-- YouTube -->
                            <a href="https://youtube.com/c/2Morro?sub_confirmation=1" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white border border-red-200 flex items-center justify-center transition-all duration-200 shadow-2xs hover:scale-105" title="يوتيوب">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"></path></svg>
                            </a>
                            <!-- Phone -->
                            <a href="tel:01550504512" class="w-9 h-9 rounded-xl bg-blue-50 text-[#2563ea] hover:bg-[#2563ea] hover:text-white border border-blue-200 flex items-center justify-center transition-all duration-200 shadow-2xs hover:scale-105" title="اتصال مباشر">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Col 2: Alexandria Branches Cards (4 cols) -->
                    <div class="md:col-span-4 flex flex-col gap-3">
                        <h5 class="text-sm font-black text-slate-900 flex items-center gap-2 mb-0.5">
                            <span class="w-2 h-4 bg-[#EF4444] rounded-full"></span>
                            فروع المركز بالإسكندرية
                        </h5>

                        <div class="space-y-2.5">
                            <!-- Branch 1: Ibrahimia -->
                            <div class="bg-white border border-slate-200/90 shadow-2xs p-3 rounded-2xl hover:border-blue-300 transition-colors">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <span class="font-black text-slate-900 text-xs block">📍 فرع الإبراهيمية:</span>
                                        <span class="text-slate-600 text-[11px] block mt-0.5">أول لاجتيه من شارع أبو قير (فوق سنترال إياد)</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-md bg-blue-50 text-[#2563ea] text-[10px] font-extrabold border border-blue-200 whitespace-nowrap">الرئيسي</span>
                                </div>
                                <div class="flex items-center gap-2 mt-2 pt-2 border-t border-slate-100">
                                    <a href="tel:01550504512" class="text-[11px] font-mono text-[#2563ea] hover:underline font-bold flex items-center gap-1" dir="ltr">
                                        <span>01550504512</span>
                                    </a>
                                    <span class="text-slate-400">/</span>
                                    <a href="tel:035918166" class="text-[11px] font-mono text-slate-700 hover:text-black font-bold" dir="ltr">03 5918166</a>
                                </div>
                            </div>

                            <!-- Branch 2: Bitash -->
                            <div class="bg-white border border-slate-200/90 shadow-2xs p-3 rounded-2xl hover:border-emerald-300 transition-colors">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <span class="font-black text-slate-900 text-xs block">📍 فرع أول البيطاش (العجمي):</span>
                                        <span class="text-slate-600 text-[11px] block mt-0.5">أمام بنك القاهرة - عمارة مركز القلب</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 text-[10px] font-extrabold border border-emerald-200 whitespace-nowrap">فرع غرب</span>
                                </div>
                                <div class="flex items-center gap-2 mt-2 pt-2 border-t border-slate-100">
                                    <a href="tel:01064580472" class="text-[11px] font-mono text-emerald-700 hover:underline font-bold" dir="ltr">01064580472</a>
                                    <span class="text-slate-400">/</span>
                                    <a href="tel:033090476" class="text-[11px] font-mono text-slate-700 hover:text-black font-bold" dir="ltr">03 3090476</a>
                                </div>
                            </div>

                            <!-- Branch 3: Sidi Bishr -->
                            <div class="bg-white border border-slate-200/90 shadow-2xs p-3 rounded-2xl hover:border-purple-300 transition-colors">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <span class="font-black text-slate-900 text-xs block">📍 فرع سيدي بشر:</span>
                                        <span class="text-slate-600 text-[11px] block mt-0.5">أول نفق جمال عبد الناصر (فوق رؤية سكان)</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-md bg-purple-50 text-purple-700 text-[10px] font-extrabold border border-purple-200 whitespace-nowrap">فرع شرق</span>
                                </div>
                                <div class="flex items-center gap-2 mt-2 pt-2 border-t border-slate-100">
                                    <a href="tel:01508074512" class="text-[11px] font-mono text-purple-700 hover:underline font-bold" dir="ltr">01508074512</a>
                                    <span class="text-slate-400">/</span>
                                    <a href="tel:035542766" class="text-[11px] font-mono text-slate-700 hover:text-black font-bold" dir="ltr">03 5542766</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Col 3: Quick Store Catalog & Booking (2 cols) -->
                    <div class="md:col-span-2 flex flex-col gap-3">
                        <h5 class="text-sm font-black text-slate-900 flex items-center gap-2 mb-0.5">
                            <span class="w-2 h-4 bg-[#2563ea] rounded-full"></span>
                            أقسام المتجر
                        </h5>
                        <ul class="text-xs space-y-2 text-slate-600 font-bold">
                            <li><a href="{{ route('search', ['category' => 'educational-tools']) }}" class="hover:text-[#2563ea] transition-colors flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> الألعاب والأدوات المادية</a></li>
                            <li><a href="{{ route('search', ['category' => 'digital-worksheets']) }}" class="hover:text-[#2563ea] transition-colors flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> شيتات وأوراق عمل PDF</a></li>
                            <li><a href="{{ route('search', ['category' => 'educational-bundles']) }}" class="hover:text-[#2563ea] transition-colors flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> باقات وعروض التوفير</a></li>
                            <li class="pt-2">
                                <a href="{{ route('booking.index') }}" class="inline-flex items-center gap-1.5 text-xs font-black text-[#2563ea] bg-blue-50 border border-blue-200 px-3 py-1.5 rounded-xl hover:bg-[#2563ea] hover:text-white transition-all">
                                    <span>حجز موعد استشارة</span>
                                    <svg class="w-3.5 h-3.5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Col 4: Working Hours & Support (2 cols) -->
                    <div class="md:col-span-2 flex flex-col gap-3">
                        <h5 class="text-sm font-black text-slate-900 flex items-center gap-2 mb-0.5">
                            <span class="w-2 h-4 bg-amber-500 rounded-full"></span>
                            مواعيد العمل
                        </h5>
                        
                        <div class="bg-amber-50/90 border border-amber-200 p-3.5 rounded-2xl shadow-2xs">
                            <div class="flex items-center gap-1.5 text-amber-900 font-black text-xs mb-1">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>أوقات العمل اليومية:</span>
                            </div>
                            <span class="font-black text-slate-900 text-xs block">12:00 ظ - 9:00 م</span>
                            <span class="text-[10px] text-amber-800 font-bold block mt-0.5">(يومياً عدا الجمعة)</span>
                        </div>

                        <!-- Direct WhatsApp Support Button -->
                        <a href="https://wa.me/201550504512?text={{ urlencode('مرحباً مركز 2morro، أود الاستفسار عن الخدمات والمنتجات.') }}" 
                           target="_blank" 
                           class="w-full bg-[#25D366] hover:bg-[#1EBE5D] text-white font-black text-xs py-2.5 px-3 rounded-xl flex items-center justify-center gap-1.5 shadow-sm transition-transform hover:scale-[1.02] active:scale-95">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.458L0 24zm6.002-3.693c1.615.957 3.178 1.462 4.736 1.463 5.485.002 9.948-4.463 9.95-9.953.001-2.66-1.025-5.16-2.887-7.026C16.001 2.923 13.506 1.897 10.85 1.897c-5.486 0-9.949 4.464-9.953 9.954-.001 2.052.541 4.06 1.567 5.814l-1.026 3.75 3.829-1.004z"></path></svg>
                            <span>تحدث معنا واتساب</span>
                        </a>
                    </div>

                </div>

                <!-- 3. Bottom Copyright & Payment Methods -->
                <div class="pt-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500 font-bold text-center sm:text-right">
                    <p class="text-[11px] sm:text-xs text-slate-600">
                        جميع الحقوق محفوظة &copy; {{ date('Y') }} <span class="text-[#2563ea] font-extrabold">مركز ومتجر 2morro</span> | إشراف أ. هبة الله أكرم.
                    </p>
                    
                    <div class="flex flex-wrap items-center gap-1.5 justify-center">
                        <span class="px-2.5 py-1 bg-white border border-slate-200 shadow-2xs rounded-lg text-[10px] font-black text-slate-700">InstaPay</span>
                        <span class="px-2.5 py-1 bg-white border border-slate-200 shadow-2xs rounded-lg text-[10px] font-black text-slate-700">Vodafone Cash</span>
                        <span class="px-2.5 py-1 bg-white border border-slate-200 shadow-2xs rounded-lg text-[10px] font-black text-slate-700">Orange Cash</span>
                        <span class="px-2.5 py-1 bg-white border border-slate-200 shadow-2xs rounded-lg text-[10px] font-black text-slate-700">WE Pay</span>
                        <span class="px-2.5 py-1 bg-emerald-50 border border-emerald-200 shadow-2xs rounded-lg text-[10px] font-black text-emerald-700">الدفع عند الاستلام</span>
                    </div>
                </div>

            </div>
        </footer>

        <!-- Mobile Sticky Bottom Navigation Bar (شريط الملاحة السفلي الذكي للموبايل) -->
        <div class="fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-lg border-t border-slate-200/90 py-1.5 px-3 z-50 md:hidden shadow-lg" style="padding-bottom: max(0.4rem, env(safe-area-inset-bottom));">
            <div class="flex items-center justify-around">
                
                <!-- 1. Booking (حجز استشارة) -->
                <a href="{{ route('booking.index') }}" class="flex flex-col items-center gap-0.5 text-[10px] font-bold transition-colors {{ request()->routeIs('booking.index') ? 'text-[#2563ea]' : 'text-slate-500 hover:text-[#2563ea]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('booking.index') ? '2.2' : '1.8' }}" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span> استشارة</span>
                </a>

                <!-- 2. Categories / Catalog (الأقسام) -->
                <a href="{{ route('search') }}" class="flex flex-col items-center gap-0.5 text-[10px] font-bold transition-colors {{ request()->routeIs('search') ? 'text-[#2563ea]' : 'text-slate-500 hover:text-[#2563ea]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('search') ? '2.2' : '1.8' }}" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span>الأقسام</span>
                </a>

                <!-- 3. Home Highlight Center Button (الرئيسية باللون #2563ea) -->
                <a href="{{ route('home') }}" class="flex flex-col items-center -mt-4 group">
                    <div class="w-11 h-11 rounded-full text-white flex items-center justify-center shadow-lg shadow-blue-600/35 border-2 border-white transform group-hover:scale-105 transition-transform"
                         style="background-color: #2563ea !important;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <span class="text-[9px] font-black text-[#2563ea] mt-0.5">الرئيسية</span>
                </a>

                <!-- 4. Search Trigger (بحث) -->
                <button @click="searchOpen = !searchOpen" class="flex flex-col items-center gap-0.5 text-[10px] font-bold text-slate-500 hover:text-[#2563ea] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span>بحث</span>
                </button>

                <!-- 5. Cart with Live Badge (السلة) -->
                <button @click="cartOpen = true" class="flex flex-col items-center gap-0.5 text-[10px] font-bold text-slate-500 hover:text-[#2563ea] transition-colors relative">
                    <div class="relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span class="absolute -top-1.5 -left-2 min-w-[16px] h-4 px-1 bg-[#EF4444] text-white text-[9px] font-black rounded-full flex items-center justify-center shadow-xs border border-white">
                            {{ $cartCount }}
                        </span>
                    </div>
                    <span>السلة</span>
                </button>

            </div>
        </div>

        <!-- Floating WhatsApp Live Chat Widget -->
        @php
            $floatingWaNumber = \App\Models\Setting::get('store_whatsapp', '201550504512');
            $floatingSupervisor = \App\Models\Setting::get('supervisor_name', 'أ. هبة الله أكرم');
        @endphp
        <div class="fixed bottom-20 md:bottom-6 left-5 z-40" x-data="{ waOpen: false }" @click.away="waOpen = false">
            
            <!-- WhatsApp Chat Popup Card -->
            <div x-show="waOpen" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                 class="absolute bottom-16 left-0 w-72 sm:w-80 bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden text-right mb-2">
                
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-[#128C7E] to-[#25D366] p-4 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="relative">
                                <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-xs flex items-center justify-center text-white font-black text-sm border border-white/30">
                                    2M
                                </div>
                                <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-400 border-2 border-white rounded-full"></span>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-white leading-tight">مركز 2morro</h4>
                                <span class="text-[10px] text-white/90 font-medium flex items-center gap-1">
                                    <span>متصل الآن</span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                                </span>
                            </div>
                        </div>
                        <button @click="waOpen = false" class="text-white/80 hover:text-white p-1 text-sm font-bold">✕</button>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-4 bg-slate-50 space-y-3">
                    <div class="bg-white p-3 rounded-2xl rounded-tr-none shadow-xs border border-slate-100 text-xs text-slate-700 leading-relaxed font-semibold">
                        مرحباً بك في مركز 2morro! 👋
                        <br>
                        هل لديك استفسار عن الاستشارات، الجلسات، أو الأدوات والشيتات التعليمية؟ فريقنا يسعد بمساعدتك الآن.
                    </div>

                    <a href="https://wa.me/{{ $floatingWaNumber }}?text={{ urlencode('مرحباً مركز 2morro، أود الاستفسار عن الخدمات المتاحة.') }}" 
                       target="_blank" 
                       class="w-full bg-[#25D366] hover:bg-[#1EBE5D] text-white font-bold text-xs py-3 px-4 rounded-xl flex items-center justify-center gap-2 shadow-sm transition-all hover:scale-[1.02] active:scale-95">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.458L0 24zm6.002-3.693c1.615.957 3.178 1.462 4.736 1.463 5.485.002 9.948-4.463 9.95-9.953.001-2.66-1.025-5.16-2.887-7.026C16.001 2.923 13.506 1.897 10.85 1.897c-5.486 0-9.949 4.464-9.953 9.954-.001 2.052.541 4.06 1.567 5.814l-1.026 3.75 3.829-1.004z"></path></svg>
                        <span>بدء المحادثة على واتساب</span>
                    </a>
                </div>
            </div>

            <!-- Main Pulsating WhatsApp Floating Button -->
            <button @click="waOpen = !waOpen" 
                    title="تحدث معنا على واتساب" 
                    class="relative w-13 h-13 sm:w-14 sm:h-14 rounded-full bg-[#25D366] hover:bg-[#20bd5a] text-white flex items-center justify-center shadow-lg shadow-emerald-500/30 hover:scale-105 active:scale-95 transition-all group">
                
                <!-- Pulse animation ring -->
                <span class="absolute inset-0 rounded-full bg-[#25D366] opacity-40 animate-ping pointer-events-none"></span>

                <!-- WhatsApp SVG Icon -->
                <svg class="w-7 h-7 sm:w-8 sm:h-8 fill-current relative z-10 transition-transform group-hover:rotate-6" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.458L0 24zm6.002-3.693c1.615.957 3.178 1.462 4.736 1.463 5.485.002 9.948-4.463 9.95-9.953.001-2.66-1.025-5.16-2.887-7.026C16.001 2.923 13.506 1.897 10.85 1.897c-5.486 0-9.949 4.464-9.953 9.954-.001 2.052.541 4.06 1.567 5.814l-1.026 3.75 3.829-1.004z"/>
                </svg>

                <!-- Active status badge -->
                <span class="absolute top-1 right-1 w-3.5 h-3.5 bg-emerald-400 border-2 border-white rounded-full z-20"></span>
            </button>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const lazyImages = document.querySelectorAll('img');
                lazyImages.forEach(img => {
                    if (!img.getAttribute('loading')) {
                        img.setAttribute('loading', 'lazy');
                    }
                    if (!img.getAttribute('decoding')) {
                        img.setAttribute('decoding', 'async');
                    }
                    if (img.complete) {
                        img.classList.add('img-lazy-loaded');
                    } else {
                        img.classList.add('img-lazy-loading');
                        img.addEventListener('load', () => {
                            img.classList.remove('img-lazy-loading');
                            img.classList.add('img-lazy-loaded');
                        });
                    }
                });
            });
        </script>
    </body>
</html>

