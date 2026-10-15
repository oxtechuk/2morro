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
                                <label class="relative flex flex-col p-2.5 sm:p-3 rounded-xl border-2 cursor-pointer transition-all format-card bg-white border-blue-600 ring-2 ring-blue-100 shadow-xs" id="formatCard_in_center_normal">
                                    <div class="flex items-center justify-between mb-1">
                                        <input type="radio" name="session_format" value="in_center_normal" checked onchange="handleFormatSelection(this.value)" class="text-blue-600 focus:ring-blue-600 w-3.5 h-3.5">
                                        <span class="text-[9px] font-black px-1.5 py-0.5 rounded bg-blue-50 text-blue-700">مجدول</span>
                                    </div>
                                    <span class="font-black text-xs text-slate-900 block">في المركز (عادي)</span>
                                    <span class="text-[10px] text-slate-500 block">حضور في الفرع</span>
                                </label>

                                <!-- Urgent In-Center -->
                                <label class="relative flex flex-col p-2.5 sm:p-3 rounded-xl border-2 cursor-pointer transition-all format-card bg-white border-slate-200 hover:border-blue-300" id="formatCard_in_center_urgent">
                                    <div class="flex items-center justify-between mb-1">
                                        <input type="radio" name="session_format" value="in_center_urgent" onchange="handleFormatSelection(this.value)" class="text-blue-600 focus:ring-blue-600 w-3.5 h-3.5">
                                        <span class="text-[9px] font-black px-1.5 py-0.5 rounded bg-blue-600 text-white">مستعجل</span>
                                    </div>
                                    <span class="font-black text-xs text-slate-900 block">في المركز (أولوية)</span>
                                    <span class="text-[10px] text-slate-500 block">+150 ج.م كشف عاجل</span>
                                </label>

                                <!-- Online Remote -->
                                <label class="relative flex flex-col p-2.5 sm:p-3 rounded-xl border-2 cursor-pointer transition-all format-card bg-white border-slate-200 hover:border-blue-300" id="formatCard_online">
                                    <div class="flex items-center justify-between mb-1">
                                        <input type="radio" name="session_format" value="online" onchange="handleFormatSelection(this.value)" class="text-blue-600 focus:ring-blue-600 w-3.5 h-3.5">
                                        <span class="text-[9px] font-black px-1.5 py-0.5 rounded bg-slate-100 text-slate-700">عن بُعد</span>
                                    </div>
                                    <span class="font-black text-xs text-slate-900 block">أونلاين (Zoom)</span>
                                    <span class="text-[10px] text-slate-500 block">مكالمة فيديو مباشرة</span>
                                </label>

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

                        <!-- 3. تاريخ المقابلة والفترة الزمنية (مرتبطة بمواعيد وأيام الفرع) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label class="block text-xs font-black text-slate-700 mb-1">تاريخ المقابلة المفضل <span class="text-red-500">*</span></label>
                                <input type="date" name="booking_date" id="booking_date" min="{{ date('Y-m-d') }}" value="{{ old('booking_date', date('Y-m-d', strtotime('+1 day'))) }}" onchange="validateBookingDate()" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white">
                                <span id="dateDayAlert" class="text-[10px] text-amber-700 font-bold hidden mt-1 block bg-amber-50 p-1.5 rounded-md border border-amber-200"></span>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-slate-700 mb-1">الفترة الزمنية المفضلة <span class="text-red-500">*</span></label>
                                <select name="booking_time" id="booking_time" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white">
                                    <option value="12:00 PM - 02:00 PM">12:00 ظ - 02:00 ظ</option>
                                    <option value="02:00 PM - 04:00 PM">02:00 م - 04:00 م</option>
                                    <option value="04:00 PM - 06:30 PM">04:00 م - 06:30 م</option>
                                    <option value="06:30 PM - 09:00 PM">06:30 م - 09:00 م</option>
                                </select>
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
<script>
    let currentStep = 1;
    const branchesData = @json($branchesList);
    const urgentFee = 150.00;
    const arabicDayNames = ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];

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

        if (format === 'online') {
            if (branchContainer) branchContainer.classList.add('hidden');
            if (branchSelect) branchSelect.removeAttribute('required');
            if (onlineWidget) onlineWidget.classList.remove('hidden');

            const onlineBranch = branchesData.find(b => b.is_online);
            if (onlineBranch) {
                updateBranchScheduleAndPricing(onlineBranch, 0);
            } else {
                updatePriceDisplay(250.00);
            }
        } else {
            if (branchContainer) branchContainer.classList.remove('hidden');
            if (branchSelect) branchSelect.setAttribute('required', 'required');
            if (onlineWidget) onlineWidget.classList.add('hidden');

            handleBranchChange();
        }
    }

    // Handle Branch Change & Load exact days/slots from Dashboard
    function handleBranchChange() {
        const branchSelect = document.getElementById('branch_id');
        if (!branchSelect) return;

        const branchId = branchSelect.value;
        const branch = branchesData.find(b => b.id == branchId);
        
        const selectedFormat = document.querySelector('input[name="session_format"]:checked')?.value || 'in_center_normal';
        const fee = (selectedFormat === 'in_center_urgent') ? urgentFee : 0;

        if (branch) {
            updateBranchScheduleAndPricing(branch, fee);
        }
    }

    function updateBranchScheduleAndPricing(branch, extraFee = 0) {
        const totalPrice = parseFloat(branch.price || 300) + parseFloat(extraFee);
        updatePriceDisplay(totalPrice);

        // Update Days badge from dashboard
        const days = branch.days_list || (Array.isArray(branch.available_days) ? branch.available_days : ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس']);
        const daysBadge = document.getElementById('branchDaysBadge');
        if (daysBadge) {
            daysBadge.innerText = days.join(' • ');
        }

        // Update Time Slots dropdown from dashboard
        const slotsSelect = document.getElementById('booking_time');
        if (slotsSelect) {
            const slots = branch.slots_list || (Array.isArray(branch.time_slots) ? branch.time_slots : [
                '12:00 PM - 02:00 PM',
                '02:00 PM - 04:00 PM',
                '04:00 PM - 06:30 PM',
                '06:30 PM - 09:00 PM'
            ]);

            slotsSelect.innerHTML = '';
            slots.forEach(slot => {
                const opt = document.createElement('option');
                opt.value = slot;
                opt.innerText = slot;
                slotsSelect.appendChild(opt);
            });
        }

        // Validate date based on branch days
        validateBookingDate();
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

    // Validate if the selected date matches the branch's available days
    function validateBookingDate() {
        const dateInput = document.getElementById('booking_date');
        const alertBox = document.getElementById('dateDayAlert');
        if (!dateInput || !dateInput.value) return;

        const branchSelect = document.getElementById('branch_id');
        const selectedFormat = document.querySelector('input[name="session_format"]:checked')?.value || 'in_center_normal';
        
        let currentBranch = null;
        if (selectedFormat === 'online') {
            currentBranch = branchesData.find(b => b.is_online);
        } else if (branchSelect) {
            currentBranch = branchesData.find(b => b.id == branchSelect.value);
        }

        if (!currentBranch) return;

        const availableDays = currentBranch.days_list || ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس'];
        const parts = dateInput.value.split('-');
        if (parts.length === 3) {
            const pickedDate = new Date(parts[0], parts[1] - 1, parts[2]);
            const dayName = arabicDayNames[pickedDate.getDay()];

            if (!availableDays.includes(dayName)) {
                alertBox.innerText = 'تنبيه: يوم (' + dayName + ') غير مدرج ضمن أيام عمل هذا الفرع. أيام العمل: ' + availableDays.join('، ');
                alertBox.classList.remove('hidden');
            } else {
                alertBox.classList.add('hidden');
            }
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
        const receiptInput = document.getElementById('payment_receipt');
        const errorMsg = document.getElementById('receipt_error');

        if (!receiptInput.files || receiptInput.files.length === 0) {
            e.preventDefault();
            if (errorMsg) errorMsg.classList.remove('hidden');
            receiptInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
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
        handleBranchChange();
    });
</script>
@endsection
