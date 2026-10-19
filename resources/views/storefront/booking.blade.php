@extends('layouts.storefront')

@section('title', $bookingTitle . ' | مركز 2morro')

@section('content')
<div class="bg-[#F8FAFC] min-h-screen py-6 sm:py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center gap-2 text-xs font-bold text-slate-500 mb-4 justify-center sm:justify-start">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">الرئيسية</a>
            <svg class="w-3 h-3 text-slate-400 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-slate-800 font-black">حجز استشارة وتقييم</span>
        </nav>

        <!-- Compact Header -->
        <div class="mb-6 text-center max-w-xl mx-auto">
            <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-[10px] sm:text-[11px] font-black bg-blue-50 text-blue-700 border border-blue-200 mb-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                <span>مركز 2morro للتأهيل وتنمية المهارات</span>
            </span>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                طلب حجز استشارة وتقييم مهارات الطفل
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-1">
                املأ البيانات في خطوتين سريعتين لتأكيد الموعد المناسب
            </p>
        </div>

        <!-- 2-Column Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
            
            <!-- Sidebar: Compact Supervisor & Center Info (4 Cols) -->
            <div class="lg:col-span-4 order-2 lg:order-1">
                <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs lg:sticky lg:top-24 space-y-4 text-right">
                    
                    <!-- Supervisor Header -->
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                        <div class="w-11 h-11 rounded-xl bg-blue-600 text-white flex items-center justify-center flex-shrink-0 shadow-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <span class="text-[10px] text-blue-600 font-bold block">إشراف وتوجيه متخصص</span>
                            <h3 class="font-black text-slate-900 text-sm">أ. هبة الله أكرم</h3>
                            <span class="text-[10px] text-slate-500 font-medium">تقييم وتأهيل مهارات وسلوك الأطفال</span>
                        </div>
                    </div>

                    <!-- Center Working Hours -->
                    <div class="flex items-center gap-2.5 p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                        <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-500 font-bold block">مواعيد العمل الرسمية:</span>
                            <span class="font-black text-slate-800 text-xs">من 12:00 ظهراً إلى 9:00 مساءً</span>
                        </div>
                    </div>

                    <!-- Direct WhatsApp Help Button -->
                    @php
                        $bookingWaRaw = \App\Models\Setting::get('store_whatsapp', '201550504512');
                        $bookingWaNum = preg_replace('/[^0-9]/', '', $bookingWaRaw) ?: '201550504512';
                    @endphp
                    <a href="https://wa.me/{{ $bookingWaNum }}" target="_blank" class="w-full py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black flex items-center justify-center gap-2 shadow-xs transition-all hover:scale-[1.01] active:scale-95">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.458L0 24zm6.002-3.693c1.615.957 3.178 1.462 4.736 1.463 5.485.002 9.948-4.463 9.95-9.953.001-2.66-1.025-5.16-2.887-7.026C16.001 2.923 13.506 1.897 10.85 1.897c-5.486 0-9.949 4.464-9.953 9.954-.001 2.052.541 4.06 1.567 5.814l-1.026 3.75 3.829-1.004z"></path></svg>
                        <span>مساعدة فورية عبر واتساب</span>
                    </a>

                </div>
            </div>

            <!-- Main Form Card (8 Cols) -->
            <div class="lg:col-span-8 order-1 lg:order-2">
                
                <!-- Stepper Progress Header -->
                <div class="bg-white rounded-2xl border border-slate-200/90 p-4 sm:p-5 shadow-xs mb-4">
                    <div class="flex items-center justify-between max-w-sm mx-auto relative px-6" dir="ltr">
                        <div class="absolute top-1/2 left-10 right-10 -translate-y-1/2 h-0.5 bg-slate-200 z-0"></div>
                        <div id="stepProgressFill" class="absolute top-1/2 left-10 -translate-y-1/2 h-0.5 bg-blue-600 transition-all duration-300 z-0" style="width: 0%;"></div>
                        
                        <!-- Step 1 Indicator -->
                        <div class="relative z-10 flex flex-col items-center cursor-pointer" onclick="goToStep(1)">
                            <div id="stepCircle1" class="w-8 h-8 rounded-full flex items-center justify-center font-black text-xs transition-all duration-300 bg-blue-600 text-white shadow-xs ring-4 ring-blue-100">
                                1
                            </div>
                            <span id="stepLabel1" class="text-[11px] font-black text-slate-800 mt-1">البيانات الأساسية</span>
                        </div>

                        <!-- Step 2 Indicator -->
                        <div class="relative z-10 flex flex-col items-center cursor-pointer" onclick="validateAndGoToStep(2)">
                            <div id="stepCircle2" class="w-8 h-8 rounded-full flex items-center justify-center font-black text-xs transition-all duration-300 bg-slate-100 text-slate-400 border border-slate-200">
                                2
                            </div>
                            <span id="stepLabel2" class="text-[11px] font-bold text-slate-400 mt-1">الموعد وتأكيد الدفع</span>
                        </div>
                    </div>
                </div>

                @if(isset($errors) && $errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-xs font-bold p-3.5 rounded-xl text-right">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- The Form -->
                <form id="bookingForm" action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-7 shadow-xs text-right">
                    @csrf

                    <!-- ============================================== -->
                    <!-- STEP 1: Child & Parent Information            -->
                    <!-- ============================================== -->
                    <div id="step1Content" class="space-y-4 transition-opacity duration-300">
                        
                        <div class="border-b border-slate-100 pb-2.5 mb-3 text-center sm:text-right">
                            <h2 class="text-sm sm:text-base font-black text-slate-900">1. بيانات الطفل وولي الأمر</h2>
                            <p class="text-[11px] text-slate-500 font-medium">أدخل البيانات الأساسية للطفل للتواصل وتجهيز ملف التقييم</p>
                        </div>

                        <!-- Child Name & Age -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label class="block text-xs font-black text-slate-700 mb-1">اسم الطفل بالكامل <span class="text-red-500">*</span></label>
                                <input type="text" name="child_name" id="child_name" value="{{ old('child_name') }}" required placeholder="اسم الطفل" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white">
                                <span id="child_name_error" class="text-red-500 text-[10px] font-bold hidden mt-0.5 block">يرجى إدخال اسم الطفل.</span>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-slate-700 mb-1">عمر الطفل <span class="text-red-500">*</span></label>
                                <input type="text" name="child_age" id="child_age" value="{{ old('child_age') }}" required placeholder="مثال: 4 سنوات و 6 أشهر" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white">
                                <span id="child_age_error" class="text-red-500 text-[10px] font-bold hidden mt-0.5 block">يرجى إدخال عمر الطفل.</span>
                            </div>
                        </div>

                        <!-- Parent Name & Phone -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label class="block text-xs font-black text-slate-700 mb-1">اسم ولي الأمر <span class="text-red-500">*</span></label>
                                <input type="text" name="parent_name" id="parent_name" value="{{ old('parent_name', auth()->user()?->name) }}" required placeholder="اسم ولي الأمر" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white">
                                <span id="parent_name_error" class="text-red-500 text-[10px] font-bold hidden mt-0.5 block">يرجى إدخال اسم ولي الأمر.</span>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-slate-700 mb-1">رقم الهاتف والواتساب <span class="text-red-500">*</span></label>
                                <input type="tel" name="parent_phone" id="parent_phone" value="{{ old('parent_phone', auth()->user()?->phone) }}" required placeholder="010xxxxxxxx" dir="ltr" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white text-right">
                                <span id="parent_phone_error" class="text-red-500 text-[10px] font-bold hidden mt-0.5 block">يرجى إدخال رقم الهاتف للتواصل.</span>
                            </div>
                        </div>

                        <!-- Email (Optional) -->
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">البريد الإلكتروني (اختياري)</label>
                            <input type="email" name="parent_email" id="parent_email" value="{{ old('parent_email', auth()->user()?->email) }}" placeholder="name@example.com" dir="ltr" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-xs font-medium text-slate-800 outline-none transition-all bg-white text-right">
                        </div>

                        <!-- Step 1 Button -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[11px] text-slate-400 font-medium">خطوة 1 من 2</span>
                            <button type="button" onclick="nextToStep2()" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-black flex items-center gap-2 shadow-xs transition-all hover:scale-[1.01] active:scale-95 cursor-pointer">
                                <span>التالي: الموعد والدفع</span>
                                <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>

                    </div>

                    <!-- ============================================== -->
                    <!-- STEP 2: Format, Branch, Schedule & Payment     -->
                    <!-- ============================================== -->
                    <div id="step2Content" class="space-y-4 hidden transition-opacity duration-300">
                        
                        <div class="border-b border-slate-100 pb-2.5 mb-3 text-center sm:text-right flex items-center justify-between">
                            <div>
                                <h2 class="text-sm sm:text-base font-black text-slate-900">2. طريقة المقابلة والموعد والدفع</h2>
                                <p class="text-[11px] text-slate-500 font-medium">حدد الفرع المناسب وموعد الحساب المعتمد</p>
                            </div>
                            <span id="headerPriceBadge" class="text-xs font-black text-blue-700 bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-100">
                                300 ج.م
                            </span>
                        </div>

                        <!-- 1. طريقة المقابلة (3 خيارات مدمجة ومضغوطة) -->
                        <div>
                            <label class="block text-xs font-black text-slate-700 mb-1.5">نوع وطريقة المقابلة <span class="text-red-500">*</span></label>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                
                                <!-- Normal In-Center -->
                                @if($bookingTypes['normal']['enabled'] ?? true)
                                <label class="relative flex flex-col p-2.5 sm:p-3 rounded-xl border-2 cursor-pointer transition-all format-card bg-white border-blue-600 ring-2 ring-blue-100 shadow-xs" id="formatCard_in_center_normal">
                                    <div class="flex items-center justify-between mb-1">
                                        <input type="radio" name="session_format" value="in_center_normal" checked onchange="handleFormatSelection(this.value)" class="text-blue-600 focus:ring-blue-600 w-3.5 h-3.5">
                                        <span class="text-[9px] font-black px-1.5 py-0.5 rounded bg-blue-50 text-blue-700">مجدول</span>
                                    </div>
                                    <span class="font-black text-xs text-slate-900 block">في المركز (عادي)</span>
                                    <span class="text-[10px] text-slate-500 block">{{ $bookingTypes['normal']['desc'] ?? 'حضور في الفرع' }}</span>
                                </label>
                                @endif

                                <!-- Urgent In-Center -->
                                @if($bookingTypes['urgent']['enabled'] ?? true)
                                <label class="relative flex flex-col p-2.5 sm:p-3 rounded-xl border-2 cursor-pointer transition-all format-card bg-white border-slate-200 hover:border-blue-300" id="formatCard_in_center_urgent">
                                    <div class="flex items-center justify-between mb-1">
                                        <input type="radio" name="session_format" value="in_center_urgent" onchange="handleFormatSelection(this.value)" class="text-blue-600 focus:ring-blue-600 w-3.5 h-3.5">
                                        <span class="text-[9px] font-black px-1.5 py-0.5 rounded bg-blue-600 text-white">مستعجل ⚡</span>
                                    </div>
                                    <span class="font-black text-xs text-slate-900 block">في المركز (مستعجل)</span>
                                    <span class="text-[10px] text-slate-500 block">+{{ number_format($bookingTypes['urgent']['fee'] ?? 150) }} ج.م {{ $bookingTypes['urgent']['desc'] ?? 'كشف عاجل' }}</span>
                                </label>
                                @endif

                                <!-- Online Remote -->
                                @if($bookingTypes['online']['enabled'] ?? true)
                                <label class="relative flex flex-col p-2.5 sm:p-3 rounded-xl border-2 cursor-pointer transition-all format-card bg-white border-slate-200 hover:border-blue-300" id="formatCard_online">
                                    <div class="flex items-center justify-between mb-1">
                                        <input type="radio" name="session_format" value="online" onchange="handleFormatSelection(this.value)" class="text-blue-600 focus:ring-blue-600 w-3.5 h-3.5">
                                        <span class="text-[9px] font-black px-1.5 py-0.5 rounded bg-slate-100 text-slate-700">عن بُعد 💻</span>
                                    </div>
                                    <span class="font-black text-xs text-slate-900 block">أونلاين (Zoom)</span>
                                    <span class="text-[10px] text-slate-500 block">{{ number_format($bookingTypes['online']['price'] ?? 350) }} ج.م - {{ $bookingTypes['online']['desc'] ?? 'مكالمة فيديو' }}</span>
                                </label>
                                @endif

                            </div>
                        </div>

                        <!-- 2. الفرع المفضل للمقابلة (مع تفاصيل الأيام والمواعيد من الداش بورد) -->
                        <div id="branchSelectionContainer" class="space-y-1.5 transition-all">
                            <label class="block text-xs font-black text-slate-700">فرع المركز المفضل <span class="text-red-500">*</span></label>
                            <select name="branch_id" id="branch_id" onchange="handleBranchChange()" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white">
                                @foreach($branchesList as $b)
                                    @if(!$b->is_online)
                                        <option value="{{ $b->id }}" 
                                            data-price="{{ $b->price }}"
                                            data-online="0"
                                            data-address="{{ $b->address }}"
                                            data-days="{{ json_encode($b->days_list) }}"
                                            data-slots="{{ json_encode($b->slots_list) }}"
                                            {{ old('branch_id') == $b->id ? 'selected' : '' }}>
                                            {{ $b->name }} {{ $b->address ? ' - ' . $b->address : '' }} ({{ number_format($b->price) }} ج.م)
                                        </option>
                                    @endif
                                @endforeach
                            </select>

                            <!-- Branch Days Badge Directly from Dashboard -->
                            <div class="flex items-center gap-1.5 text-[11px] text-slate-600 bg-slate-50 border border-slate-200/80 p-2 rounded-lg">
                                <span class="font-bold text-blue-700 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>أيام العمل بالفرع:</span>
                                </span>
                                <span id="branchDaysBadge" class="font-medium text-slate-700">السبت • الأحد • الاثنين • الثلاثاء • الأربعاء • الخميس</span>
                            </div>
                        </div>

                        <!-- Online Info Widget -->
                        <div id="onlineInfoWidget" class="hidden p-2.5 rounded-xl bg-blue-50/80 border border-blue-200 text-blue-900 text-xs flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            <span class="font-medium">جلسة أونلاين عبر Zoom مباشرة. سيصلكم الرابط وتفاصيل الجلسة عبر الواتساب فور التأكيد.</span>
                        </div>

                        <!-- 3. التقويم التفاعلي واختيار الموعد والساعة -->
                        <div class="space-y-4 pt-1">
                            
                            <!-- Calendar Container Card -->
                            <div class="p-3 sm:p-4 rounded-2xl bg-slate-50/80 border border-slate-200">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div>
                                            <label class="text-xs font-black text-slate-800 block">اختر اليوم من التقويم المعتمد <span class="text-red-500">*</span></label>
                                            <span class="text-[10px] text-slate-500 font-medium" id="calendarServiceLabel">الأيام المتاحة مضاءة باللون الأزرق</span>
                                        </div>
                                    </div>

                                    <!-- Month / Year Navigation Controls -->
                                    <div class="flex items-center gap-1.5 bg-white p-1 rounded-xl border border-slate-200 shadow-2xs">
                                        <button type="button" onclick="changeCalendarMonth(-1)" id="prevMonthBtn" class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-600 transition-colors cursor-pointer" title="الشهر السابق">
                                            <svg class="w-3.5 h-3.5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                        </button>
                                        <span id="calendarMonthTitle" class="text-xs font-black text-slate-800 px-2 min-w-[100px] text-center select-none">
                                            أكتوبر 2026
                                        </span>
                                        <button type="button" onclick="changeCalendarMonth(1)" id="nextMonthBtn" class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-600 transition-colors cursor-pointer" title="الشهر القادم">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Weekday Headers (Sat..Fri) -->
                                <div class="grid grid-cols-7 gap-1 text-center mb-1 text-[11px] font-black text-slate-500 pb-1 border-b border-slate-200">
                                    <span>السبت</span>
                                    <span>الأحد</span>
                                    <span>الاثنين</span>
                                    <span>الثلاثاء</span>
                                    <span>الأربعاء</span>
                                    <span>الخميس</span>
                                    <span>الجمعة</span>
                                </div>

                                <!-- Days Grid (populated via JS) -->
                                <div id="calendarDaysGrid" class="grid grid-cols-7 gap-1 sm:gap-1.5 text-center pt-1 min-h-[180px]">
                                    <!-- Dynamic Day Cells -->
                                </div>

                                <!-- Hidden Real Input for Form Submission -->
                                <input type="hidden" name="booking_date" id="booking_date" value="{{ old('booking_date') }}" required>

                                <!-- Picked Date Confirmation Bar -->
                                <div id="selectedDateBanner" class="mt-2.5 p-2 rounded-xl bg-blue-50 border border-blue-200 text-blue-900 text-xs flex items-center justify-between font-bold hidden">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <span>اليوم المختار:</span>
                                        <span id="selectedDateText" class="font-black text-blue-700"></span>
                                    </div>
                                    <span class="text-[10px] bg-blue-600 text-white px-2 py-0.5 rounded-md">مؤكد</span>
                                </div>
                                <span id="booking_date_error" class="text-red-500 text-[10px] font-bold hidden mt-1 block">يرجى اختيار يوم متاح من التقويم أعلاه.</span>
                            </div>

                            <!-- Time Slots Selection Section -->
                            <div id="timeSlotsContainer" class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label class="block text-xs font-black text-slate-700">الفترة الزمنية المفضلة <span class="text-red-500">*</span></label>
                                    <span id="slotsLoadingSpinner" class="text-[10px] text-blue-600 font-bold hidden items-center gap-1">
                                        <svg class="animate-spin w-3 h-3 text-blue-600" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                                        جاري فحص المواعيد الشاغرة...
                                    </span>
                                </div>

                                <!-- Hidden Real Input for Time -->
                                <input type="hidden" name="booking_time" id="booking_time" value="{{ old('booking_time') }}" required>

                                <!-- Slots Buttons Grid -->
                                <div id="slotsChipsGrid" class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                    <!-- Rendered dynamically -->
                                </div>

                                <div id="noSlotsMessage" class="hidden p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs text-center font-bold">
                                    يرجى اختيار يوم متاح من التقويم أولاً لعرض الفترات الزمنية المتاحة.
                                </div>
                                <span id="booking_time_error" class="text-red-500 text-[10px] font-bold hidden mt-0.5 block">يرجى اختيار فترة زمنية للمقابلة.</span>
                            </div>

                        </div>

                        <!-- 4. طرق الدفع المعتمدة وتأكيد الحجز (فودافون كاش وإنستاباي) -->
                        <div class="pt-3 border-t border-slate-100 space-y-2.5">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-black text-slate-800">طريقة التحويل وتأكيد الحجز <span class="text-red-500">*</span></label>
                                <span class="text-[10px] font-black text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">تأكيد فوري</span>
                            </div>

                            <!-- Compact Payment Options Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                
                                <!-- Vodafone Cash Option -->
                                @if(!empty($paymentSettings['vodafone_cash']))
                                    <label class="relative flex flex-col p-2.5 rounded-xl border-2 cursor-pointer transition-all payment-method-card bg-white border-blue-600 ring-2 ring-blue-100 shadow-xs" id="card_vodafone_cash">
                                        <div class="flex items-center justify-between mb-1">
                                            <div class="flex items-center gap-1.5">
                                                <input type="radio" name="payment_method" value="vodafone_cash" checked onchange="handlePaymentMethodChange(this.value)" class="text-blue-600 focus:ring-blue-600 w-3.5 h-3.5">
                                                <span class="font-black text-xs text-slate-900">فودافون كاش</span>
                                            </div>
                                            <button type="button" onclick="copyText('{{ $paymentSettings['vodafone_cash'] }}', this)" class="text-[9px] font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 px-2 py-0.5 rounded transition-colors">
                                                نسخ الرقم
                                            </button>
                                        </div>
                                        <span class="font-mono text-xs font-black text-slate-800" dir="ltr">{{ $paymentSettings['vodafone_cash'] }}</span>
                                    </label>
                                @endif

                                <!-- InstaPay Option -->
                                @if(!empty($paymentSettings['instapay']))
                                    <label class="relative flex flex-col p-2.5 rounded-xl border-2 cursor-pointer transition-all payment-method-card bg-white border-slate-200 hover:border-blue-400" id="card_instapay">
                                        <div class="flex items-center justify-between mb-1">
                                            <div class="flex items-center gap-1.5">
                                                <input type="radio" name="payment_method" value="instapay" {{ empty($paymentSettings['vodafone_cash']) ? 'checked' : '' }} onchange="handlePaymentMethodChange(this.value)" class="text-blue-600 focus:ring-blue-600 w-3.5 h-3.5">
                                                <span class="font-black text-xs text-slate-900">إنستاباي (InstaPay)</span>
                                            </div>
                                            <button type="button" onclick="copyText('{{ $paymentSettings['instapay'] }}', this)" class="text-[9px] font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 px-2 py-0.5 rounded transition-colors">
                                                نسخ المعرف
                                            </button>
                                        </div>
                                        <span class="font-mono text-xs font-black text-slate-800 truncate" dir="ltr">{{ $paymentSettings['instapay'] }}</span>
                                    </label>
                                @endif

                            </div>

                            <!-- Compact Receipt Upload Row -->
                            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2">
                                <div class="flex items-center justify-between gap-2 flex-wrap">
                                    <div>
                                        <span class="text-xs font-black text-slate-800 block">إشعار التحويل (سكرين شوت) <span class="text-red-500">*</span></span>
                                        <span class="text-[10px] text-slate-500 font-medium">حول القيمة ثم أرفق صورة إشعار التحويل</span>
                                    </div>
                                    <input type="file" name="payment_receipt" id="payment_receipt" accept="image/png, image/jpeg, image/jpg, image/webp" onchange="previewReceipt(this)" class="hidden">
                                    <button type="button" onclick="document.getElementById('payment_receipt').click()" class="px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold flex items-center gap-1.5 transition-colors cursor-pointer shadow-2xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        <span>اختر صورة الإشعار</span>
                                    </button>
                                </div>

                                <!-- Image Preview Container -->
                                <div id="uploadPreviewState" class="hidden flex items-center justify-between p-2 rounded-lg bg-white border border-blue-200">
                                    <div class="flex items-center gap-2">
                                        <img id="receiptPreviewImg" src="" alt="معاينة" class="w-10 h-10 object-cover rounded-md border border-slate-200">
                                        <span class="text-[11px] font-bold text-slate-700" id="receiptFileName">تم اختيار الصورة بنجاح</span>
                                    </div>
                                    <button type="button" onclick="removeReceipt()" class="text-xs text-red-600 hover:text-red-800 font-bold px-2 py-1">حذف</button>
                                </div>

                                <span id="receipt_error" class="text-red-500 text-[10px] font-bold hidden block">يرجى رفع صورة سكرين شوت إشعار التحويل لتأكيد الحجز.</span>
                            </div>

                            <!-- Optional Collapsible Details (Phone ref & Notes) -->
                            <details class="group text-xs pt-1">
                                <summary class="font-bold text-slate-500 hover:text-blue-600 cursor-pointer select-none flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 transition-transform group-open:rotate-90 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    <span>إضافة ملاحظات أو رقم العملية (اختياري)</span>
                                </summary>
                                <div class="mt-2.5 space-y-2 pr-4 border-r-2 border-slate-200">
                                    <div>
                                        <label class="block text-[11px] font-bold text-slate-600 mb-1">رقم الهاتف المحول منه أو رقم العملية</label>
                                        <input type="text" name="payment_reference" id="payment_reference" value="{{ old('payment_reference') }}" placeholder="مثال: رقم 010xxxxxxxx أو كود المعاملة" class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-medium text-slate-800 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold text-slate-600 mb-1">ملاحظات أو شكوى الطفل</label>
                                        <textarea name="notes" id="notes" rows="2" placeholder="أي تفاصيل تود إخبار الأخصائي بها (تأخر كلام، تشتت انتباه...)" class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-medium outline-none">{{ old('notes') }}</textarea>
                                    </div>
                                </div>
                            </details>

                        </div>

                        <!-- Step 2 Navigation Buttons -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-3">
                            <button type="button" onclick="goToStep(1)" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold flex items-center gap-1 transition-all cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                <span>السابق</span>
                            </button>

                            <button type="submit" id="submitBtn" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-black flex items-center gap-2 shadow-xs transition-all hover:scale-[1.01] active:scale-95 cursor-pointer">
                                <span id="submitBtnText">تأكيد وإرسال طلب الحجز (300 ج.م)</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>
</div>

<!-- Dynamic Branch & Dashboard Scheduling Script -->
<!-- Dynamic Branch & Dashboard Scheduling Script -->
<script>
    let currentStep = 1;
    const branchesData = @json($branchesList);
    const scheduleConfig = @json($scheduleConfig);
    const arabicMonths = ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
    const englishDayKeys = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const arabicDayNames = ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];

    // Interactive Calendar State
    let calCurrentDate = new Date();
    let calDisplayYear = calCurrentDate.getFullYear();
    let calDisplayMonth = calCurrentDate.getMonth(); // 0-11
    let selectedDateStr = document.getElementById('booking_date')?.value || '';
    let selectedTimeSlot = document.getElementById('booking_time')?.value || '';

    function validateStep1() {
        let valid = true;
        const childName = document.getElementById('child_name');
        const childAge = document.getElementById('child_age');
        const parentName = document.getElementById('parent_name');
        const parentPhone = document.getElementById('parent_phone');

        if (!childName.value.trim()) {
            document.getElementById('child_name_error').classList.remove('hidden');
            childName.classList.add('border-red-500');
            valid = false;
        } else {
            document.getElementById('child_name_error').classList.add('hidden');
            childName.classList.remove('border-red-500');
        }

        if (!childAge.value.trim()) {
            document.getElementById('child_age_error').classList.remove('hidden');
            childAge.classList.add('border-red-500');
            valid = false;
        } else {
            document.getElementById('child_age_error').classList.add('hidden');
            childAge.classList.remove('border-red-500');
        }

        if (!parentName.value.trim()) {
            document.getElementById('parent_name_error').classList.remove('hidden');
            parentName.classList.add('border-red-500');
            valid = false;
        } else {
            document.getElementById('parent_name_error').classList.add('hidden');
            parentName.classList.remove('border-red-500');
        }

        if (!parentPhone.value.trim()) {
            document.getElementById('parent_phone_error').classList.remove('hidden');
            parentPhone.classList.add('border-red-500');
            valid = false;
        } else {
            document.getElementById('parent_phone_error').classList.add('hidden');
            parentPhone.classList.remove('border-red-500');
        }

        return valid;
    }

    function nextToStep2() {
        if (validateStep1()) {
            goToStep(2);
        }
    }

    function validateAndGoToStep(targetStep) {
        if (targetStep === 2) {
            if (validateStep1()) {
                goToStep(2);
            }
        } else {
            goToStep(targetStep);
        }
    }

    function goToStep(step) {
        currentStep = step;
        const step1Content = document.getElementById('step1Content');
        const step2Content = document.getElementById('step2Content');
        const stepCircle1 = document.getElementById('stepCircle1');
        const stepCircle2 = document.getElementById('stepCircle2');
        const stepLabel1 = document.getElementById('stepLabel1');
        const stepLabel2 = document.getElementById('stepLabel2');
        const progressFill = document.getElementById('stepProgressFill');

        if (step === 1) {
            step1Content.classList.remove('hidden');
            step2Content.classList.add('hidden');

            stepCircle1.className = "w-8 h-8 rounded-full flex items-center justify-center font-black text-xs transition-all duration-300 bg-blue-600 text-white shadow-xs ring-4 ring-blue-100";
            stepLabel1.className = "text-[11px] font-black text-slate-800 mt-1";

            stepCircle2.className = "w-8 h-8 rounded-full flex items-center justify-center font-black text-xs transition-all duration-300 bg-slate-100 text-slate-400 border border-slate-200";
            stepLabel2.className = "text-[11px] font-bold text-slate-400 mt-1";

            progressFill.style.width = "0%";
        } else if (step === 2) {
            step1Content.classList.add('hidden');
            step2Content.classList.remove('hidden');

            stepCircle1.className = "w-8 h-8 rounded-full flex items-center justify-center font-black text-xs transition-all duration-300 bg-blue-600 text-white shadow-xs";
            stepLabel1.className = "text-[11px] font-bold text-slate-600 mt-1";

            stepCircle2.className = "w-8 h-8 rounded-full flex items-center justify-center font-black text-xs transition-all duration-300 bg-blue-600 text-white shadow-xs ring-4 ring-blue-100";
            stepLabel2.className = "text-[11px] font-black text-slate-800 mt-1";

            progressFill.style.width = "100%";

            // Re-render calendar when entering step 2
            renderCalendar();
        }
    }

    function getSelectedFormatKey() {
        const val = document.querySelector('input[name="session_format"]:checked')?.value || 'in_center_normal';
        if (val === 'in_center_urgent' || val === 'urgent') return 'urgent';
        if (val === 'online') return 'online';
        return 'normal';
    }

    function autoFocusCalendarToFirstAvailableDate() {
        const formatKey = getSelectedFormatKey();
        const branchSelect = document.getElementById('branch_id');
        const branchId = branchSelect?.value;
        const branch = branchesData.find(b => b.id == branchId);

        let targetDateStr = null;

        if (formatKey === 'urgent') {
            const uDates = (branch && branch.urgent_dates_list && branch.urgent_dates_list.length > 0) ? branch.urgent_dates_list : [];
            if (uDates.length > 0) {
                targetDateStr = uDates[0];
            }
        } else if (formatKey === 'normal') {
            const nDates = (branch && branch.specific_dates_list && branch.specific_dates_list.length > 0) ? branch.specific_dates_list : [];
            if (nDates.length > 0) {
                targetDateStr = nDates[0];
            }
        }

        if (targetDateStr) {
            const parts = targetDateStr.split('-');
            if (parts.length === 3) {
                calDisplayYear = parseInt(parts[0]);
                calDisplayMonth = parseInt(parts[1]) - 1;
            }
        }
    }

    // Handle Format Selection (in_center_normal, in_center_urgent, online)
    function handleFormatSelection(format) {
        document.querySelectorAll('.format-card').forEach(card => {
            card.classList.remove('border-blue-600', 'ring-2', 'ring-blue-100', 'shadow-xs');
            card.classList.add('border-slate-200');
        });

        const activeCard = document.getElementById('formatCard_' + format);
        if (activeCard) {
            activeCard.classList.add('border-blue-600', 'ring-2', 'ring-blue-100', 'shadow-xs');
            activeCard.classList.remove('border-slate-200');
        }

        const branchContainer = document.getElementById('branchSelectionContainer');
        const branchSelect = document.getElementById('branch_id');
        const onlineWidget = document.getElementById('onlineInfoWidget');
        const formatKey = getSelectedFormatKey();
        const conf = scheduleConfig[formatKey] || scheduleConfig['normal'];

        if (format === 'online') {
            if (branchContainer) branchContainer.classList.add('hidden');
            if (branchSelect) branchSelect.removeAttribute('required');
            if (onlineWidget) onlineWidget.classList.remove('hidden');
            updatePriceDisplay(conf.price);
        } else {
            if (branchContainer) branchContainer.classList.remove('hidden');
            if (branchSelect) branchSelect.setAttribute('required', 'required');
            if (onlineWidget) onlineWidget.classList.add('hidden');
            handleBranchChange();
        }

        // Update calendar service label
        const calLabel = document.getElementById('calendarServiceLabel');
        if (calLabel) {
            if (formatKey === 'urgent') {
                calLabel.innerText = 'أيام الحجز المستعجل بالفرع (متاح للأيام القريبة أو تواريخ الطوارئ ⚡)';
            } else if (formatKey === 'online') {
                calLabel.innerText = 'أيام جلسات الأونلاين المعتمدة بالفيديو 💻';
            } else {
                calLabel.innerText = 'أيام الحضور المجدولة بالفرع المحدد';
            }
        }

        autoFocusCalendarToFirstAvailableDate();
        renderCalendar();

        if (selectedDateStr) {
            loadTimeSlots(selectedDateStr, formatKey);
        }
    }

    // Handle Branch Change
    function handleBranchChange() {
        const branchSelect = document.getElementById('branch_id');
        const formatKey = getSelectedFormatKey();
        const conf = scheduleConfig[formatKey] || scheduleConfig['normal'];
        const branchId = branchSelect?.value;
        const branch = branchesData.find(b => b.id == branchId);

        let basePrice = conf.price;

        if (branch) {
            if (formatKey === 'urgent') {
                if (branch.urgent_price && parseFloat(branch.urgent_price) > 0) {
                    basePrice = parseFloat(branch.urgent_price);
                } else {
                    basePrice = conf.price;
                }
            } else if (formatKey === 'normal') {
                if (branch.price && parseFloat(branch.price) > 0) {
                    basePrice = parseFloat(branch.price);
                }
            }

            const daysBadge = document.getElementById('branchDaysBadge');
            if (daysBadge) {
                if (formatKey === 'urgent') {
                    const uDays = (branch.urgent_days_list && branch.urgent_days_list.length > 0) ? branch.urgent_days_list : branch.days_list;
                    let badgeText = (uDays || []).join(' • ');
                    if (branch.urgent_dates_list && branch.urgent_dates_list.length > 0) {
                        badgeText += ' [تواريخ طوارئ: ' + branch.urgent_dates_list.join(', ') + ']';
                    }
                    daysBadge.innerText = badgeText;
                } else {
                    let badgeText = (branch.days_list || []).join(' • ');
                    if (branch.specific_dates_list && branch.specific_dates_list.length > 0) {
                        badgeText += ' [تواريخ بالشهر: ' + branch.specific_dates_list.join(', ') + ']';
                    }
                    daysBadge.innerText = badgeText;
                }
            }
        }

        updatePriceDisplay(basePrice);
        autoFocusCalendarToFirstAvailableDate();
        renderCalendar();

        if (selectedDateStr) {
            loadTimeSlots(selectedDateStr, formatKey);
        }
    }

    function updatePriceDisplay(price) {
        const headerBadge = document.getElementById('headerPriceBadge');
        if (headerBadge) {
            headerBadge.innerText = Math.round(price) + ' ج.م';
        }
        const submitBtnText = document.getElementById('submitBtnText');
        if (submitBtnText) {
            submitBtnText.innerText = 'تأكيد وإرسال طلب الحجز (' + Math.round(price) + ' ج.م)';
        }
    }

    // ========================================================
    // INTERACTIVE CALENDAR ENGINE
    // ========================================================

    function changeCalendarMonth(delta) {
        calDisplayMonth += delta;
        if (calDisplayMonth > 11) {
            calDisplayMonth = 0;
            calDisplayYear++;
        } else if (calDisplayMonth < 0) {
            calDisplayMonth = 11;
            calDisplayYear--;
        }
        renderCalendar();
    }

    function renderCalendar() {
        const grid = document.getElementById('calendarDaysGrid');
        const monthTitle = document.getElementById('calendarMonthTitle');
        const prevBtn = document.getElementById('prevMonthBtn');
        if (!grid || !monthTitle) return;

        monthTitle.innerText = arabicMonths[calDisplayMonth] + ' ' + calDisplayYear;

        // Prevent navigating before current month
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const thisMonthStart = new Date(today.getFullYear(), today.getMonth(), 1);
        const displayedMonthStart = new Date(calDisplayYear, calDisplayMonth, 1);

        if (prevBtn) {
            if (displayedMonthStart <= thisMonthStart) {
                prevBtn.disabled = true;
                prevBtn.classList.add('opacity-30', 'cursor-not-allowed');
            } else {
                prevBtn.disabled = false;
                prevBtn.classList.remove('opacity-30', 'cursor-not-allowed');
            }
        }

        const firstDayIndex = (displayedMonthStart.getDay() + 1) % 7;
        const daysInMonth = new Date(calDisplayYear, calDisplayMonth + 1, 0).getDate();

        const formatKey = getSelectedFormatKey();
        const conf = scheduleConfig[formatKey] || scheduleConfig['normal'];
        const offDates = conf.off_dates || [];

        const branchSelect = document.getElementById('branch_id');
        const branchId = branchSelect?.value;
        const branch = branchesData.find(b => b.id == branchId);

        grid.innerHTML = '';

        // Empty padding cells before first day
        for (let i = 0; i < firstDayIndex; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.className = "p-1";
            grid.appendChild(emptyCell);
        }

        // Render each day of the month
        for (let day = 1; day <= daysInMonth; day++) {
            const cellDate = new Date(calDisplayYear, calDisplayMonth, day);
            cellDate.setHours(0, 0, 0, 0);

            const yyyy = calDisplayYear;
            const mm = String(calDisplayMonth + 1).padStart(2, '0');
            const dd = String(day).padStart(2, '0');
            const dateStr = `${yyyy}-${mm}-${dd}`;

            const dayKey = englishDayKeys[cellDate.getDay()];
            const dayDiff = Math.ceil((cellDate - today) / (1000 * 60 * 60 * 24));

            let isAllowed = true;
            let unallowedReason = '';

            // 1. Past dates
            if (cellDate < today) {
                isAllowed = false;
                unallowedReason = 'تاريخ ماضٍ';
            }
            // 2. Off dates / Holidays
            else if (offDates.includes(dateStr)) {
                isAllowed = false;
                unallowedReason = 'عطلة رسمية بالمركز';
            }
            // 3. Online Service
            else if (formatKey === 'online') {
                const onlineDays = conf.days || ['Saturday', 'Sunday', 'Tuesday', 'Thursday', 'Friday'];
                const onlineSpecificDates = conf.specific_dates || [];

                if (onlineSpecificDates.length > 0) {
                    if (!onlineSpecificDates.includes(dateStr)) {
                        isAllowed = false;
                        unallowedReason = 'جلسات الأونلاين محددة في تواريخ معينة';
                    }
                } else if (!onlineDays.includes(dayKey)) {
                    isAllowed = false;
                    unallowedReason = 'غير متاح لجلسات الأونلاين';
                }
            }
            // 4. In-Center Services (Normal or Urgent)
            else if (branch) {
                if (formatKey === 'urgent') {
                    // Urgent: Check branch urgent specific dates first
                    const urgentDates = (branch.urgent_dates_list && branch.urgent_dates_list.length > 0) 
                        ? branch.urgent_dates_list 
                        : (conf.specific_dates || []);

                    if (urgentDates.length > 0) {
                        if (!urgentDates.includes(dateStr)) {
                            isAllowed = false;
                            unallowedReason = 'موعد الحجز المستعجل بالفرع محدد في تواريخ الطوارئ المعتمدة';
                        }
                    } else {
                        // Check branch urgent days
                        const urgentDays = (branch.urgent_days_english_list && branch.urgent_days_english_list.length > 0)
                            ? branch.urgent_days_english_list
                            : (branch.days_english_list || ['Sunday']);

                        if (!urgentDays.includes(dayKey)) {
                            isAllowed = false;
                            unallowedReason = 'فرع ' + branch.name + ' غير متاح في هذا اليوم للحالات المستعجلة';
                        } else {
                            const maxDaysAhead = Math.max(conf.max_days_ahead || 2, 7);
                            if (dayDiff > maxDaysAhead) {
                                isAllowed = false;
                                unallowedReason = 'الحجز المستعجل متاح لأقرب موعد طوارئ قادم بالفرع';
                            }
                        }
                    }
                } else {
                    // Normal: Check branch normal specific dates first
                    const normalDates = (branch.specific_dates_list && branch.specific_dates_list.length > 0)
                        ? branch.specific_dates_list
                        : (conf.specific_dates || []);

                    if (normalDates.length > 0) {
                        if (!normalDates.includes(dateStr)) {
                            isAllowed = false;
                            unallowedReason = 'المواعيد المعتمدة لهذا الفرع محددة في تواريخ معينة بالشهر';
                        }
                    } else {
                        // Check branch normal days of week
                        const normalDays = (branch.days_english_list && branch.days_english_list.length > 0)
                            ? branch.days_english_list
                            : (conf.days || ['Sunday']);

                        if (!normalDays.includes(dayKey)) {
                            isAllowed = false;
                            unallowedReason = 'فرع ' + branch.name + ' غير متاح للمواعيد العادية في هذا اليوم';
                        }
                    }
                }
            }

            const btn = document.createElement('button');
            btn.type = 'button';

            const isSelected = (selectedDateStr === dateStr);

            if (isAllowed) {
                if (isSelected) {
                    btn.className = "w-full py-2 sm:py-2.5 rounded-xl font-black text-xs sm:text-sm bg-blue-600 text-white shadow-sm ring-2 ring-blue-300 scale-105 transition-all cursor-pointer flex flex-col items-center justify-center";
                } else {
                    btn.className = "w-full py-2 sm:py-2.5 rounded-xl font-bold text-xs sm:text-sm bg-white hover:bg-blue-50 text-slate-800 border border-slate-200 hover:border-blue-400 shadow-2xs transition-all cursor-pointer flex flex-col items-center justify-center";
                }
                btn.innerHTML = `<span>${day}</span>`;
                btn.title = `متاح: ${dateStr}`;
                btn.onclick = () => selectCalendarDate(dateStr, cellDate);
            } else {
                btn.disabled = true;
                btn.className = "w-full py-2 sm:py-2.5 rounded-xl font-medium text-xs sm:text-sm bg-slate-100/60 text-slate-300 border border-transparent cursor-not-allowed select-none flex flex-col items-center justify-center";
                btn.innerHTML = `<span>${day}</span>`;
                btn.title = unallowedReason;
            }

            grid.appendChild(btn);
        }

        // If today matches or a date was selected, update banner
        if (selectedDateStr) {
            updateSelectedDateBanner(selectedDateStr);
        }
    }

    function selectCalendarDate(dateStr, dateObj) {
        selectedDateStr = dateStr;
        document.getElementById('booking_date').value = dateStr;
        const err = document.getElementById('booking_date_error');
        if (err) err.classList.add('hidden');

        updateSelectedDateBanner(dateStr, dateObj);
        renderCalendar();

        const formatKey = getSelectedFormatKey();
        loadTimeSlots(dateStr, formatKey);
    }

    function updateSelectedDateBanner(dateStr, dateObj) {
        const banner = document.getElementById('selectedDateBanner');
        const text = document.getElementById('selectedDateText');
        if (!banner || !text) return;

        if (!dateObj) {
            const parts = dateStr.split('-');
            if (parts.length === 3) {
                dateObj = new Date(parts[0], parts[1] - 1, parts[2]);
            }
        }

        if (dateObj) {
            const dayName = arabicDayNames[dateObj.getDay()];
            const monthName = arabicMonths[dateObj.getMonth()];
            text.innerText = `${dayName}، ${dateObj.getDate()} ${monthName} ${dateObj.getFullYear()}`;
            banner.classList.remove('hidden');
        }
    }

    // ========================================================
    // DYNAMIC TIME SLOTS & AVAILABILITY FETCHING
    // ========================================================

    function loadTimeSlots(dateStr, formatKey) {
        const chipsGrid = document.getElementById('slotsChipsGrid');
        const spinner = document.getElementById('slotsLoadingSpinner');
        const noSlots = document.getElementById('noSlotsMessage');
        const conf = scheduleConfig[formatKey] || scheduleConfig['normal'];

        if (!chipsGrid) return;

        if (!dateStr) {
            chipsGrid.innerHTML = '';
            if (noSlots) noSlots.classList.remove('hidden');
            return;
        }

        if (noSlots) noSlots.classList.add('hidden');
        if (spinner) spinner.classList.remove('hidden');

        const branchSelect = document.getElementById('branch_id');
        const branchId = (formatKey !== 'online' && branchSelect) ? branchSelect.value : '';

        // Fetch slots with real-time booked counts from endpoint
        fetch(`{{ route('booking.slotsAvailability') }}?date=${dateStr}&format=${formatKey}&branch_id=${branchId}`)
            .then(res => res.json())
            .then(data => {
                if (spinner) spinner.classList.add('hidden');
                chipsGrid.innerHTML = '';

                const slots = (data.slots && data.slots.length > 0) ? data.slots : conf.slots.map(s => ({ time: s, is_full: false }));

                if (slots.length === 0) {
                    chipsGrid.innerHTML = `
                        <div class="col-span-full p-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-500 text-xs text-center font-bold">
                            لا توجد فترات مسجلة لهذا اليوم.
                        </div>
                    `;
                    return;
                }

                slots.forEach(slot => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    const isSelected = (selectedTimeSlot === slot.time);

                    if (slot.is_full) {
                        btn.disabled = true;
                        btn.className = "p-2.5 rounded-xl border border-slate-200 bg-slate-100 text-slate-400 text-xs font-bold cursor-not-allowed opacity-60 flex flex-col items-center justify-center select-none";
                        btn.innerHTML = `
                            <span>${slot.time}</span>
                            <span class="text-[9px] text-red-500 font-black mt-0.5">محجوز بالكامل ✕</span>
                        `;
                    } else {
                        btn.className = `slot-chip p-2.5 rounded-xl border-2 text-xs font-black transition-all cursor-pointer flex flex-col items-center justify-center ${isSelected ? 'border-blue-600 bg-blue-50 text-blue-700 ring-2 ring-blue-100' : 'border-slate-200 bg-white hover:border-blue-300 text-slate-800'}`;
                        btn.innerHTML = `
                            <span>${slot.time}</span>
                            <span class="text-[9px] text-emerald-600 font-bold mt-0.5">متاح للحجز ✓</span>
                        `;
                        btn.onclick = () => selectTimeSlot(slot.time, btn);
                    }

                    chipsGrid.appendChild(btn);
                });
            })
            .catch(err => {
                if (spinner) spinner.classList.add('hidden');
                // Fallback to static configured slots if offline/error
                chipsGrid.innerHTML = '';
                conf.slots.forEach(slotTime => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    const isSelected = (selectedTimeSlot === slotTime);
                    btn.className = `slot-chip p-2.5 rounded-xl border-2 text-xs font-black transition-all cursor-pointer flex flex-col items-center justify-center ${isSelected ? 'border-blue-600 bg-blue-50 text-blue-700 ring-2 ring-blue-100' : 'border-slate-200 bg-white hover:border-blue-300 text-slate-800'}`;
                    btn.innerHTML = `<span>${slotTime}</span>`;
                    btn.onclick = () => selectTimeSlot(slotTime, btn);
                    chipsGrid.appendChild(btn);
                });
            });
    }

    function selectTimeSlot(slotTime, btnElement) {
        selectedTimeSlot = slotTime;
        document.getElementById('booking_time').value = slotTime;

        const err = document.getElementById('booking_time_error');
        if (err) err.classList.add('hidden');

        document.querySelectorAll('.slot-chip').forEach(b => {
            b.classList.remove('border-blue-600', 'bg-blue-50', 'text-blue-700', 'ring-2', 'ring-blue-100');
            b.classList.add('border-slate-200', 'bg-white', 'text-slate-800');
        });

        if (btnElement) {
            btnElement.classList.add('border-blue-600', 'bg-blue-50', 'text-blue-700', 'ring-2', 'ring-blue-100');
            btnElement.classList.remove('border-slate-200', 'bg-white', 'text-slate-800');
        }
    }

    // Handle Payment Selection
    function handlePaymentMethodChange(method) {
        document.querySelectorAll('.payment-method-card').forEach(card => {
            card.classList.remove('border-blue-600', 'ring-2', 'ring-blue-100', 'shadow-xs');
            card.classList.add('border-slate-200');
        });

        const activeCard = document.getElementById('card_' + method);
        if (activeCard) {
            activeCard.classList.add('border-blue-600', 'ring-2', 'ring-blue-100', 'shadow-xs');
            activeCard.classList.remove('border-slate-200');
        }
    }

    // Copy Text to Clipboard
    function copyText(text, btnElement) {
        navigator.clipboard.writeText(text).then(() => {
            const originalText = btnElement.innerText;
            btnElement.innerText = 'تم النسخ!';
            btnElement.classList.add('bg-emerald-500', 'text-white');
            setTimeout(() => {
                btnElement.innerText = originalText;
                btnElement.classList.remove('bg-emerald-500', 'text-white');
            }, 1800);
        }).catch(() => {
            alert('تم نسخ: ' + text);
        });
    }

    // Preview Receipt Image
    function previewReceipt(input) {
        const previewState = document.getElementById('uploadPreviewState');
        const previewImg = document.getElementById('receiptPreviewImg');
        const fileNameSpan = document.getElementById('receiptFileName');
        const errorMsg = document.getElementById('receipt_error');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImg.src = e.target.result;
                fileNameSpan.innerText = file.name;
                previewState.classList.remove('hidden');
                if (errorMsg) errorMsg.classList.add('hidden');
            };

            reader.readAsDataURL(file);
        }
    }

    // Remove Receipt Image
    function removeReceipt() {
        const input = document.getElementById('payment_receipt');
        const previewState = document.getElementById('uploadPreviewState');
        const previewImg = document.getElementById('receiptPreviewImg');

        input.value = '';
        previewImg.src = '';
        previewState.classList.add('hidden');
    }

    // Form Submission Validation
    document.getElementById('bookingForm')?.addEventListener('submit', function(e) {
        let valid = true;

        const dateInput = document.getElementById('booking_date');
        const dateError = document.getElementById('booking_date_error');
        if (!dateInput || !dateInput.value) {
            valid = false;
            if (dateError) dateError.classList.remove('hidden');
            dateError?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            if (dateError) dateError.classList.add('hidden');
        }

        const timeInput = document.getElementById('booking_time');
        const timeError = document.getElementById('booking_time_error');
        if (!timeInput || !timeInput.value) {
            valid = false;
            if (timeError) timeError.classList.remove('hidden');
            if (valid) timeError?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            if (timeError) timeError.classList.add('hidden');
        }

        const receiptInput = document.getElementById('payment_receipt');
        const errorMsg = document.getElementById('receipt_error');
        if (!receiptInput.files || receiptInput.files.length === 0) {
            valid = false;
            if (errorMsg) errorMsg.classList.remove('hidden');
            if (valid) receiptInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        if (!valid) {
            e.preventDefault();
            return false;
        }

        const submitBtn = document.getElementById('submitBtn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            submitBtn.innerHTML = '<span>جاري إرسال طلب الحجز...</span>';
        }
    });

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const initialFormat = getSelectedFormatKey();
        handleFormatSelection(initialFormat === 'urgent' ? 'in_center_urgent' : (initialFormat === 'online' ? 'online' : 'in_center_normal'));
    });
</script>
@endsection
