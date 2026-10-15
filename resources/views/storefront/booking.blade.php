@extends('layouts.storefront')

@section('title', $bookingTitle . ' | مركز 2morro')

@section('content')
<div class="bg-[#F8FAFC] min-h-screen py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center gap-2 text-xs font-bold text-slate-500 mb-8">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">الرئيسية</a>
            <svg class="w-3 h-3 text-slate-400 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-slate-800 font-black">حجز استشارة وتقييم مهارات الطفل</span>
        </nav>

        <!-- Main 2-Column Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
            
            <!-- Right Column (Sticky Center Card & Supervisor Info) - 5 Cols in RTL -->
            <div class="lg:col-span-5 order-2 lg:order-1">
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden lg:sticky lg:top-24 text-right">
                    
                    <!-- Admin Managed Image -->
                    <div class="relative h-64 sm:h-72 w-full bg-slate-900 overflow-hidden">
                        <img src="{{ asset($bookingImage) }}" alt="{{ $bookingTitle }}" class="w-full h-full object-cover opacity-90 transition-transform duration-700 hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent"></div>
                        
                        <!-- Floating Badge on Image -->
                        <div class="absolute top-4 right-4 z-10">
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-black bg-blue-600 text-white backdrop-blur-md shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-200 animate-pulse"></span>
                                <span>مركز 2morro لتنمية المهارات</span>
                            </span>
                        </div>

                        <!-- Quote overlay at bottom of image -->
                        <div class="absolute bottom-4 right-4 left-4 z-10">
                            <p class="text-xs sm:text-sm text-white font-bold leading-relaxed line-clamp-3" style="text-shadow: 0 1px 3px rgba(0,0,0,0.8);">
                                {{ $bookingQuote }}
                            </p>
                        </div>
                    </div>

                    <!-- Center & Supervisor Info Details -->
                    <div class="p-6 sm:p-7 space-y-4">
                        
                        <div>
                            <h3 class="text-base sm:text-lg font-black text-slate-900 mb-1">
                                {{ $bookingTitle }}
                            </h3>
                            <p class="text-xs text-slate-500 font-medium leading-relaxed">
                                {{ $bookingSubtitle }}
                            </p>
                        </div>

                        <div class="space-y-2.5 pt-2 border-t border-slate-100 text-xs">
                            
                            <!-- Supervisor -->
                            <div class="flex items-center gap-3 p-3 rounded-2xl bg-blue-50/70 border border-blue-100 text-slate-800">
                                <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center flex-shrink-0 shadow-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div>
                                    <span class="text-[10px] text-blue-700 block font-bold">قيادة وإشراف وتوجيه:</span>
                                    <span class="font-black text-slate-900">أ. هبة الله أكرم</span>
                                    <span class="text-[10px] text-slate-500 block">(برامج • تعليمات • إشراف • متابعة)</span>
                                </div>
                            </div>

                            <!-- Working Hours -->
                            <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-200/80 text-slate-800">
                                <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center flex-shrink-0 shadow-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <span class="text-[10px] text-slate-600 block font-bold">مواعيد العمل الرسمية:</span>
                                    <span class="font-black text-slate-900">من 12:00 ظهراً إلى 9:00 مساءً</span>
                                    <span class="text-[10px] text-slate-500 block">(يومياً عدا الجمعة)</span>
                                </div>
                            </div>

                            <!-- Dynamic Active Branches Preview -->
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 text-slate-800 space-y-2">
                                <div class="flex items-center gap-2 pb-1.5 border-b border-slate-200/60">
                                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <span class="text-[11px] text-slate-900 font-black">فروع المركز المتاحة:</span>
                                </div>
                                <div class="text-[11px] text-slate-700 space-y-1.5 pr-1">
                                    @foreach($branchesList as $br)
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-slate-700">• {{ $br->name }}</span>
                                            <span class="font-black text-blue-700">{{ number_format($br->price) }} ج.م</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                        <!-- Direct WhatsApp Contact Button -->
                        <div class="pt-2">
                            @php
                                $bookingWaRaw = \App\Models\Setting::get('store_whatsapp', '201550504512');
                                $bookingWaNum = preg_replace('/[^0-9]/', '', $bookingWaRaw) ?: '201550504512';
                            @endphp
                            <a href="https://wa.me/{{ $bookingWaNum }}" target="_blank" class="w-full py-3 px-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black flex items-center justify-center gap-2 shadow-xs transition-all hover:scale-[1.01] active:scale-95">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.458L0 24zm6.002-3.693c1.615.957 3.178 1.462 4.736 1.463 5.485.002 9.948-4.463 9.95-9.953.001-2.66-1.025-5.16-2.887-7.026C16.001 2.923 13.506 1.897 10.85 1.897c-5.486 0-9.949 4.464-9.953 9.954-.001 2.052.541 4.06 1.567 5.814l-1.026 3.75 3.829-1.004z"></path></svg>
                                <span>استفسار فوري عبر واتساب ({{ $bookingWaRaw }})</span>
                            </a>
                        </div>

                    </div>

                </div>
            </div>

            <!-- Left Column (2-Step Wizard Booking Form) - 7 Cols in RTL -->
            <div class="lg:col-span-7 order-1 lg:order-2">
                
                <!-- Form Header -->
                <div class="mb-6 text-right">
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mb-1">
                        طلب حجز استشارة وتقييم
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium">
                        يرجى ملء البيانات واختيار الفرع المناسب وتأكيد الدفع بسهولة
                    </p>
                </div>

                <!-- 2-Step Progress Stepper Indicator (Unified Blue Color Theme) -->
                <div class="flex items-center justify-center max-w-sm mx-auto mb-8 relative px-4" dir="ltr">
                    
                    <!-- Connecting Bar Background -->
                    <div class="absolute top-1/2 left-10 right-10 -translate-y-1/2 h-1 bg-slate-200 z-0"></div>
                    
                    <!-- Active Connecting Bar Progress Fill -->
                    <div id="stepProgressFill" class="absolute top-1/2 left-10 -translate-y-1/2 h-1 bg-blue-600 transition-all duration-300 z-0" style="width: 0%;"></div>

                    <!-- Step 1 Indicator -->
                    <div class="relative z-10 flex flex-col items-center">
                        <button type="button" onclick="goToStep(1)" id="stepCircle1" class="w-10 h-10 rounded-full flex items-center justify-center font-black text-sm transition-all duration-300 bg-blue-600 text-white shadow-md ring-4 ring-blue-100">
                            1
                        </button>
                        <span id="stepLabel1" class="text-[11px] font-black text-slate-800 mt-1.5 whitespace-nowrap">البيانات الأساسية</span>
                    </div>

                    <!-- Spacer between steps -->
                    <div class="flex-grow"></div>

                    <!-- Step 2 Indicator -->
                    <div class="relative z-10 flex flex-col items-center">
                        <button type="button" onclick="validateAndGoToStep(2)" id="stepCircle2" class="w-10 h-10 rounded-full flex items-center justify-center font-black text-sm transition-all duration-300 bg-slate-100 text-slate-400 border border-slate-200">
                            2
                        </button>
                        <span id="stepLabel2" class="text-[11px] font-bold text-slate-400 mt-1.5 whitespace-nowrap">الموعد والدفع</span>
                    </div>

                </div>

                @if(isset($errors) && $errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 text-xs font-bold p-4 rounded-2xl text-right">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Main Form Card Container with Multipart Form-Data -->
                <form id="bookingForm" action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm text-right">
                    @csrf

                    <!-- STEP 1: Basic Information (بيانات الطفل وولي الأمر) -->
                    <div id="step1Content" class="space-y-6 transition-opacity duration-300">
                        
                        <!-- Step Header -->
                        <div class="pb-4 border-b border-slate-100">
                            <h2 class="text-base sm:text-lg font-black text-slate-900">
                                البيانات الأساسية للطفل وولي الأمر
                            </h2>
                            <p class="text-xs text-slate-400 font-medium mt-0.5">
                                أدخل تفاصيل الطفل ورقم التواصل لتأكيد وتنسيق الحجز
                            </p>
                        </div>

                        <!-- Step 1 Form Fields -->
                        <div class="space-y-4">
                            
                            <!-- Child Name -->
                            <div>
                                <label class="block text-xs font-black text-slate-700 mb-1.5">اسم الطفل بالكامل <span class="text-red-500">*</span></label>
                                <input type="text" name="child_name" id="child_name" value="{{ old('child_name') }}" required placeholder="مثال: يوسف أحمد محمد" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white">
                                <span id="child_name_error" class="text-red-500 text-[11px] font-bold hidden mt-1 block">يرجى إدخال اسم الطفل.</span>
                            </div>

                            <!-- Child Age -->
                            <div>
                                <label class="block text-xs font-black text-slate-700 mb-1.5">عمر الطفل <span class="text-red-500">*</span></label>
                                <input type="text" name="child_age" id="child_age" value="{{ old('child_age') }}" required placeholder="مثال: 4 سنوات و 6 أشهر" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white">
                                <span id="child_age_error" class="text-red-500 text-[11px] font-bold hidden mt-1 block">يرجى إدخال عمر الطفل.</span>
                            </div>

                            <!-- Parent Name -->
                            <div>
                                <label class="block text-xs font-black text-slate-700 mb-1.5">اسم ولي الأمر <span class="text-red-500">*</span></label>
                                <input type="text" name="parent_name" id="parent_name" value="{{ old('parent_name', auth()->user()?->name) }}" required placeholder="مثال: أحمد محمد علي" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white">
                                <span id="parent_name_error" class="text-red-500 text-[11px] font-bold hidden mt-1 block">يرجى إدخال اسم ولي الأمر.</span>
                            </div>

                            <!-- Parent Phone -->
                            <div>
                                <label class="block text-xs font-black text-slate-700 mb-1.5">رقم الهاتف والواتساب للتواصل <span class="text-red-500">*</span></label>
                                <input type="tel" name="parent_phone" id="parent_phone" value="{{ old('parent_phone', auth()->user()?->phone) }}" required placeholder="010xxxxxxxx" dir="ltr" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white text-right">
                                <span id="parent_phone_error" class="text-red-500 text-[11px] font-bold hidden mt-1 block">يرجى إدخال رقم الهاتف للتواصل.</span>
                            </div>

                            <!-- Parent Email (Optional) -->
                            <div>
                                <label class="block text-xs font-black text-slate-700 mb-1.5">البريد الإلكتروني (اختياري)</label>
                                <input type="email" name="parent_email" id="parent_email" value="{{ old('parent_email', auth()->user()?->email) }}" placeholder="name@example.com" dir="ltr" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white text-right">
                            </div>

                        </div>

                        <!-- Step 1 Footer Action -->
                        <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[11px] text-slate-400 font-medium">الخطوة 1 من 2</span>
                            <button type="button" onclick="nextToStep2()" class="px-8 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-black flex items-center gap-2 shadow-md shadow-blue-600/20 transition-all hover:scale-[1.02] active:scale-95 cursor-pointer">
                                <span>التالي: الموعد والدفع</span>
                                <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>

                    </div>

                    <!-- STEP 2: Session, Branch, Schedule & Payment (تفاصيل الجلسة، الفرع، الموعد، وسكرين شوت الدفع) -->
                    <div id="step2Content" class="space-y-6 hidden transition-opacity duration-300">
                        
                        <!-- Step Header -->
                        <div class="pb-4 border-b border-slate-100">
                            <h2 class="text-base sm:text-lg font-black text-slate-900">
                                تفاصيل الجلسة، الفرع، وتأكيد الدفع
                            </h2>
                            <p class="text-xs text-slate-400 font-medium mt-0.5">
                                حدد الخدمة والفرع والميعاد، ثم اختر طريقة الدفع وارفع سكرين شوت التحويل
                            </p>
                        </div>

                        <!-- Step 2 Form Fields -->
                        <div class="space-y-5">
                            
                            <!-- Service Type -->
                            <div>
                                <label class="block text-xs font-black text-slate-700 mb-1.5">نوع الخدمة / الجلسة المطلوبة <span class="text-red-500">*</span></label>
                                <select name="service_type" id="service_type" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white">
                                    @foreach($services as $key => $name)
                                        <option value="{{ $key }}" {{ old('service_type') === $key ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Session Format & Branch Selection -->
                            <div id="sessionFormatBranchContainer" class="grid grid-cols-1 sm:grid-cols-2 gap-4 transition-all">
                                
                                <div id="sessionFormatCol">
                                    <label class="block text-xs font-black text-slate-700 mb-1.5">طريقة المقابلة <span class="text-red-500">*</span></label>
                                    <select name="session_format" id="session_format" onchange="handleFormatChange()" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white">
                                        <option value="in_center" {{ old('session_format', 'in_center') === 'in_center' ? 'selected' : '' }}>حضورياً في مقر المركز</option>
                                        <option value="online" {{ old('session_format') === 'online' ? 'selected' : '' }}>أونلاين عن بُعد (جلسة فيديو Zoom)</option>
                                    </select>
                                </div>

                                <div id="branchCol" class="transition-all">
                                    <label class="block text-xs font-black text-slate-700 mb-1.5">الفرع المفضل <span class="text-red-500">*</span></label>
                                    <select name="branch_id" id="branch_id" onchange="handleBranchChange()" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white">
                                        @foreach($branchesList as $b)
                                            <option value="{{ $b->id }}" 
                                                data-price="{{ $b->price }}"
                                                data-online="{{ $b->is_online ? '1' : '0' }}"
                                                data-address="{{ $b->address }}"
                                                data-days="{{ json_encode($b->days_list) }}"
                                                data-slots="{{ json_encode($b->slots_list) }}"
                                                {{ old('branch_id') == $b->id ? 'selected' : '' }}>
                                                {{ $b->name }} {{ $b->address ? ' - ' . $b->address : '' }} ({{ number_format($b->price) }} ج.م)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <!-- Dynamic Price & Schedule Widget (Unified Blue Style) -->
                            <div id="pricingWidget" class="p-4 rounded-2xl bg-blue-50/60 border border-blue-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-right">
                                <div class="flex items-center gap-3 w-full sm:w-auto">
                                    <div class="w-11 h-11 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-xs flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="text-[11px] text-slate-500 font-bold block">سعر وتكلفة الاستشارة:</span>
                                        <div class="flex items-baseline gap-1.5">
                                            <span id="priceDisplay" class="text-2xl font-black text-slate-900">300.00</span>
                                            <span class="text-xs font-black text-blue-600">جنيه مصري</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full sm:w-auto text-xs bg-white px-3.5 py-2.5 rounded-xl border border-blue-100 font-medium text-right">
                                    <div class="flex items-center gap-1.5 text-slate-800 font-black text-[11px] mb-1">
                                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span>الأيام المتاحة للفرع:</span>
                                    </div>
                                    <span id="daysDisplay" class="text-slate-600 font-bold text-[11px]">السبت • الأحد • الاثنين • الثلاثاء • الأربعاء • الخميس</span>
                                </div>
                            </div>

                            <!-- Online Information Widget (When Online is Selected) -->
                            <div id="onlineInfoWidget" class="hidden p-3.5 rounded-2xl bg-blue-50/90 border border-blue-200 text-blue-950 text-xs flex items-start gap-2.5 transition-all">
                                <span class="w-7 h-7 rounded-xl bg-blue-600 text-white flex items-center justify-center flex-shrink-0 text-xs font-bold shadow-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                </span>
                                <div class="leading-relaxed">
                                    <span class="font-black text-blue-900 block">تفاصيل الاستشارة الأونلاين عن بُعد:</span>
                                    <p class="text-[11px] text-blue-800/90 mt-0.5 font-medium">سيتم التواصل معكم عبر الواتساب لتأكيد الاستشارة وتزويدكم برابط غرفة الزووم (Zoom Meeting) الخاصة في الميعاد المحدد مع الأخصائي مباشرة.</p>
                                </div>
                            </div>

                            <!-- Booking Date & Time Slot Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black text-slate-700 mb-1.5">تاريخ المقابلة المفضل <span class="text-red-500">*</span></label>
                                    <input type="date" name="booking_date" id="booking_date" min="{{ date('Y-m-d') }}" value="{{ old('booking_date', date('Y-m-d', strtotime('+1 day'))) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white">
                                    <span class="text-[10px] text-slate-400 mt-1 block">اختر يوماً من الأيام المتاحة المحددة أعلاه</span>
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-slate-700 mb-1.5">الفترة الزمنية المفضلة <span class="text-red-500">*</span></label>
                                    <select name="booking_time" id="booking_time" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white">
                                        <option value="12:00 PM - 02:00 PM">فترة الظهيرة (12:00 ظ - 02:00 ظ)</option>
                                        <option value="02:00 PM - 04:00 PM">فترة العصر (02:00 م - 04:00 م)</option>
                                        <option value="04:00 PM - 06:30 PM">بعد العصر (04:00 م - 06:30 م)</option>
                                        <option value="06:30 PM - 09:00 PM">الفترة المسائية (06:30 م - 09:00 م)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- SECTION: Payment Methods (فودافون كاش وإنستاباي فقط) -->
                            <div class="pt-4 border-t border-slate-100 space-y-3.5">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-sm sm:text-base font-black text-slate-900 flex items-center gap-2">
                                            <span>طرق الدفع وتأكيد الحجز</span>
                                            <span class="text-red-500">*</span>
                                        </h3>
                                        <p class="text-[11px] text-slate-400 font-medium">
                                            اختر طريقة الدفع المناسبة وقم برفع صورة سكرين شوت للتحويل
                                        </p>
                                    </div>
                                    <span class="text-xs font-black text-blue-700 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">
                                        تأكيد فوري
                                    </span>
                                </div>

                                <!-- Payment Options Grid (Vodafone Cash & InstaPay Only) -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    
                                    <!-- Vodafone Cash Option -->
                                    @if(!empty($paymentSettings['vodafone_cash']))
                                        <label class="relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all payment-method-card bg-white border-blue-600 ring-2 ring-blue-100 shadow-xs" id="card_vodafone_cash">
                                            <div class="flex items-start justify-between mb-2">
                                                <div class="flex items-center gap-2">
                                                    <input type="radio" name="payment_method" value="vodafone_cash" checked onchange="handlePaymentMethodChange(this.value)" class="text-blue-600 focus:ring-blue-600 w-4 h-4">
                                                    <span class="font-black text-xs sm:text-sm text-slate-900">فودافون كاش</span>
                                                </div>
                                                <span class="text-[10px] font-black px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 border border-blue-200">كاش</span>
                                            </div>
                                            <div class="mt-1 flex items-center justify-between bg-slate-50 p-2 rounded-xl border border-slate-100">
                                                <span class="font-mono text-xs font-black text-slate-800" dir="ltr" id="vfCashNum">{{ $paymentSettings['vodafone_cash'] }}</span>
                                                <button type="button" onclick="copyText('{{ $paymentSettings['vodafone_cash'] }}', this)" class="inline-flex items-center gap-1 text-[10px] font-bold text-blue-600 hover:text-blue-800 bg-white px-2 py-1 rounded-lg border border-blue-200 shadow-2xs transition-colors">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                                    <span>نسخ الرقم</span>
                                                </button>
                                            </div>
                                        </label>
                                    @endif

                                    <!-- InstaPay Option -->
                                    @if(!empty($paymentSettings['instapay']))
                                        <label class="relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all payment-method-card bg-white border-slate-200 hover:border-blue-400" id="card_instapay">
                                            <div class="flex items-start justify-between mb-2">
                                                <div class="flex items-center gap-2">
                                                    <input type="radio" name="payment_method" value="instapay" {{ empty($paymentSettings['vodafone_cash']) ? 'checked' : '' }} onchange="handlePaymentMethodChange(this.value)" class="text-blue-600 focus:ring-blue-600 w-4 h-4">
                                                    <span class="font-black text-xs sm:text-sm text-slate-900">إنستاباي (InstaPay)</span>
                                                </div>
                                                <span class="text-[10px] font-black px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 border border-blue-200">تحويل فوري</span>
                                            </div>
                                            <div class="mt-1 flex items-center justify-between bg-slate-50 p-2 rounded-xl border border-slate-100">
                                                <span class="font-mono text-xs font-black text-slate-800 truncate max-w-[140px]" dir="ltr">{{ $paymentSettings['instapay'] }}</span>
                                                <button type="button" onclick="copyText('{{ $paymentSettings['instapay'] }}', this)" class="inline-flex items-center gap-1 text-[10px] font-bold text-blue-600 hover:text-blue-800 bg-white px-2 py-1 rounded-lg border border-blue-200 shadow-2xs transition-colors">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                                    <span>نسخ المعرف</span>
                                                </button>
                                            </div>
                                        </label>
                                    @endif

                                </div>

                                <!-- Payment Instructions Notice -->
                                <div class="p-3.5 rounded-2xl bg-blue-50/60 border border-blue-200/70 text-slate-800 text-xs flex items-start gap-2.5">
                                    <span class="w-6 h-6 rounded-lg bg-blue-600 text-white flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </span>
                                    <div class="leading-relaxed">
                                        <span class="font-black text-slate-900">إرشادات التحويل وتأكيد الحجز:</span>
                                        <p class="text-[11px] text-slate-600 mt-0.5 font-medium">{{ $paymentSettings['instructions'] }}</p>
                                    </div>
                                </div>

                                <!-- Payment Proof Screenshot Upload Box (رفع صورة سكرين شوت للدفع) -->
                                <div id="receiptUploadContainer" class="space-y-3 pt-1 transition-all">
                                    <label class="block text-xs font-black text-slate-800">
                                        <span>رفع صورة سكرين شوت إشعار التحويل</span>
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <!-- Upload Area Dropzone -->
                                    <div class="relative border-2 border-dashed border-slate-300 hover:border-blue-600 rounded-2xl p-4 sm:p-6 text-center transition-all bg-slate-50/60 hover:bg-blue-50/20 cursor-pointer" onclick="document.getElementById('payment_receipt').click()">
                                        <input type="file" name="payment_receipt" id="payment_receipt" accept="image/png, image/jpeg, image/jpg, image/webp" onchange="previewReceipt(this)" class="hidden">
                                        
                                        <!-- Empty State Content -->
                                        <div id="uploadEmptyState" class="space-y-2">
                                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto shadow-2xs border border-blue-100">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <div class="space-y-0.5">
                                                <span class="text-xs font-black text-slate-800 block">اضغط هنا لرفع صورة سكرين شوت التحويل أو الإيصال</span>
                                                <span class="text-[10px] text-slate-400 font-medium block">يدعم صيغ JPG, PNG, WEBP بحجم أقصى 5 ميجابايت</span>
                                            </div>
                                        </div>

                                        <!-- Preview State Content (Hidden by default) -->
                                        <div id="uploadPreviewState" class="hidden flex flex-col items-center gap-2">
                                            <div class="relative group">
                                                <img id="receiptPreviewImg" src="" alt="معاينة إشعار الدفع" class="max-h-48 rounded-xl border border-slate-200 shadow-sm object-contain mx-auto">
                                                <button type="button" onclick="event.stopPropagation(); removeReceipt();" class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-red-600 text-white flex items-center justify-center text-xs font-bold shadow-md hover:bg-red-700 transition-colors">
                                                    ✕
                                                </button>
                                            </div>
                                            <span class="text-xs font-black text-blue-700 flex items-center gap-1 mt-1">
                                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                <span>تم اختيار صورة الإشعار بنجاح! انقر للاستبدال</span>
                                            </span>
                                        </div>

                                    </div>
                                    <span id="receipt_error" class="text-red-500 text-[11px] font-bold hidden block">يرجى رفع صورة سكرين شوت إشعار التحويل لتأكيد الحجز.</span>

                                    <!-- Optional Transfer Reference / Phone transferred from -->
                                    <div class="pt-1">
                                        <label class="block text-[11px] font-bold text-slate-600 mb-1">رقم الهاتف المحول منه أو رقم العملية (اختياري)</label>
                                        <input type="text" name="payment_reference" id="payment_reference" value="{{ old('payment_reference') }}" placeholder="مثال: رقم 010xxxxxxxx المحول منه أو كود المعاملة" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-xs font-medium text-slate-800 outline-none transition-all bg-white">
                                    </div>

                                </div>

                            </div>

                            <!-- Notes -->
                            <div class="pt-2">
                                <label class="block text-xs font-black text-slate-700 mb-1.5">ملاحظات وشكوى الطفل أو ما يلاحظه ولي الأمر (اختياري)</label>
                                <textarea name="notes" id="notes" rows="3" placeholder="اكتب هنا أي تفاصيل تود إخبار الأخصائي بها (مثل: تأخر في نطق الجمل، تشتت الانتباه، صعوبة في التعلم...)" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-xs sm:text-sm font-medium outline-none transition-all">{{ old('notes') }}</textarea>
                            </div>

                        </div>

                        <!-- Step 2 Footer Navigation & Submission Action Bar -->
                        <div class="pt-6 border-t border-slate-100 flex items-center justify-between gap-3">
                            <button type="button" onclick="goToStep(1)" class="px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs sm:text-sm font-bold flex items-center gap-1.5 transition-all cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                <span>السابق</span>
                            </button>

                            <button type="submit" id="submitBtn" class="px-8 py-3.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-black flex items-center gap-2 shadow-lg shadow-blue-600/25 transition-all hover:scale-[1.02] active:scale-95 cursor-pointer">
                                <span>تأكيد وإرسال طلب الحجز</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>
</div>

<!-- Interactive 2-Step Wizard & Dynamic Branch Script -->
<script>
    let currentStep = 1;
    const branchesData = @json($branchesList);

    function validateStep1() {
        let valid = true;
        
        const childName = document.getElementById('child_name');
        const childAge = document.getElementById('child_age');
        const parentName = document.getElementById('parent_name');
        const parentPhone = document.getElementById('parent_phone');

        // Check child name
        if (!childName.value.trim()) {
            document.getElementById('child_name_error').classList.remove('hidden');
            childName.classList.add('border-red-500');
            valid = false;
        } else {
            document.getElementById('child_name_error').classList.add('hidden');
            childName.classList.remove('border-red-500');
        }

        // Check child age
        if (!childAge.value.trim()) {
            document.getElementById('child_age_error').classList.remove('hidden');
            childAge.classList.add('border-red-500');
            valid = false;
        } else {
            document.getElementById('child_age_error').classList.add('hidden');
            childAge.classList.remove('border-red-500');
        }

        // Check parent name
        if (!parentName.value.trim()) {
            document.getElementById('parent_name_error').classList.remove('hidden');
            parentName.classList.add('border-red-500');
            valid = false;
        } else {
            document.getElementById('parent_name_error').classList.add('hidden');
            parentName.classList.remove('border-red-500');
        }

        // Check parent phone
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

            stepCircle1.className = "w-10 h-10 rounded-full flex items-center justify-center font-black text-sm transition-all duration-300 bg-blue-600 text-white shadow-md ring-4 ring-blue-100";
            stepLabel1.className = "text-[11px] font-black text-slate-800 mt-1.5 whitespace-nowrap";

            stepCircle2.className = "w-10 h-10 rounded-full flex items-center justify-center font-black text-sm transition-all duration-300 bg-slate-100 text-slate-400 border border-slate-200";
            stepLabel2.className = "text-[11px] font-bold text-slate-400 mt-1.5 whitespace-nowrap";

            progressFill.style.width = "0%";
        } else if (step === 2) {
            step1Content.classList.add('hidden');
            step2Content.classList.remove('hidden');

            stepCircle1.className = "w-10 h-10 rounded-full flex items-center justify-center font-black text-sm transition-all duration-300 bg-blue-600 text-white shadow-sm";
            stepLabel1.className = "text-[11px] font-bold text-slate-600 mt-1.5 whitespace-nowrap";

            stepCircle2.className = "w-10 h-10 rounded-full flex items-center justify-center font-black text-sm transition-all duration-300 bg-blue-600 text-white shadow-md ring-4 ring-blue-100";
            stepLabel2.className = "text-[11px] font-black text-slate-800 mt-1.5 whitespace-nowrap";

            progressFill.style.width = "100%";
        }
    }

    // Handle Session Format Change (in_center vs online)
    function handleFormatChange() {
        const formatSelect = document.getElementById('session_format');
        const branchCol = document.getElementById('branchCol');
        const branchSelect = document.getElementById('branch_id');
        const container = document.getElementById('sessionFormatBranchContainer');
        const onlineWidget = document.getElementById('onlineInfoWidget');

        if (!formatSelect) return;

        if (formatSelect.value === 'online') {
            if (branchCol) branchCol.classList.add('hidden');
            if (branchSelect) {
                branchSelect.removeAttribute('required');
            }
            if (container) {
                container.classList.remove('sm:grid-cols-2');
                container.classList.add('grid-cols-1');
            }
            if (onlineWidget) onlineWidget.classList.remove('hidden');

            // Find online branch in branchesData
            const onlineBranch = branchesData.find(b => b.is_online);
            if (onlineBranch) {
                updatePricingAndSlots(onlineBranch);
            }
        } else {
            if (branchCol) branchCol.classList.remove('hidden');
            if (branchSelect) {
                branchSelect.setAttribute('required', 'required');
            }
            if (container) {
                container.classList.remove('grid-cols-1');
                container.classList.add('sm:grid-cols-2');
            }
            if (onlineWidget) onlineWidget.classList.add('hidden');
            handleBranchChange();
        }
    }

    // Handle Branch Change
    function handleBranchChange() {
        const branchSelect = document.getElementById('branch_id');
        if (!branchSelect) return;

        const selectedOption = branchSelect.options[branchSelect.selectedIndex];
        if (!selectedOption) return;

        const branchId = selectedOption.value;
        const branch = branchesData.find(b => b.id == branchId);
        if (branch) {
            updatePricingAndSlots(branch);
        }
    }

    function updatePricingAndSlots(branch) {
        // Update Price Display
        const priceDisplay = document.getElementById('priceDisplay');
        if (priceDisplay && branch.price) {
            priceDisplay.innerText = parseFloat(branch.price).toFixed(2);
        }

        // Update Days Display
        const daysDisplay = document.getElementById('daysDisplay');
        if (daysDisplay) {
            const days = branch.days_list || (Array.isArray(branch.available_days) ? branch.available_days : ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس']);
            daysDisplay.innerText = days.join(' • ');
        }

        // Update Time Slots Dropdown
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
    }

    // Handle Payment Method Selection & UI Border Highlighting
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

    // Preview Receipt Screenshot
    function previewReceipt(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('receiptPreviewImg').src = e.target.result;
                document.getElementById('uploadEmptyState').classList.add('hidden');
                document.getElementById('uploadPreviewState').classList.remove('hidden');
                document.getElementById('receipt_error').classList.add('hidden');
            };

            reader.readAsDataURL(file);
        }
    }

    // Remove Receipt Screenshot
    function removeReceipt() {
        const input = document.getElementById('payment_receipt');
        input.value = '';
        document.getElementById('receiptPreviewImg').src = '';
        document.getElementById('uploadPreviewState').classList.add('hidden');
        document.getElementById('uploadEmptyState').classList.remove('hidden');
    }

    // Copy Text to Clipboard with Tooltip
    function copyText(text, btn) {
        navigator.clipboard.writeText(text).then(function() {
            const oldHtml = btn.innerHTML;
            btn.innerHTML = '<span>تم النسخ! ✓</span>';
            btn.classList.add('text-emerald-700', 'border-emerald-300');
            setTimeout(function() {
                btn.innerHTML = oldHtml;
                btn.classList.remove('text-emerald-700', 'border-emerald-300');
            }, 2000);
        });
    }

    // Form Submission Validation for Payment Receipt
    document.addEventListener('DOMContentLoaded', function() {
        handleFormatChange();

        const form = document.getElementById('bookingForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                const receiptInput = document.getElementById('payment_receipt');

                if (!receiptInput.files || receiptInput.files.length === 0) {
                    e.preventDefault();
                    document.getElementById('receipt_error').classList.remove('hidden');
                    receiptInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return false;
                }
            });
        }
    });
</script>
@endsection
