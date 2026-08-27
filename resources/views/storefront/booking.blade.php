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
            
            <!-- Right Column (Sticky Center Card & Admin Image) - 5 Cols in RTL -->
            <div class="lg:col-span-5 order-2 lg:order-1">
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden lg:sticky lg:top-24 text-right">
                    
                    <!-- Admin Managed Image -->
                    <div class="relative h-64 sm:h-72 w-full bg-slate-900 overflow-hidden">
                        <img src="{{ asset($bookingImage) }}" alt="{{ $bookingTitle }}" class="w-full h-full object-cover opacity-90 transition-transform duration-700 hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent"></div>
                        
                        <!-- Floating Badge on Image -->
                        <div class="absolute top-4 right-4 z-10">
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-black bg-blue-600/90 text-white backdrop-blur-md shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-cyan-300"></span>
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
                            <div class="flex items-center gap-3 p-3 rounded-2xl bg-blue-50/60 border border-blue-100/60 text-slate-800">
                                <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                </div>
                                <div>
                                    <span class="text-[10px] text-blue-700 block font-bold">قيادة وإشراف وتوجيه:</span>
                                    <span class="font-black text-slate-900">أ. هبة الله أكرم</span>
                                    <span class="text-[10px] text-slate-500 block">(برامج • تعليمات • إشراف • متابعة)</span>
                                </div>
                            </div>

                            <!-- Working Hours -->
                            <div class="flex items-center gap-3 p-3 rounded-2xl bg-amber-50/60 border border-amber-100/60 text-slate-800">
                                <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <span class="text-[10px] text-amber-700 block font-bold">مواعيد العمل الرسمية:</span>
                                    <span class="font-black text-slate-900">من 12:00 ظهراً إلى 9:00 مساءً</span>
                                    <span class="text-[10px] text-slate-500 block">(يومياً عدا الجمعة)</span>
                                </div>
                            </div>

                            <!-- Branches -->
                            <div class="flex items-center gap-3 p-3 rounded-2xl bg-emerald-50/60 border border-emerald-100/60 text-slate-800">
                                <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <span class="text-[10px] text-emerald-700 block font-bold">فروع الإسكندرية وأونلاين:</span>
                                    <span class="font-bold text-slate-900">الإبراهيمية • أول البيطاش • سيدي بشر</span>
                                </div>
                            </div>

                        </div>

                        <!-- Direct WhatsApp Contact Button -->
                        <div class="pt-2">
                            <a href="https://wa.me/201550504512" target="_blank" class="w-full py-3 px-4 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-black flex items-center justify-center gap-2 shadow-xs transition-all hover:scale-[1.02] active:scale-95">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.458L0 24zm6.002-3.693c1.615.957 3.178 1.462 4.736 1.463 5.485.002 9.948-4.463 9.95-9.953.001-2.66-1.025-5.16-2.887-7.026C16.001 2.923 13.506 1.897 10.85 1.897c-5.486 0-9.949 4.464-9.953 9.954-.001 2.052.541 4.06 1.567 5.814l-1.026 3.75 3.829-1.004z"></path></svg>
                                <span>استفسار فوري عبر واتساب (01550504512)</span>
                            </a>
                        </div>

                    </div>

                </div>
            </div>

            <!-- Left Column (2-Step Wizard Booking Form) - 7 Cols in RTL -->
            <div class="lg:col-span-7 order-1 lg:order-2">
                
                <!-- Form Header -->
                <div class="mb-6 text-right">
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mb-1" style>
                        طلب حجز استشارة وتقييم
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium">
                        يرجى ملء البيانات في خطوتين بسيطتين لتنسيق الموعد المناسب بدقة
                    </p>
                </div>

                <!-- 2-Step Progress Stepper Indicator (Exact Style of Provided Mockup) -->
                <div class="flex items-center justify-center max-w-sm mx-auto mb-8 relative px-4" dir="ltr">
                    
                    <!-- Connecting Bar Background -->
                    <div class="absolute top-1/2 left-10 right-10 -translate-y-1/2 h-1 bg-slate-200 z-0"></div>
                    
                    <!-- Active Connecting Bar Progress Fill -->
                    <div id="stepProgressFill" class="absolute top-1/2 left-10 -translate-y-1/2 h-1 bg-[#F97316] transition-all duration-300 z-0" style="width: 0%;"></div>

                    <!-- Step 1 Indicator -->
                    <div class="relative z-10 flex flex-col items-center">
                        <button type="button" onclick="goToStep(1)" id="stepCircle1" class="w-10 h-10 rounded-full flex items-center justify-center font-black text-sm transition-all duration-300 bg-[#F97316] text-white shadow-md ring-4 ring-orange-100">
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
                        <span id="stepLabel2" class="text-[11px] font-bold text-slate-400 mt-1.5 whitespace-nowrap">تفاصيل الجلسة والموعد</span>
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

                <!-- Main Form Card Container -->
                <form id="bookingForm" action="{{ route('booking.store') }}" method="POST" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm text-right">
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
                                <input type="text" name="child_name" id="child_name" value="{{ old('child_name') }}" required placeholder="مثال: يوسف أحمد محمد" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-[#F97316] focus:ring-2 focus:ring-orange-100 text-xs sm:text-sm font-medium outline-none transition-all">
                                <span id="child_name_error" class="text-red-500 text-[11px] font-bold hidden mt-1 block">يرجى إدخال اسم الطفل.</span>
                            </div>

                            <!-- Child Age -->
                            <div>
                                <label class="block text-xs font-black text-slate-700 mb-1.5">عمر الطفل <span class="text-red-500">*</span></label>
                                <input type="text" name="child_age" id="child_age" value="{{ old('child_age') }}" required placeholder="مثال: 4 سنوات و 6 أشهر" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-[#F97316] focus:ring-2 focus:ring-orange-100 text-xs sm:text-sm font-medium outline-none transition-all">
                                <span id="child_age_error" class="text-red-500 text-[11px] font-bold hidden mt-1 block">يرجى إدخال عمر الطفل.</span>
                            </div>

                            <!-- Parent Name -->
                            <div>
                                <label class="block text-xs font-black text-slate-700 mb-1.5">اسم ولي الأمر <span class="text-red-500">*</span></label>
                                <input type="text" name="parent_name" id="parent_name" value="{{ old('parent_name', auth()->user()?->name) }}" required placeholder="مثال: أحمد محمد علي" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-[#F97316] focus:ring-2 focus:ring-orange-100 text-xs sm:text-sm font-medium outline-none transition-all">
                                <span id="parent_name_error" class="text-red-500 text-[11px] font-bold hidden mt-1 block">يرجى إدخال اسم ولي الأمر.</span>
                            </div>

                            <!-- Parent Phone -->
                            <div>
                                <label class="block text-xs font-black text-slate-700 mb-1.5">رقم الهاتف والواتساب <span class="text-red-500">*</span></label>
                                <input type="tel" name="parent_phone" id="parent_phone" value="{{ old('parent_phone', auth()->user()?->phone) }}" required placeholder="010xxxxxxxx" dir="ltr" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-[#F97316] focus:ring-2 focus:ring-orange-100 text-xs sm:text-sm font-medium outline-none transition-all text-right">
                                <span id="parent_phone_error" class="text-red-500 text-[11px] font-bold hidden mt-1 block">يرجى إدخال رقم الهاتف للتواصل.</span>
                            </div>

                            <!-- Parent Email (Optional) -->
                            <div>
                                <label class="block text-xs font-black text-slate-700 mb-1.5">البريد الإلكتروني (اختياري)</label>
                                <input type="email" name="parent_email" id="parent_email" value="{{ old('parent_email', auth()->user()?->email) }}" placeholder="name@example.com" dir="ltr" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-[#F97316] focus:ring-2 focus:ring-orange-100 text-xs sm:text-sm font-medium outline-none transition-all text-right">
                            </div>

                        </div>

                        <!-- Step 1 Footer Action -->
                        <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[11px] text-slate-400 font-medium">الخطوة 1 من 2</span>
                            <button type="button" onclick="nextToStep2()" class="px-8 py-3 rounded-2xl bg-[#F97316] hover:bg-[#EA580C] text-white text-xs sm:text-sm font-black flex items-center gap-2 shadow-md shadow-orange-500/20 transition-all hover:scale-[1.02] active:scale-95">
                                <span>التالي</span>
                                <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>

                    </div>

                    <!-- STEP 2: Session & Schedule (تفاصيل الجلسة والموعد) -->
                    <div id="step2Content" class="space-y-6 hidden transition-opacity duration-300">
                        
                        <!-- Step Header -->
                        <div class="pb-4 border-b border-slate-100">
                            <h2 class="text-base sm:text-lg font-black text-slate-900">
                                تفاصيل الاستشارة وموعد المقابلة
                            </h2>
                            <p class="text-xs text-slate-400 font-medium mt-0.5">
                                حدد الخدمة وطريقة المقابلة والموعد المناسب لزيارة المركز أو الجلسة الأونلاين
                            </p>
                        </div>

                        <!-- Step 2 Form Fields -->
                        <div class="space-y-4">
                            
                            <!-- Service Type -->
                            <div>
                                <label class="block text-xs font-black text-slate-700 mb-1.5">نوع الخدمة / الجلسة المطلوبة <span class="text-red-500">*</span></label>
                                <select name="service_type" id="service_type" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-[#F97316] focus:ring-2 focus:ring-orange-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white">
                                    @foreach($services as $key => $name)
                                        <option value="{{ $key }}" {{ old('service_type') === $key ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Session Format & Branch (Grid) -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black text-slate-700 mb-1.5">طريقة المقابلة <span class="text-red-500">*</span></label>
                                    <select name="session_format" id="session_format" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-[#F97316] focus:ring-2 focus:ring-orange-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white">
                                        <option value="in_center" {{ old('session_format', 'in_center') === 'in_center' ? 'selected' : '' }}>حضورياً في المركز</option>
                                        <option value="online" {{ old('session_format') === 'online' ? 'selected' : '' }}>أونلاين عن بُعد (Zoom)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-slate-700 mb-1.5">الفرع المفضل <span class="text-red-500">*</span></label>
                                    <select name="branch" id="branch" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-[#F97316] focus:ring-2 focus:ring-orange-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white">
                                        @foreach($branches as $key => $branchName)
                                            <option value="{{ $key }}" {{ old('branch') === $key ? 'selected' : '' }}>{{ $branchName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Booking Date & Time Slot (Grid) -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black text-slate-700 mb-1.5">تاريخ المقابلة المفضل <span class="text-red-500">*</span></label>
                                    <input type="date" name="booking_date" id="booking_date" min="{{ date('Y-m-d') }}" value="{{ old('booking_date', date('Y-m-d', strtotime('+1 day'))) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-[#F97316] focus:ring-2 focus:ring-orange-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all">
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-slate-700 mb-1.5">الفترة الزمنية المفضلة <span class="text-red-500">*</span></label>
                                    <select name="booking_time" id="booking_time" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-[#F97316] focus:ring-2 focus:ring-orange-100 text-xs sm:text-sm font-bold text-slate-800 outline-none transition-all bg-white">
                                        <option value="12:00 PM - 02:00 PM">فترة الظهيرة (12:00 ظ - 02:00 ظ)</option>
                                        <option value="02:00 PM - 04:00 PM">فترة العصر (02:00 م - 04:00 م)</option>
                                        <option value="04:00 PM - 06:30 PM">بعد العصر (04:00 م - 06:30 م)</option>
                                        <option value="06:30 PM - 09:00 PM">الفترة المسائية (06:30 م - 09:00 م)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div>
                                <label class="block text-xs font-black text-slate-700 mb-1.5">ملاحظات وشكوى الطفل أو ما يلاحظه ولي الأمر (اختياري)</label>
                                <textarea name="notes" id="notes" rows="3" placeholder="اكتب هنا أي تفاصيل تود إخبار الأخصائي بها (مثل: تأخر في نطق الجمل، تشتت الانتباه، صعوبة في التعلم...)" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-[#F97316] focus:ring-2 focus:ring-orange-100 text-xs sm:text-sm font-medium outline-none transition-all">{{ old('notes') }}</textarea>
                            </div>

                        </div>

                        <!-- Step 2 Footer Navigation & Submission Action Bar -->
                        <div class="pt-6 border-t border-slate-100 flex items-center justify-between gap-3">
                            <button type="button" onclick="goToStep(1)" class="px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs sm:text-sm font-bold flex items-center gap-1.5 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                <span>السابق</span>
                            </button>

                            <button type="submit" class="px-8 py-3 rounded-2xl bg-[#F97316] hover:bg-[#EA580C] text-white text-xs sm:text-sm font-black flex items-center gap-2 shadow-md shadow-orange-500/25 transition-all hover:scale-[1.02] active:scale-95">
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

<!-- Interactive 2-Step Wizard Script -->
<script>
    let currentStep = 1;

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

            // Step 1 Active
            stepCircle1.className = "w-10 h-10 rounded-full flex items-center justify-center font-black text-sm transition-all duration-300 bg-[#F97316] text-white shadow-md ring-4 ring-orange-100";
            stepLabel1.className = "text-[11px] font-black text-slate-800 mt-1.5 whitespace-nowrap";

            // Step 2 Inactive
            stepCircle2.className = "w-10 h-10 rounded-full flex items-center justify-center font-black text-sm transition-all duration-300 bg-slate-100 text-slate-400 border border-slate-200";
            stepLabel2.className = "text-[11px] font-bold text-slate-400 mt-1.5 whitespace-nowrap";

            progressFill.style.width = "0%";
        } else if (step === 2) {
            step1Content.classList.add('hidden');
            step2Content.classList.remove('hidden');

            // Step 1 Completed
            stepCircle1.className = "w-10 h-10 rounded-full flex items-center justify-center font-black text-sm transition-all duration-300 bg-[#F97316] text-white shadow-sm";
            stepLabel1.className = "text-[11px] font-bold text-slate-600 mt-1.5 whitespace-nowrap";

            // Step 2 Active
            stepCircle2.className = "w-10 h-10 rounded-full flex items-center justify-center font-black text-sm transition-all duration-300 bg-[#F97316] text-white shadow-md ring-4 ring-orange-100";
            stepLabel2.className = "text-[11px] font-black text-slate-800 mt-1.5 whitespace-nowrap";

            progressFill.style.width = "100%";
        }
    }
</script>
@endsection
