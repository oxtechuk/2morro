@extends('layouts.storefront')

@section('title', 'إتمام الشراء | متجر تمورو')

@section('content')
<div class="bg-white py-8">
    <div class="max-w-7xl mx-auto px-4">
        
        <h1 class="text-2xl font-black text-[#2563ea] mb-4">إتمام الشراء والطلب</h1>

        <!-- Center Awareness & Advice Banner -->
        <div class="mb-8 p-5 sm:p-6 rounded-3xl shadow-lg flex flex-col md:flex-row items-center justify-between gap-4"
             style="background: linear-gradient(135deg, #091326 0%, #0E224F 45%, #17387A 100%) !important; color: #ffffff !important; border: 1px solid #1E3A8A !important;">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-inner text-amber-400 bg-amber-400/20 border border-amber-400/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="flex flex-col text-right">
                    <span class="text-xs sm:text-sm font-black leading-snug" style="color: #ffffff !important;">« لما أبنك مايبقاش زي اللي ف عمره من الأطفال اوعي تترددي لحظة أنك توديه مركز لأن الساعة بتفرق ف تأخيره »</span>
                    <span class="text-[11px] font-semibold mt-1" style="color: #93C5FD !important;">مركز 2morro لتنمية مهارات الطفل • قيادة وإشراف: أ. هبة الله أكرم • فروعنا بالإسكندرية (الإبراهيمية - البيطاش - سيدي بشر)</span>
                </div>
            </div>
            <a href="https://linktr.ee/hebaalla?subscribe" target="_blank" class="px-4 py-2 text-white text-xs font-black rounded-xl whitespace-nowrap shadow-sm transition-all hover:scale-105 flex items-center gap-1.5 flex-shrink-0"
               style="background: linear-gradient(135deg, #F97316 0%, #059669 100%);">
                <span>صفحة روابط المركز والاشتراك</span>
                <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>

        <!-- Validation & Status Alerts -->
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 text-xs font-bold p-4 rounded-xl mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-xs font-bold p-4 rounded-xl mb-6">
                <ul class="list-disc pr-4 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8" x-data="{ 
            paymentMethod: 'cod',
            copiedText: null, 
            copyToClipboard(text, id) { 
                navigator.clipboard.writeText(text); 
                this.copiedText = id; 
                setTimeout(() => { this.copiedText = null; }, 2500); 
            }
        }">
            
            <!-- Checkout Form (Right side, span 7) -->
            <div class="lg:col-span-7">
                <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
                    @csrf

                    <!-- 1. Customer Info -->
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                        <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-1.5">
                            <span class="w-1.5 h-4 bg-[#2563ea] rounded-full"></span>
                            البيانات الشخصية
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] font-bold text-slate-400">الاسم بالكامل *</label>
                                <input type="text" name="customer_name" value="{{ old('customer_name', Auth::user()?->name) }}" required class="border-slate-300 rounded-lg text-xs py-2.5 px-4 text-slate-600 focus:border-blue-600 focus:ring-0">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] font-bold text-slate-400">رقم الهاتف (نشط ومتاح للواتساب) *</label>
                                <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required class="border-slate-300 rounded-lg text-xs py-2.5 px-4 text-slate-600 focus:border-blue-600 focus:ring-0" placeholder="مثال: 01550504512">
                            </div>
                        </div>
                        <div class="flex flex-col gap-1 mt-4">
                            <label class="text-[10px] font-bold text-slate-400">البريد الإلكتروني *</label>
                            <input type="email" name="customer_email" value="{{ old('customer_email', Auth::user()?->email) }}" required class="border-slate-300 rounded-lg text-xs py-2.5 px-4 text-slate-600 focus:border-blue-600 focus:ring-0">
                        </div>
                    </div>

                    <!-- 2. Shipping Details -->
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                        <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-1.5">
                            <span class="w-1.5 h-4 bg-[#00A896] rounded-full"></span>
                            تفاصيل الشحن والتوصيل
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] font-bold text-slate-400">المحافظة *</label>
                                <select name="shipping_governorate" required class="border-slate-300 rounded-lg text-xs py-2.5 px-4 text-slate-600 focus:border-blue-600 focus:ring-0">
                                    <option value="">اختر المحافظة...</option>
                                    <option value="الاسكندرية" selected>الاسكندرية</option>
                                    <option value="القاهرة">القاهرة</option>
                                    <option value="الجيزة">الجيزة</option>
                                    <option value="القليوبية">القليوبية</option>
                                    <option value="الشرقية">الشرقية</option>
                                    <option value="الدقهلية">الدقهلية</option>
                                    <option value="الغربية">الغربية</option>
                                    <option value="البحيرة">البحيرة</option>
                                    <option value="المنوفية">المنوفية</option>
                                    <option value="دمياط">دمياط</option>
                                    <option value="بورسعيد">بورسعيد</option>
                                    <option value="الإسماعيلية">الإسماعيلية</option>
                                    <option value="السويس">السويس</option>
                                    <option value="الفيوم">الفيوم</option>
                                    <option value="بني سويف">بني سويف</option>
                                    <option value="المنيا">المنيا</option>
                                    <option value="أسيوط">أسيوط</option>
                                    <option value="سوهاج">سوهاج</option>
                                    <option value="قنا">قنا</option>
                                    <option value="الأقصر">الأقصر</option>
                                    <option value="أسوان">أسوان</option>
                                    <option value="كفر الشيخ">كفر الشيخ</option>
                                    <option value="مطروح">مطروح</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] font-bold text-slate-400">المدينة / المنطقة</label>
                                <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" placeholder="مثال: الإبراهيمية / العجمي / سيدي بشر" class="border-slate-300 rounded-lg text-xs py-2.5 px-4 text-slate-600 focus:border-blue-600 focus:ring-0">
                            </div>
                        </div>
                        <div class="flex flex-col gap-1 mt-4">
                            <label class="text-[10px] font-bold text-slate-400">العنوان بالتفصيل (اسم الشارع، رقم العمارة، رقم الشقة) *</label>
                            <textarea name="shipping_address" required rows="2" class="border-slate-300 rounded-lg text-xs py-2.5 px-4 text-slate-600 focus:border-blue-600 focus:ring-0">{{ old('shipping_address') }}</textarea>
                        </div>
                    </div>

                    <!-- 3. Payment Method -->
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                        <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-1.5">
                            <span class="w-1.5 h-4 bg-[#EF4444] rounded-full"></span>
                            طريقة الدفع وتحصيل الحساب
                        </h3>
                        
                        <div class="flex flex-col gap-4">
                            
                            <!-- Option 1: COD -->
                            <label :class="paymentMethod === 'cod' ? 'border-blue-600 ring-2 ring-blue-100 bg-white' : 'border-slate-200 bg-white hover:border-slate-300'" class="flex items-start gap-3.5 p-4 rounded-2xl border cursor-pointer select-none transition-all">
                                <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" class="mt-1 text-blue-600 focus:ring-0">
                                <div class="flex flex-col leading-tight flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold text-slate-800">الدفع عند الاستلام (Cash on Delivery)</span>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">COD</span>
                                    </div>
                                    <span class="text-[11px] text-slate-500 font-semibold mt-1.5 leading-relaxed">
                                        الدفع نقداً للمندوب عند استلام الشحنة أمام باب منزلك (متاح فقط للمنتجات المادية).
                                    </span>
                                </div>
                            </label>

                            <!-- Option 2: InstaPay -->
                            <label :class="paymentMethod === 'instapay' ? 'border-blue-600 ring-2 ring-blue-100 bg-white' : 'border-slate-200 bg-white hover:border-slate-300'" class="flex items-start gap-3.5 p-4 rounded-2xl border cursor-pointer select-none transition-all">
                                <input type="radio" name="payment_method" value="instapay" x-model="paymentMethod" class="mt-1 text-blue-600 focus:ring-0">
                                <div class="flex flex-col leading-tight flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-black text-slate-800 flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            <span>الدفع عبر تطبيق إنستاباي (InstaPay)</span>
                                        </span>
                                        <span class="text-[10px] font-extrabold px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-700">تحويل فوري 0% رسوم</span>
                                    </div>
                                    <span class="text-[11px] text-slate-500 font-semibold mt-1.5 leading-relaxed">
                                        حول إجمالي المبلغ عبر تطبيق InstaPay إلى عنوان الدفع الرسمي أدناه وارفع صورة التحويل:
                                    </span>
                                    
                                    <!-- InstaPay Handle Box -->
                                    <div class="mt-3 p-3.5 bg-purple-50/60 rounded-2xl border border-purple-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                                        <div class="flex items-center gap-2 text-xs">
                                            <span class="font-bold text-slate-600">عنوان الدفع (IPA):</span>
                                            <code class="font-black text-purple-900 bg-white px-3 py-1 rounded-lg border border-purple-200 select-all tracking-wide text-xs" dir="ltr">{{ $instapayAddress }}</code>
                                        </div>
                                        <button type="button" @click.stop="copyToClipboard('{{ $instapayAddress }}', 'instapay')" class="text-[11px] font-bold px-3.5 py-1.5 bg-white hover:bg-purple-100 text-purple-700 border border-purple-200 rounded-xl transition-colors flex items-center gap-1.5 shadow-2xs">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            <span x-text="copiedText === 'instapay' ? 'تم النسخ بنجاح' : 'نسخ المعرف'"></span>
                                        </button>
                                    </div>
                                </div>
                            </label>

                            <!-- Option 3: Wallet (Vodafone Cash) -->
                            <label :class="paymentMethod === 'wallet' ? 'border-blue-600 ring-2 ring-blue-100 bg-white' : 'border-slate-200 bg-white hover:border-slate-300'" class="flex items-start gap-3.5 p-4 rounded-2xl border cursor-pointer select-none transition-all">
                                <input type="radio" name="payment_method" value="wallet" x-model="paymentMethod" class="mt-1 text-blue-600 focus:ring-0">
                                <div class="flex flex-col leading-tight flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-black text-slate-800 flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                            <span>الدفع عبر المحافظ الإلكترونية (فودافون كاش / اتصالات / أورانج / وي)</span>
                                        </span>
                                        <span class="text-[10px] font-extrabold px-2.5 py-0.5 rounded-full bg-red-50 text-red-600">فودافون كاش</span>
                                    </div>
                                    <span class="text-[11px] text-slate-500 font-semibold mt-1.5 leading-relaxed">
                                        حول المبلغ الإجمالي إلى رقم محفظة المركز المعتمدة أدناه ثم ارفع صورة التحويل:
                                    </span>
                                    
                                    <!-- Clean Single Wallet Box (No cluttered multi-branch numbers) -->
                                    <div class="mt-3.5 p-3.5 bg-red-50/50 rounded-2xl border border-red-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                                        <div class="flex items-center gap-2 text-xs">
                                            <span class="font-bold text-slate-600">رقم المحفظة (فودافون كاش):</span>
                                            <code class="font-black text-red-700 bg-white px-3 py-1 rounded-lg border border-red-200 select-all tracking-wider text-xs" dir="ltr">{{ $walletNumber }}</code>
                                        </div>
                                        <button type="button" @click.stop="copyToClipboard('{{ $walletNumber }}', 'w_main')" class="text-[11px] font-bold px-3.5 py-1.5 bg-white hover:bg-red-50 text-red-700 border border-red-200 rounded-xl transition-colors flex items-center gap-1.5 shadow-2xs">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            <span x-text="copiedText === 'w_main' ? 'تم النسخ بنجاح' : 'نسخ الرقم'"></span>
                                        </button>
                                    </div>

                                </div>
                            </label>

                            <!-- Option 4: Bank Transfer / IBAN -->
                            <label :class="paymentMethod === 'bank' ? 'border-blue-600 ring-2 ring-blue-100 bg-white' : 'border-slate-200 bg-white hover:border-slate-300'" class="flex items-start gap-3.5 p-4 rounded-2xl border cursor-pointer select-none transition-all">
                                <input type="radio" name="payment_method" value="bank" x-model="paymentMethod" class="mt-1 text-blue-600 focus:ring-0">
                                <div class="flex flex-col leading-tight flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-black text-slate-800 flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                                            <span>التحويل البنكي المباشر (Bank Transfer / IBAN)</span>
                                        </span>
                                        <span class="text-[10px] font-extrabold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700">حساب بنكي / آيبان</span>
                                    </div>
                                    <span class="text-[11px] text-slate-500 font-semibold mt-1.5 leading-relaxed">
                                        حول المبلغ من حسابك البنكي أو عبر تطبيق البنك باستخدام الآيبان (IBAN) وارفع صورة الإيصال:
                                    </span>
                                    
                                    <!-- Bank & IBAN Details Box -->
                                    <div class="mt-3.5 p-4 bg-emerald-50/50 rounded-2xl border border-emerald-100 space-y-3">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                            <div>
                                                <span class="text-slate-500 font-bold">اسم البنك:</span>
                                                <span class="font-black text-slate-800 me-1">{{ $bankName }}</span>
                                            </div>
                                            <div>
                                                <span class="text-slate-500 font-bold">اسم المستفيد:</span>
                                                <span class="font-black text-slate-800 me-1">{{ $bankAccountName }}</span>
                                            </div>
                                        </div>

                                        <!-- IBAN Code Row -->
                                        <div class="pt-2 border-t border-emerald-100/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2.5">
                                            <div class="flex items-center gap-2 text-xs flex-wrap">
                                                <span class="font-bold text-slate-600">رقم الآيبان (IBAN):</span>
                                                <code class="font-black text-emerald-900 bg-white px-3 py-1 rounded-lg border border-emerald-200 select-all tracking-wider text-xs font-mono" dir="ltr">{{ $bankIban }}</code>
                                            </div>
                                            <button type="button" @click.stop="copyToClipboard('{{ $bankIban }}', 'iban')" class="text-[11px] font-bold px-3 py-1.5 bg-white hover:bg-emerald-100 text-emerald-800 border border-emerald-200 rounded-xl transition-colors flex items-center gap-1.5 shadow-2xs">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                                <span x-text="copiedText === 'iban' ? 'تم النسخ بنجاح' : 'نسخ IBAN'"></span>
                                            </button>
                                        </div>

                                        @if(!empty($bankAccountNumber))
                                            <div class="pt-2 border-t border-emerald-100/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 text-xs">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-slate-500 font-bold">رقم الحساب:</span>
                                                    <code class="font-bold text-slate-800 bg-white px-2.5 py-0.5 rounded border border-emerald-200 font-mono" dir="ltr">{{ $bankAccountNumber }}</code>
                                                </div>
                                                @if(!empty($bankSwift))
                                                    <div class="flex items-center gap-1.5">
                                                        <span class="text-slate-500 font-bold">سويفت كود (SWIFT):</span>
                                                        <span class="font-bold text-slate-700 font-mono">{{ $bankSwift }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </label>

                        </div>

                        <!-- 4. Screenshot Upload & WhatsApp confirmation (Conditional) -->
                        <div x-show="paymentMethod === 'instapay' || paymentMethod === 'wallet' || paymentMethod === 'bank'" class="mt-6 p-6 rounded-3xl bg-gradient-to-b from-blue-50/80 to-indigo-50/40 border border-blue-200 flex flex-col gap-4" x-transition>
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#2563ea] animate-pulse"></span>
                                <h4 class="text-xs font-black text-[#2563ea]">برجاء إرفاق لقطة شاشة لإثبات الدفع والتحويل (Screenshot) *</h4>
                            </div>
                            
                            <p class="text-[11px] text-slate-600 font-semibold leading-relaxed">
                                من أجل تسريع مراجعة وتأكيد طلبك وتجهيز الشحنة أو إرسال ملفات الشيتات الرقمية للتحميل الفوري، يرجى إرفاق إيصال التحويل الناجح أدناه أو إرساله مباشرة لفريق الدعم على رقم الواتساب بعد الطلب.
                            </p>
                            
                            <div class="flex flex-col sm:flex-row items-center gap-3">
                                <input type="file" name="payment_screenshot" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-[#2563ea] file:text-white hover:file:bg-blue-700 transition-all cursor-pointer">
                                
                                <a href="https://wa.me/201550504512?text={{ urlencode('مرحباً، أود تأكيد الطلب وإرسال إيصال التحويل.') }}" target="_blank" class="w-full sm:w-auto px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs rounded-xl transition-colors flex items-center justify-center gap-1.5 whitespace-nowrap shadow-xs">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.458L0 24zm6.002-3.693c1.615.957 3.178 1.462 4.736 1.463 5.485.002 9.948-4.463 9.95-9.953.001-2.66-1.025-5.16-2.887-7.026C16.001 2.923 13.506 1.897 10.85 1.897c-5.486 0-9.949 4.464-9.953 9.954-.001 2.052.541 4.06 1.567 5.814l-1.026 3.75 3.829-1.004z"></path></svg>
                                    <span>إرسال الإيصال لواتساب المركز</span>
                                </a>
                            </div>
                        </div>

                    </div>

                    <!-- Notes -->
                    <div class="flex flex-col gap-1">
                        <label class="text-[10px] font-bold text-slate-400">ملاحظات إضافية على الطلب</label>
                        <textarea name="notes" rows="2" placeholder="أي ملاحظات تود كتابتها للمندوب أو الإدارة أو تفاصيل تخص الطفل..." class="border-slate-300 rounded-lg text-xs py-2.5 px-4 text-slate-600 focus:border-blue-600 focus:ring-0">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Submit Order Button -->
                    <button type="submit" class="w-full bg-[#2563ea] hover:bg-blue-700 text-white font-bold text-sm py-4 px-8 rounded-2xl flex items-center justify-center gap-2 transition-all shadow-lg hover:shadow-xl">
                        <span>تأكيد وإرسال الطلب الآن</span>
                        <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>

            <!-- Order Summary (Left side, span 5) -->
            <div class="lg:col-span-5 flex flex-col gap-6">
                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-200">
                    <h3 class="text-sm font-bold text-slate-800 mb-6 flex items-center gap-1.5">
                        <span class="w-1.5 h-4 bg-[#2563ea] rounded-full"></span>
                        ملخص السلة والمنتجات
                    </h3>

                    <!-- Cart Items List -->
                    <div class="flex flex-col gap-4 max-h-[300px] overflow-y-auto pr-2">
                        @foreach($cart as $item)
                            <div class="flex items-center gap-3 pb-4 border-b border-slate-200/60 last:border-0">
                                <div class="w-12 h-12 bg-white rounded-xl border border-slate-200 overflow-hidden p-1 flex-shrink-0 flex items-center justify-center">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-contain">
                                    @else
                                        <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    @endif
                                </div>
                                <div class="flex-grow leading-tight">
                                    <h4 class="text-xs font-bold text-slate-700 limit-lines-1">{{ $item['name'] }}</h4>
                                    <span class="text-[10px] text-slate-400 font-semibold mt-1">الكمية: {{ $item['quantity'] }} • {{ $item['type'] === 'digital' ? 'رقمي PDF' : 'مادي' }}</span>
                                </div>
                                <span class="text-xs font-bold text-slate-800 flex-shrink-0">{{ number_format($item['price'] * $item['quantity'], 2) }} ج.م</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Receipt Calculations -->
                    <div class="mt-6 pt-6 border-t border-slate-200 flex flex-col gap-3.5 text-xs">
                        <div class="flex justify-between items-center text-slate-500 font-bold">
                            <span>المجموع الفرعي:</span>
                            <span>{{ number_format($subtotal, 2) }} ج.م</span>
                        </div>

                        <div class="flex justify-between items-center text-slate-500 font-bold">
                            <span>رسوم التوصيل والشحن:</span>
                            @if($shippingFee == 0)
                                <span class="text-green-600 bg-green-50 px-2 py-0.5 rounded-full border border-green-100 font-black">شحن مجاني</span>
                            @else
                                <span>{{ number_format($shippingFee, 2) }} ج.م</span>
                            @endif
                        </div>

                        <!-- Free shipping progress bar -->
                        @if($physicalCount > 0 && $subtotal < 550)
                            <div class="bg-blue-50/50 border border-blue-100 p-4 rounded-2xl flex flex-col gap-2 mt-2">
                                <div class="flex justify-between items-center text-[10px] font-extrabold text-[#2563ea]">
                                    <span>متبقي {{ number_format(550 - $subtotal, 2) }} جنيه للحصول على شحن مجاني!</span>
                                    <span>{{ round(($subtotal / 550) * 100) }}%</span>
                                </div>
                                <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-[#2563ea] h-full rounded-full transition-all duration-500" style="width: {{ ($subtotal / 550) * 100 }}%"></div>
                                </div>
                            </div>
                        @endif

                        <div class="flex justify-between items-center text-slate-800 font-black text-sm pt-4 border-t border-slate-200">
                            <span>الإجمالي الكلي للطلب:</span>
                            <span class="text-[#EF4444] font-black">{{ number_format($total, 2) }} ج.م</span>
                        </div>
                    </div>
                </div>

                <!-- Safe checkout warning -->
                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-200 flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#2563ea] flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div class="flex flex-col gap-1 leading-snug">
                        <h4 class="text-xs font-bold text-slate-800">حماية البيانات والأمان</h4>
                        <p class="text-[10px] text-slate-400 font-semibold leading-normal">
                            بيانات الاتصال والعنوان الخاصة بك تستخدم فقط لتوصيل الشحنة. إذا كان طلبك يحتوي على شيتات رقمية، فستصلك فوراً روابط التحميل المشفرة على بريدك الإلكتروني وحسابك الشخصي.
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
