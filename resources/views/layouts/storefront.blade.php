<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', '2morro | أدوات تعليمية تنمي مهارات طفلك')</title>

        <!-- Google Fonts: Cairo -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Tailwind CSS & Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
            body {
                font-family: 'Cairo', sans-serif;
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

        <!-- Top Notification Banner -->
        <div class="bg-[#102A63] text-white text-[11px] font-bold py-1.5 px-4 text-center">
            <span>🎉 الشحن مجاني لكافة الطلبات فوق 500 جنيه | خصم 30% على الباقات التعليمية هذا الأسبوع</span>
        </div>

        <!-- Sleek Minimalist Wokiee-Style Header Container -->
        <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-2xs transition-all">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2.5">
                
                <!-- Main Header Row: Logo Centered + Minimalist Action Icons -->
                <div class="flex items-center justify-between relative min-h-[56px]">
                    
                    <!-- Left End / Right End depending on RTL: Mobile Menu Toggle or Left Spacer -->
                    <div class="flex items-center gap-3 w-1/3">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>

                        <div class="hidden sm:flex items-center gap-3 text-xs font-bold text-slate-500">
                            <a href="tel:01012345678" class="hover:text-blue-600 flex items-center gap-1.5" dir="ltr">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span>010 1234 5678</span>
                            </a>
                        </div>
                    </div>

                    <!-- Center: 2morro Official Logo (Double Size) -->
                    <div class="flex items-center justify-center flex-1">
                        <a href="{{ route('home') }}" class="inline-flex items-center transition-transform hover:scale-105 py-1">
                            <img src="{{ asset($storeLogo) }}?v={{ $logoVersion }}" alt="2morro" style="max-height: 96px; height: 86px; width: auto; object-fit: contain;" class="h-16 sm:h-20 md:h-22 w-auto object-contain">
                        </a>
                    </div>

                    <!-- Action Icons (Minimalist: Search, Cart, User, Wishlist) -->
                    <div class="flex items-center justify-end gap-3 sm:gap-4 w-1/3">
                        
                        <!-- 1. Search Icon Trigger -->
                        <button @click="searchOpen = !searchOpen" title="بحث" class="p-2 rounded-full text-slate-700 hover:text-blue-600 hover:bg-slate-100 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>

                        <!-- 2. Cart Icon Trigger with Badge -->
                        <button @click="cartOpen = true" title="السلة" class="p-2 rounded-full text-slate-700 hover:text-blue-600 hover:bg-slate-100 transition-colors relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            <span class="absolute top-1 right-1 bg-[#EF4444] text-white text-[9px] font-black w-4 h-4 rounded-full flex items-center justify-center shadow-xs">
                                {{ $cartCount > 0 ? $cartCount : 3 }}
                            </span>
                        </button>

                        <!-- 3. User Account Icon -->
                        @if(Auth::check())
                            <a href="{{ route('dashboard') }}" title="حسابي" class="p-2 rounded-full text-blue-600 hover:bg-blue-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" title="تسجيل الدخول" class="p-2 rounded-full text-slate-700 hover:text-blue-600 hover:bg-slate-100 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </a>
                        @endif

                        <!-- 4. Filter / Deals / Wishlist Icon -->
                        <a href="{{ route('search', ['category' => 'educational-bundles']) }}" title="العروض والباقات" class="hidden sm:inline-flex p-2 rounded-full text-slate-700 hover:text-blue-600 hover:bg-slate-100 transition-colors relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-[#EF4444]"></span>
                        </a>

                    </div>

                </div>

                <!-- Centered Navigation Bar Links (Wokiee Style) -->
                <nav class="hidden lg:flex items-center justify-center gap-7 sm:gap-9 text-[13px] font-bold text-slate-700 pt-3 pb-1 border-t border-slate-100/80 mt-2">
                    
                    <a href="{{ route('home') }}" class="relative py-1 text-[#2563EB] font-black group">
                        <span>الرئيسية</span>
                        <span class="absolute bottom-0 inset-x-0 h-0.5 bg-[#2563EB] rounded-full"></span>
                    </a>

                    <a href="{{ route('search', ['category' => 'educational-tools']) }}" class="py-1 hover:text-[#2563EB] transition-colors whitespace-nowrap">
                        الأدوات التعليمية
                    </a>

                    <a href="{{ route('search', ['category' => 'digital-worksheets']) }}" class="py-1 hover:text-[#2563EB] transition-colors whitespace-nowrap">
                        الشيتات التعليمية
                    </a>

                    <a href="{{ route('search', ['category' => 'courses']) }}" class="py-1 hover:text-[#2563EB] transition-colors whitespace-nowrap">
                        الكورسات والبرامج
                    </a>

                    <a href="{{ route('search', ['category' => 'educational-bundles']) }}" class="py-1 hover:text-[#2563EB] transition-colors whitespace-nowrap">
                        الباقات والعروض
                    </a>

                    <a href="{{ route('search') }}" class="py-1 hover:text-[#2563EB] transition-colors whitespace-nowrap">
                        حسب المهارة
                    </a>

                    <a href="{{ route('search') }}" class="py-1 hover:text-[#2563EB] transition-colors whitespace-nowrap">
                        حسب العمر
                    </a>

                </nav>

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
                 class="border-t border-slate-100 bg-white/98 backdrop-blur-lg py-4 px-4 sm:px-8 shadow-md">
                <div class="max-w-3xl mx-auto flex items-center gap-3">
                    <form action="{{ route('search') }}" method="GET" class="flex-1 relative flex items-center bg-[#F8FAFC] border border-slate-200 focus-within:border-blue-600 focus-within:ring-2 focus-within:ring-blue-100 rounded-full h-12 px-4">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="ابحث عن منتج، شيت رقمي، أو مهارة مستهدفة..." class="w-full bg-transparent border-0 text-sm font-semibold focus:ring-0 text-slate-800 placeholder-slate-400 px-2">
                        <button type="submit" class="text-[#2563EB] font-bold text-xs bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-full transition-colors">بحث</button>
                    </form>
                    <button @click="searchOpen = false" class="p-2 text-slate-400 hover:text-slate-600 text-lg font-bold">✕</button>
                </div>
            </div>

            <!-- Mobile Navigation Drawer -->
            <div x-show="mobileMenuOpen" 
                 x-cloak
                 class="lg:hidden border-t border-slate-100 bg-white px-4 py-4 space-y-3 shadow-lg">
                <a href="{{ route('home') }}" class="block text-sm font-black text-blue-600 py-2 border-b border-slate-50">الرئيسية</a>
                <a href="{{ route('search', ['category' => 'educational-tools']) }}" class="block text-sm font-bold text-slate-700 py-2 border-b border-slate-50">الأدوات التعليمية</a>
                <a href="{{ route('search', ['category' => 'digital-worksheets']) }}" class="block text-sm font-bold text-slate-700 py-2 border-b border-slate-50">الشيتات التعليمية</a>
                <a href="{{ route('search', ['category' => 'courses']) }}" class="block text-sm font-bold text-slate-700 py-2 border-b border-slate-50">الكورسات والبرامج</a>
                <a href="{{ route('search', ['category' => 'educational-bundles']) }}" class="block text-sm font-bold text-slate-700 py-2 border-b border-slate-50">الباقات والعروض</a>
                <a href="{{ route('search') }}" class="block text-sm font-bold text-slate-700 py-2">حسب المهارة والعمر</a>
            </div>

        </header>

        <!-- Main Content Area -->
        <main class="flex-grow">
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
                                🛒 سلة المشتريات
                            </h3>
                            <button @click="cartOpen = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">×</button>
                        </div>

                        <div class="flex-grow overflow-y-auto p-5 flex flex-col gap-4">
                            @if(empty($cart))
                                <div class="flex flex-col items-center justify-center gap-4 text-center my-auto">
                                    <span class="text-4xl">🛍️</span>
                                    <h4 class="text-xs font-bold text-slate-600">السلة فارغة حالياً</h4>
                                    <p class="text-[10px] text-slate-400 max-w-xs">تصفح الأدوات التعليمية والشيتات وأضفها إلى سلتك لبدء التعلم.</p>
                                    <button @click="cartOpen = false" class="bg-[#102A63] text-white text-xs font-bold py-2 px-6 rounded-full mt-2">تصفح المنتجات</button>
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
                                    <a href="{{ route('checkout.index') }}" class="w-full bg-[#102A63] hover:bg-slate-800 text-white font-bold text-xs py-2 rounded-xl text-center flex items-center justify-center transition-colors">إتمام الشراء</a>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        <!-- Premium Modern Footer -->
        <footer class="bg-white border-t border-slate-200 mt-20 pt-16 pb-8 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                
                <!-- Trust Bar in Footer -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pb-12 border-b border-slate-100 text-right">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-blue-50 text-[#2563EB] flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-black text-slate-800">شحن سريع</span>
                            <span class="text-[10px] text-slate-500 font-semibold">توصيل لكافة المحافظات</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-teal-50 text-[#14B8A6] flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-black text-slate-800">جودة وتوصية معتمدة</span>
                            <span class="text-[10px] text-slate-500 font-semibold">بإشراف نخبة أخصائيين</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-amber-50 text-[#F59E0B] flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-black text-slate-800">استرجاع سهل</span>
                            <span class="text-[10px] text-slate-500 font-semibold">خلال 14 يوماً من الاستلام</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-purple-50 text-[#8B5CF6] flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-black text-slate-800">دفع آمن وسهل</span>
                            <span class="text-[10px] text-slate-500 font-semibold">انستاباي، كاش، ومحافظ</span>
                        </div>
                    </div>
                </div>

                <!-- Main Footer Columns -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 py-12 text-right">
                    
                    <!-- Col 1: Brand Info & Socials (4 cols) -->
                    <div class="md:col-span-4 flex flex-col gap-4">
                        <img src="{{ asset($storeLogo) }}?v={{ $logoVersion }}" alt="2morro" style="max-height: 70px; width: auto; object-fit: contain;" class="h-16 w-auto object-contain self-start">
                        <p class="text-xs text-slate-500 font-semibold leading-relaxed max-w-sm">
                            منصة 2morro متخصصة في توفير أفضل الأدوات والوسائل التعليمية والشيتات الرقمية لتنمية مهارات طفلك الذهنية والحركية واللغوية بأسلوب تفاعلي ممتع ومدروس.
                        </p>
                        
                        <div class="flex items-center gap-2.5 mt-2">
                            <!-- WhatsApp -->
                            <a href="https://wa.me/201012345678" target="_blank" class="w-8 h-8 rounded-full bg-green-50 text-green-600 hover:bg-green-600 hover:text-white flex items-center justify-center transition-all shadow-xs">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.458L0 24zm6.002-3.693c1.615.957 3.178 1.462 4.736 1.463 5.485.002 9.948-4.463 9.95-9.953.001-2.66-1.025-5.16-2.887-7.026C16.001 2.923 13.506 1.897 10.85 1.897c-5.486 0-9.949 4.464-9.953 9.954-.001 2.052.541 4.06 1.567 5.814l-1.026 3.75 3.829-1.004z"></path></svg>
                            </a>
                            <!-- Facebook -->
                            <a href="#" class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-all shadow-xs">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M9 8H7v3h2v9h3v-9h3.6L15 8h-3V6.5C12 5.67 12.5 5 13.5 5H15V2h-2.5C9.5 2 9 3.5 9 5.5V8z"></path></svg>
                            </a>
                            <!-- Instagram -->
                            <a href="#" class="w-8 h-8 rounded-full bg-pink-50 text-pink-600 hover:bg-pink-600 hover:text-white flex items-center justify-center transition-all shadow-xs">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"></path></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Col 2: Categories (3 cols) -->
                    <div class="md:col-span-3 flex flex-col gap-3">
                        <h5 class="text-xs font-black text-[#102A63]">الأقسام والمنتجات</h5>
                        <ul class="text-xs space-y-2 text-slate-500 font-semibold">
                            <li><a href="{{ route('search', ['category' => 'educational-tools']) }}" class="hover:text-blue-600 transition-colors">الأدوات التعليمية المادية</a></li>
                            <li><a href="{{ route('search', ['category' => 'digital-worksheets']) }}" class="hover:text-blue-600 transition-colors">شيتات وأوراق عمل PDF</a></li>
                            <li><a href="{{ route('search', ['category' => 'educational-bundles']) }}" class="hover:text-blue-600 transition-colors">باقات وعروض التوفير</a></li>
                            <li><a href="{{ route('search', ['category' => 'courses']) }}" class="hover:text-blue-600 transition-colors">الكورسات والبرامج المسجلة</a></li>
                        </ul>
                    </div>

                    <!-- Col 3: Shop By Need (3 cols) -->
                    <div class="md:col-span-3 flex flex-col gap-3">
                        <h5 class="text-xs font-black text-[#102A63]">تسوق حسب احتياج طفلك</h5>
                        <ul class="text-xs space-y-2 text-slate-500 font-semibold">
                            <li><a href="{{ route('search', ['need' => 'speech-delay']) }}" class="hover:text-blue-600 transition-colors">تأخر الكلام والنطق</a></li>
                            <li><a href="{{ route('search', ['need' => 'autism']) }}" class="hover:text-blue-600 transition-colors">دعم أطفال التوحد</a></li>
                            <li><a href="{{ route('search', ['need' => 'adhd']) }}" class="hover:text-blue-600 transition-colors">فرط الحركة وتشتت الانتباه</a></li>
                            <li><a href="{{ route('search', ['skill' => 'learning-difficulties']) }}" class="hover:text-blue-600 transition-colors">صعوبات التعلم والتأسيس</a></li>
                        </ul>
                    </div>

                    <!-- Col 4: Contact & Help (2 cols) -->
                    <div class="md:col-span-2 flex flex-col gap-3">
                        <h5 class="text-xs font-black text-[#102A63]">خدمة العملاء</h5>
                        <ul class="text-xs space-y-2 text-slate-500 font-semibold">
                            <li><span dir="ltr" class="font-bold text-slate-700">010 1234 5678</span></li>
                            <li><a href="mailto:info@2morro.com" class="hover:text-blue-600">info@2morro.com</a></li>
                            <li><a href="{{ route('search') }}" class="hover:text-blue-600">الشحن والتوصيل</a></li>
                            <li><a href="{{ route('search') }}" class="hover:text-blue-600">الاسترجاع والاستبدال</a></li>
                        </ul>
                    </div>

                </div>

                <!-- Copyright & Payment Methods -->
                <div class="pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500 font-semibold">
                    <p>جميع الحقوق محفوظة &copy; {{ date('Y') }} منصة 2morro التعليمية.</p>
                    
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-1 bg-[#F8FAFC] border border-slate-200 rounded-lg text-[10px] font-bold text-slate-600 shadow-2xs">InstaPay</span>
                        <span class="px-2.5 py-1 bg-[#F8FAFC] border border-slate-200 rounded-lg text-[10px] font-bold text-slate-600 shadow-2xs">Vodafone Cash</span>
                        <span class="px-2.5 py-1 bg-[#F8FAFC] border border-slate-200 rounded-lg text-[10px] font-bold text-slate-600 shadow-2xs">الدفع عند الاستلام (COD)</span>
                    </div>
                </div>

            </div>
        </footer>

    </body>
</html>
