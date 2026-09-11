@extends('layouts.storefront')

@section('title', 'إتمام الشراء | متجر تمورو')

@section('content')
<div class="bg-white py-6 sm:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        
        <!-- Page Title & Trust Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 pb-4 border-b border-slate-200">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900">إتمام الشراء والدفع</h1>
                <p class="text-xs text-slate-500 font-semibold mt-0.5">خطوة واحدة بسيطة لتأكيد طلبك وتجهيز الشحن والتنزيل الفوري.</p>
            </div>
            <div class="flex items-center gap-2 text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-lg w-fit">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                <span>دفع آمن وبيانات مشفرة 100%</span>
            </div>
        </div>

        <!-- Validation & Status Alerts -->
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 text-xs font-bold p-3.5 rounded-xl mb-5">
                {{ session('error') }}
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-xs font-bold p-3.5 rounded-xl mb-5">
                <ul class="list-disc pr-4 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8" x-data="{ 
            paymentMethod: '{{ ($codEnabled && $physicalCount > 0) ? 'cod' : 'instapay' }}',
            copiedText: null, 
            copyToClipboard(text, id) { 
                navigator.clipboard.writeText(text); 
                this.copiedText = id; 
                setTimeout(() => { this.copiedText = null; }, 2000); 
            }
        }">
            
            <!-- Checkout Form (Right side, span 7) -->
            <div class="lg:col-span-7">
                <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5">
                    @csrf

                    <!-- 1. Customer Info -->
                    <div class="bg-slate-50 p-4 sm:p-5 rounded-2xl border border-slate-200/90">
                        <h3 class="text-xs sm:text-sm font-bold text-slate-800 mb-3.5 flex items-center gap-2">
                            <span class="w-1.5 h-4 bg-[#2563ea] rounded-full"></span>
                            <span>1. البيانات الشخصية</span>
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="flex flex-col gap-1">
                                <label class="text-[11px] font-bold text-slate-600">الاسم بالكامل *</label>
                                <input type="text" name="customer_name" value="{{ old('customer_name', Auth::user()?->name) }}" required class="border-slate-300 rounded-lg text-xs py-2 px-3 text-slate-700 bg-white focus:border-blue-600 focus:ring-0">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-[11px] font-bold text-slate-600">رقم الهاتف (نشط ومتاح للواتساب) *</label>
                                <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required class="border-slate-300 rounded-lg text-xs py-2 px-3 text-slate-700 bg-white focus:border-blue-600 focus:ring-0" placeholder="مثال: 01550504512">
                            </div>
                        </div>
                        <div class="flex flex-col gap-1 mt-3">
                            <label class="text-[11px] font-bold text-slate-600">البريد الإلكتروني *</label>
                            <input type="email" name="customer_email" value="{{ old('customer_email', Auth::user()?->email) }}" required class="border-slate-300 rounded-lg text-xs py-2 px-3 text-slate-700 bg-white focus:border-blue-600 focus:ring-0">
                        </div>
                    </div>

                    <!-- 2. Shipping Details -->
                    <div class="bg-slate-50 p-4 sm:p-5 rounded-2xl border border-slate-200/90">
                        <h3 class="text-xs sm:text-sm font-bold text-slate-800 mb-3.5 flex items-center gap-2">
                            <span class="w-1.5 h-4 bg-[#2563ea] rounded-full"></span>
                            <span>2. تفاصيل الشحن والتوصيل</span>
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="flex flex-col gap-1">
                                <label class="text-[11px] font-bold text-slate-600">المحافظة *</label>
                                <select name="shipping_governorate" required class="border-slate-300 rounded-lg text-xs py-2 px-3 text-slate-700 bg-white focus:border-blue-600 focus:ring-0">
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
                                <label class="text-[11px] font-bold text-slate-600">المدينة / المنطقة</label>
                                <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" placeholder="مثال: الإبراهيمية / سيدي بشر" class="border-slate-300 rounded-lg text-xs py-2 px-3 text-slate-700 bg-white focus:border-blue-600 focus:ring-0">
                            </div>
                        </div>
                        <div class="flex flex-col gap-1 mt-3">
                            <label class="text-[11px] font-bold text-slate-600">العنوان بالتفصيل *</label>
                            <input type="text" name="shipping_address" value="{{ old('shipping_address') }}" required placeholder="اسم الشارع، رقم العمارة، رقم الشقة" class="border-slate-300 rounded-lg text-xs py-2 px-3 text-slate-700 bg-white focus:border-blue-600 focus:ring-0">
                        </div>
                    </div>

                    <!-- 3. Payment Method (Compact & Clean Accordion) -->
                    <div class="bg-slate-50 p-4 sm:p-5 rounded-2xl border border-slate-200/90">
                        <h3 class="text-xs sm:text-sm font-bold text-slate-800 mb-3.5 flex items-center gap-2">
                            <span class="w-1.5 h-4 bg-[#2563ea] rounded-full"></span>
                            <span>3. طريقة الدفع</span>
                        </h3>
                        
                        <div class="flex flex-col gap-2.5">
                            
                            @if($codEnabled && $physicalCount > 0)
                                <!-- Option 1: COD -->
                                <label :class="paymentMethod === 'cod' ? 'border-blue-600 bg-blue-50/20 shadow-xs' : 'border-slate-200 bg-white hover:border-slate-300'" class="flex items-center justify-between p-3 rounded-xl border cursor-pointer select-none transition-all">
                                    <div class="flex items-center gap-2.5">
                                        <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" class="text-blue-600 focus:ring-0">
                                        <span class="text-xs font-bold text-slate-800">الدفع عند الاستلام (COD)</span>
                                    </div>
                                    <span class="text-[10px] text-slate-500 font-semibold">نقداً للمندوب</span>
                                </label>
                            @endif

                            <!-- Option 2: InstaPay -->
                            <div :class="paymentMethod === 'instapay' ? 'border-blue-600 bg-white shadow-xs' : 'border-slate-200 bg-white hover:border-slate-300'" class="rounded-xl border transition-all overflow-hidden">
                                <label class="flex items-center justify-between p-3 cursor-pointer select-none">
                                    <div class="flex items-center gap-2.5">
                                        <input type="radio" name="payment_method" value="instapay" x-model="paymentMethod" class="text-blue-600 focus:ring-0">
                                        <span class="text-xs font-bold text-slate-800">إنستاباي (InstaPay)</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded">تحويل فوري</span>
                                </label>

                                <!-- InstaPay Drawer (Only opens when selected) -->
                                <div x-show="paymentMethod === 'instapay'" class="px-3 pb-3 pt-0 border-t border-slate-100 mt-1">
                                    <div class="flex items-center justify-between gap-2 p-2.5 bg-slate-50 rounded-lg border border-slate-200 text-xs mt-2">
                                        <div class="flex items-center gap-2 truncate">
                                            <span class="text-slate-500 font-semibold text-[11px]">معرف الدفع:</span>
                                            <code class="font-bold text-slate-900 tracking-wide select-all text-xs" dir="ltr">{{ $instapayAddress }}</code>
                                        </div>
                                        <button type="button" @click.stop="copyToClipboard('{{ $instapayAddress }}', 'instapay')" class="text-[11px] font-bold px-2.5 py-1 bg-white hover:bg-slate-100 text-slate-700 rounded border border-slate-300 flex items-center gap-1 transition-colors flex-shrink-0 shadow-2xs">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            <span x-text="copiedText === 'instapay' ? 'تم النسخ' : 'نسخ'"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Option 3: Wallet (Vodafone Cash) -->
                            <div :class="paymentMethod === 'wallet' ? 'border-blue-600 bg-white shadow-xs' : 'border-slate-200 bg-white hover:border-slate-300'" class="rounded-xl border transition-all overflow-hidden">
                                <label class="flex items-center justify-between p-3 cursor-pointer select-none">
                                    <div class="flex items-center gap-2.5">
                                        <input type="radio" name="payment_method" value="wallet" x-model="paymentMethod" class="text-blue-600 focus:ring-0">
                                        <span class="text-xs font-bold text-slate-800">محافظ إلكترونية (فودافون كاش / أورانج / اتصالات / وي)</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded">كاش</span>
                                </label>

                                <!-- Wallet Drawer (Only opens when selected) -->
                                <div x-show="paymentMethod === 'wallet'" class="px-3 pb-3 pt-0 border-t border-slate-100 mt-1">
                                    <div class="flex items-center justify-between gap-2 p-2.5 bg-slate-50 rounded-lg border border-slate-200 text-xs mt-2">
                                        <div class="flex items-center gap-2 truncate">
                                            <span class="text-slate-500 font-semibold text-[11px]">رقم المحفظة:</span>
                                            <code class="font-bold text-slate-900 tracking-wider font-mono text-xs select-all" dir="ltr">{{ $walletNumber }}</code>
                                        </div>
                                        <button type="button" @click.stop="copyToClipboard('{{ $walletNumber }}', 'wallet')" class="text-[11px] font-bold px-2.5 py-1 bg-white hover:bg-slate-100 text-slate-700 rounded border border-slate-300 flex items-center gap-1 transition-colors flex-shrink-0 shadow-2xs">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            <span x-text="copiedText === 'wallet' ? 'تم النسخ' : 'نسخ'"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Option 4: Bank Transfer / IBAN -->
                            <div :class="paymentMethod === 'bank' ? 'border-blue-600 bg-white shadow-xs' : 'border-slate-200 bg-white hover:border-slate-300'" class="rounded-xl border transition-all overflow-hidden">
                                <label class="flex items-center justify-between p-3 cursor-pointer select-none">
                                    <div class="flex items-center gap-2.5">
                                        <input type="radio" name="payment_method" value="bank" x-model="paymentMethod" class="text-blue-600 focus:ring-0">
                                        <span class="text-xs font-bold text-slate-800">تحويل بنكي مباشر (IBAN)</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded">بنك</span>
                                </label>

                                <!-- Bank Details Drawer (Only opens when selected) -->
                                <div x-show="paymentMethod === 'bank'" class="px-3 pb-3 pt-0 border-t border-slate-100 mt-1 space-y-2">
                                    <div class="p-2.5 bg-slate-50 rounded-lg border border-slate-200 text-xs mt-2 space-y-1.5">
                                        <div class="flex justify-between items-center text-slate-600 text-[11px]">
                                            <span>البنك: <strong class="text-slate-900">{{ $bankName }}</strong></span>
                                            <span>المستفيد: <strong class="text-slate-900">{{ $bankAccountName }}</strong></span>
                                        </div>
                                        <div class="flex items-center justify-between gap-2 pt-1.5 border-t border-slate-200/60">
                                            <div class="flex items-center gap-1.5 truncate">
                                                <span class="text-slate-500 text-[11px]">IBAN:</span>
                                                <code class="font-bold text-slate-900 font-mono text-[11px] truncate select-all" dir="ltr">{{ $bankIban }}</code>
                                            </div>
                                            <button type="button" @click.stop="copyToClipboard('{{ $bankIban }}', 'iban')" class="text-[11px] font-bold px-2.5 py-1 bg-white hover:bg-slate-100 text-slate-700 rounded border border-slate-300 flex items-center gap-1 transition-colors flex-shrink-0 shadow-2xs">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                                <span x-text="copiedText === 'iban' ? 'تم النسخ' : 'نسخ'"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- 4. Compact Screenshot Upload (Shown only for transfers) -->
                        <div x-show="paymentMethod !== 'cod'" class="mt-4 p-3.5 rounded-xl bg-white border border-slate-200 flex flex-col gap-2.5" x-transition>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-800">إرفاق إيصال التحويل (اختياري لتسريع التأكيد)</span>
                                <span class="text-[10px] text-slate-400">صورة JPG / PNG</span>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row items-center gap-2">
                                <input type="file" name="payment_screenshot" class="block w-full text-xs text-slate-500 file:ml-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 transition-all cursor-pointer border border-slate-200 rounded-lg p-1 bg-slate-50">
                                
                                <a href="https://wa.me/201550504512?text={{ urlencode('مرحباً، أود تأكيد الطلب وإرسال إيصال التحويل.') }}" target="_blank" class="w-full sm:w-auto px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg transition-colors flex items-center justify-center gap-1.5 whitespace-nowrap flex-shrink-0 shadow-2xs">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.458L0 24zm6.002-3.693c1.615.957 3.178 1.462 4.736 1.463 5.485.002 9.948-4.463 9.95-9.953.001-2.66-1.025-5.16-2.887-7.026C16.001 2.923 13.506 1.897 10.85 1.897c-5.486 0-9.949 4.464-9.953 9.954-.001 2.052.541 4.06 1.567 5.814l-1.026 3.75 3.829-1.004z"></path></svg>
                                    <span>واتساب المركز</span>
                                </a>
                            </div>
                        </div>

                    </div>

                    <!-- Notes (Optional) -->
                    <div class="flex flex-col gap-1">
                        <label class="text-[11px] font-bold text-slate-600">ملاحظات إضافية (اختياري)</label>
                        <input type="text" name="notes" value="{{ old('notes') }}" placeholder="أي تفاصيل تود كتابتها للمندوب أو الإدارة..." class="border-slate-300 rounded-lg text-xs py-2 px-3 text-slate-700 bg-white focus:border-blue-600 focus:ring-0">
                    </div>

                    <!-- Submit Order Button -->
                    <button type="submit" class="w-full bg-[#2563ea] hover:bg-blue-700 text-white font-black text-sm py-3.5 px-6 rounded-xl flex items-center justify-center gap-2 transition-all shadow-sm hover:shadow-md cursor-pointer">
                        <span>تأكيد وإرسال الطلب الآن</span>
                        <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>

            <!-- Order Summary (Left side, span 5) -->
            <div class="lg:col-span-5 flex flex-col gap-4">
                <div class="bg-slate-50 p-4 sm:p-5 rounded-2xl border border-slate-200/90">
                    <h3 class="text-xs sm:text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-[#2563ea] rounded-full"></span>
                        <span>ملخص السلة والمنتجات</span>
                    </h3>

                    <!-- Cart Items List -->
                    <div class="flex flex-col gap-3 max-h-[280px] overflow-y-auto pr-1">
                        @foreach($cart as $item)
                            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-200/70 last:border-0 last:pb-0">
                                <div class="w-10 h-10 bg-white rounded-lg border border-slate-200 overflow-hidden p-0.5 flex-shrink-0 flex items-center justify-center">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-contain">
                                    @else
                                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    @endif
                                </div>
                                <div class="flex-grow leading-tight min-w-0">
                                    <h4 class="text-xs font-bold text-slate-800 truncate">{{ $item['name'] }}</h4>
                                    <span class="text-[10px] text-slate-500 font-semibold">الكمية: {{ $item['quantity'] }} • {{ $item['type'] === 'digital' ? 'شيت رقمي PDF' : 'منتج مادي' }}</span>
                                </div>
                                <span class="text-xs font-black text-slate-900 flex-shrink-0">{{ number_format($item['price'] * $item['quantity'], 2) }} ج.م</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Receipt Calculations -->
                    <div class="mt-4 pt-4 border-t border-slate-200 flex flex-col gap-2.5 text-xs">
                        <div class="flex justify-between items-center text-slate-600 font-semibold">
                            <span>المجموع الفرعي:</span>
                            <span class="font-bold text-slate-800">{{ number_format($subtotal, 2) }} ج.م</span>
                        </div>

                        <div class="flex justify-between items-center text-slate-600 font-semibold">
                            <span>رسوم التوصيل والشحن:</span>
                            @if($shippingFee == 0)
                                <span class="text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded font-bold text-[11px] border border-emerald-200">شحن مجاني</span>
                            @else
                                <span class="font-bold text-slate-800">{{ number_format($shippingFee, 2) }} ج.م</span>
                            @endif
                        </div>

                        <!-- Free shipping progress bar -->
                        @if($physicalCount > 0 && $subtotal < 550)
                            <div class="bg-blue-50/60 border border-blue-100 p-2.5 rounded-xl flex flex-col gap-1.5 mt-1">
                                <div class="flex justify-between items-center text-[10px] font-bold text-[#2563ea]">
                                    <span>متبقي {{ number_format(550 - $subtotal, 2) }} ج.م للحصول على شحن مجاني</span>
                                    <span>{{ round(($subtotal / 550) * 100) }}%</span>
                                </div>
                                <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-[#2563ea] h-full rounded-full transition-all duration-500" style="width: {{ ($subtotal / 550) * 100 }}%"></div>
                                </div>
                            </div>
                        @endif

                        <div class="flex justify-between items-center text-slate-900 font-black text-sm pt-3 border-t border-slate-200">
                            <span>الإجمالي الكلي:</span>
                            <span class="text-[#2563ea] text-base font-black">{{ number_format($total, 2) }} ج.م</span>
                        </div>
                    </div>
                </div>

                <!-- Center note & guarantee -->
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-start gap-2.5 text-right">
                    <div class="w-7 h-7 rounded-lg bg-blue-100/60 text-[#2563ea] flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="text-[11px] text-slate-600 font-semibold leading-relaxed">
                        مركز ومتجر 2morro بإشراف <strong class="text-slate-800">أ. هبة الله أكرم</strong>. استشارات وتأهيل وشحن سريع للمحافظات.
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
