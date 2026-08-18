@extends('layouts.storefront')

@section('title', 'إنشاء حساب جديد | 2morro')

@section('content')
@php
    $authVideoUrl = \App\Models\Setting::get('auth_video_url', 'https://www.youtube.com/embed/dQw4w9WgXcQ');
    $authBannerTitle = \App\Models\Setting::get('auth_banner_title', 'انضم إلى عائلة تمورو التعليمية ✨');
    $authBannerSubtitle = \App\Models\Setting::get('auth_banner_subtitle', 'نوفر لطفلك أفضل بيئة تفاعلية لتطوير قدراته واكتشاف مهاراته خطوة بخطوة.');
@endphp

<div class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
    <div class="bg-white rounded-[32px] border border-slate-100 shadow-soft overflow-hidden grid grid-cols-1 lg:grid-cols-12 gap-0">
        
        <!-- 1. Form Side (Right in RTL, 6 cols) -->
        <div class="lg:col-span-6 xl:col-span-6 p-8 sm:p-12 flex flex-col justify-between text-right"
             x-data="{ showPassword: false, showConfirmPassword: false }">
            
            <div>
                <!-- Friendly Header -->
                <div class="mb-8">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-blue-50 text-[#2563EB] mb-3">
                        <span>🚀</span>
                        <span>حساب جديد في دقائق</span>
                    </span>
                    
                    <h1 class="text-2xl sm:text-3xl font-black text-[#102A63] leading-tight">
                        إنشاء حساب جديد مجاناً 🎉
                    </h1>
                    
                    <p class="text-xs sm:text-sm text-slate-500 font-semibold mt-2">
                        انضم إلينا الآن للوصول إلى مئات الشيتات التعليمية وباقات التوفير الحصرية.
                    </p>
                </div>

                <!-- Validation Errors Alert -->
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-xs font-bold">
                        <div class="flex items-center gap-2 mb-1 text-red-800 font-black">
                            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>يرجى مراجعة الأخطاء التالية:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-1 mr-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-xs font-black text-slate-700 mb-1.5">
                            الاسم الكامل <span class="text-red-500">*</span>
                        </label>
                        <div class="relative flex items-center">
                            <div class="absolute right-3.5 text-slate-400 pointer-events-none">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input id="name" 
                                   type="text" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus 
                                   placeholder="أحمد محمد"
                                   class="w-full bg-[#F8FAFC] border border-slate-200 focus:border-[#2563EB] focus:ring-4 focus:ring-blue-100 rounded-2xl py-3 pr-11 pl-4 text-xs font-bold text-slate-800 transition-all">
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-xs font-black text-slate-700 mb-1.5">
                            البريد الإلكتروني <span class="text-red-500">*</span>
                        </label>
                        <div class="relative flex items-center">
                            <div class="absolute right-3.5 text-slate-400 pointer-events-none">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                            </div>
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   placeholder="example@gmail.com"
                                   class="w-full bg-[#F8FAFC] border border-slate-200 focus:border-[#2563EB] focus:ring-4 focus:ring-blue-100 rounded-2xl py-3 pr-11 pl-4 text-xs font-bold text-slate-800 transition-all text-start"
                                   dir="ltr">
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-xs font-black text-slate-700 mb-1.5">
                            كلمة المرور <span class="text-red-500">*</span>
                        </label>
                        <div class="relative flex items-center">
                            <div class="absolute right-3.5 text-slate-400 pointer-events-none">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" 
                                   :type="showPassword ? 'text' : 'password'" 
                                   name="password" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="••••••••"
                                   class="w-full bg-[#F8FAFC] border border-slate-200 focus:border-[#2563EB] focus:ring-4 focus:ring-blue-100 rounded-2xl py-3 pr-11 pl-11 text-xs font-bold text-slate-800 transition-all text-start"
                                   dir="ltr">
                            
                            <button type="button" 
                                    @click="showPassword = !showPassword" 
                                    class="absolute left-3.5 text-slate-400 hover:text-slate-600 focus:outline-hidden">
                                <svg x-show="!showPassword" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg x-show="showPassword" x-cloak class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-black text-slate-700 mb-1.5">
                            تأكيد كلمة المرور <span class="text-red-500">*</span>
                        </label>
                        <div class="relative flex items-center">
                            <div class="absolute right-3.5 text-slate-400 pointer-events-none">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <input id="password_confirmation" 
                                   :type="showConfirmPassword ? 'text' : 'password'" 
                                   name="password_confirmation" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="••••••••"
                                   class="w-full bg-[#F8FAFC] border border-slate-200 focus:border-[#2563EB] focus:ring-4 focus:ring-blue-100 rounded-2xl py-3 pr-11 pl-11 text-xs font-bold text-slate-800 transition-all text-start"
                                   dir="ltr">
                            
                            <button type="button" 
                                    @click="showConfirmPassword = !showConfirmPassword" 
                                    class="absolute left-3.5 text-slate-400 hover:text-slate-600 focus:outline-hidden">
                                <svg x-show="!showConfirmPassword" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg x-show="showConfirmPassword" x-cloak class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-3">
                        <button type="submit" class="w-full bg-[#102A63] hover:bg-slate-800 text-white font-black text-xs sm:text-sm py-3.5 px-6 rounded-2xl flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition-all group">
                            <span>إنشاء الحساب وبدء التعلم</span>
                            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer Link: Switch to Login -->
            <div class="pt-8 mt-6 border-t border-slate-100 text-center">
                <p class="text-xs font-bold text-slate-500">
                    لديك حساب بالفعل في تمورو؟
                    <a href="{{ route('login') }}" class="text-[#2563EB] hover:text-blue-700 font-black mr-1 underline">
                        تسجيل الدخول هنا ←
                    </a>
                </p>
            </div>

        </div>

        <!-- 2. Dynamic Video & Showcase Side (Left in RTL, 6 cols) -->
        <div class="lg:col-span-6 xl:col-span-6 bg-gradient-to-br from-[#102A63] via-[#1E40AF] to-[#2563EB] text-white p-8 sm:p-12 flex flex-col justify-between relative overflow-hidden text-right min-h-[480px]">
            
            <!-- Glassmorphic Background Accents -->
            <div class="absolute -top-12 -left-12 w-48 h-48 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
            <div class="absolute -bottom-12 -right-12 w-48 h-48 rounded-full bg-red-400/20 blur-xl pointer-events-none"></div>

            <div class="relative z-10">
                <!-- Top Brand Badge -->
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 px-3.5 py-1.5 rounded-full text-xs font-bold text-white mb-4">
                    <span>🎬</span>
                    <span>تعرف على تجربة تمورو</span>
                </div>

                <h2 class="text-xl sm:text-2xl font-black text-white leading-snug">
                    {{ $authBannerTitle }}
                </h2>
                
                <p class="text-xs text-blue-100 font-semibold mt-2 leading-relaxed">
                    {{ $authBannerSubtitle }}
                </p>

                <!-- Responsive Embedded YouTube Video Container -->
                <div class="aspect-video w-full rounded-2xl overflow-hidden shadow-2xl border-2 border-white/20 bg-slate-900/60 my-6 relative group">
                    <iframe class="w-full h-full" 
                            src="{{ $authVideoUrl }}" 
                            title="فيديو تعريفي بمتجر تمورو" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            referrerpolicy="strict-origin-when-cross-origin" 
                            allowfullscreen>
                    </iframe>
                </div>
            </div>

            <!-- Value Highlights Bullet Points -->
            <div class="relative z-10 space-y-2.5 pt-2 border-t border-white/15">
                <div class="flex items-center gap-2.5 text-xs font-bold text-white/90">
                    <span class="w-5 h-5 rounded-full bg-green-400/20 text-green-300 flex items-center justify-center flex-shrink-0 text-[10px]">✓</span>
                    <span>تحميل فوري لمئات الشيتات التعليمية والأنشطة التأسيسية.</span>
                </div>
                <div class="flex items-center gap-2.5 text-xs font-bold text-white/90">
                    <span class="w-5 h-5 rounded-full bg-green-400/20 text-green-300 flex items-center justify-center flex-shrink-0 text-[10px]">✓</span>
                    <span>أدوات ووسائل تنمية مهارات موصى بها من قبل نخبة أخصائيين.</span>
                </div>
                <div class="flex items-center gap-2.5 text-xs font-bold text-white/90">
                    <span class="w-5 h-5 rounded-full bg-green-400/20 text-green-300 flex items-center justify-center flex-shrink-0 text-[10px]">✓</span>
                    <span>متابعة الشحن والتوصيل لكافة المحافظات خطوة بخطوة.</span>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
