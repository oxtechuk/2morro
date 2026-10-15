@extends('layouts.storefront')

@section('title', 'تم استلام طلب الحجز بنجاح | مركز 2morro')

@section('content')
<div class="bg-[#F8FAFC] min-h-screen py-10 sm:py-16">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/90 shadow-sm text-center">
            
            <!-- Success Icon -->
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-sm ring-4 ring-emerald-50 bg-[#F97316] text-white">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>

            <!-- Centered Header -->
            <div class="space-y-2 mb-8">
                <span class="inline-block px-4 py-1.5 rounded-full text-xs font-black border border-emerald-200 bg-emerald-50 text-emerald-800">
                    تم استلام طلب الحجز وإشعار الدفع بنجاح
                </span>

                <h1 class="text-2xl sm:text-3xl font-black text-slate-900">
                    شكراً لثقتكم في مركز 2morro
                </h1>
                
                <p class="text-xs sm:text-sm text-slate-500 font-medium max-w-md mx-auto leading-relaxed">
                    تم استلام طلب التقييم والاستشارة وإيصال التحويل، وسيقوم فريق الاستقبال بمراجعة الإشعار والتواصل معكم لتأكيد الموعد فوراً.
                </p>
            </div>

            <!-- Booking Summary Details Box -->
            <div class="bg-slate-50/90 rounded-2xl p-5 sm:p-6 border border-slate-200/80 text-right mb-8 space-y-3.5">
                
                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <span class="text-xs font-bold text-slate-500">رقم الحجز المرجعي:</span>
                    <span class="text-sm font-black font-mono px-2.5 py-1 rounded-lg bg-orange-50 border border-orange-100 text-[#F97316]" dir="ltr">#{{ $booking->booking_number }}</span>
                </div>

                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <span class="text-xs font-bold text-slate-500">اسم الطفل وعمره:</span>
                    <span class="text-xs sm:text-sm font-black text-slate-900">{{ $booking->child_name }} ({{ $booking->child_age }})</span>
                </div>

                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <span class="text-xs font-bold text-slate-500">ولي الأمر:</span>
                    <span class="text-xs sm:text-sm font-bold text-slate-900">{{ $booking->parent_name }} <span class="text-slate-400 font-mono" dir="ltr">({{ $booking->parent_phone }})</span></span>
                </div>

                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <span class="text-xs font-bold text-slate-500">نوع الخدمة / الجلسة:</span>
                    <span class="text-xs sm:text-sm font-black text-slate-900">{{ $booking->service_type_label }}</span>
                </div>

                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <span class="text-xs font-bold text-slate-500">الفرع المختار:</span>
                    <span class="text-xs sm:text-sm font-bold text-slate-800">{{ $booking->branch_label }}</span>
                </div>

                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <span class="text-xs font-bold text-slate-500">التاريخ والموعد:</span>
                    <span class="text-xs sm:text-sm font-black text-emerald-700">{{ $booking->booking_date ? $booking->booking_date->format('Y/m/d') : '-' }} — {{ $booking->booking_time }}</span>
                </div>

                <!-- Price and Payment Method Details -->
                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <span class="text-xs font-bold text-slate-500">قيمة الاستشارة وطريقة الدفع:</span>
                    <div class="text-left">
                        <span class="text-xs sm:text-sm font-black text-slate-900">{{ number_format($booking->price, 2) }} ج.م</span>
                        <span class="text-[11px] text-slate-500 block">({{ $booking->payment_method_label }})</span>
                    </div>
                </div>

                <!-- Payment Screenshot Preview if attached -->
                @if($booking->receipt_url)
                    <div class="pt-2 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-500">سكرين شوت إشعار الدفع:</span>
                        <a href="{{ $booking->receipt_url }}" target="_blank" class="inline-flex items-center gap-1.5 p-1 bg-white rounded-xl border border-slate-200 text-xs font-bold text-blue-600 hover:text-blue-700">
                            <img src="{{ $booking->receipt_url }}" alt="إشعار الدفع" class="w-8 h-8 rounded-lg object-cover">
                            <span>عرض الإيصال ↗</span>
                        </a>
                    </div>
                @endif

            </div>

            <!-- WhatsApp Pre-filled Confirmation Link -->
            @php
                $bookingWaNum = preg_replace('/[^0-9]/', '', \App\Models\Setting::get('store_whatsapp', '201550504512')) ?: '201550504512';
                $waMsg = "مرحباً مركز 2morro، قمت بحجز استشارة برقم ({$booking->booking_number}) للطفل ({$booking->child_name}) - خدمة: ({$booking->service_type_label}) بقيمة ({$booking->price} ج.م) بتاريخ ({$booking->booking_date?->format('Y/m/d')} - {$booking->booking_time}) بفرع: ({$booking->branch_label}) وقمت برفع إشعار الدفع عبر ({$booking->payment_method_label}). أود تأكيد الموعد.";
                $waUrl = "https://wa.me/{$bookingWaNum}?text=" . urlencode($waMsg);
            @endphp

            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                
                <a href="{{ $waUrl }}" target="_blank" class="w-full sm:w-auto px-7 py-3.5 rounded-2xl text-white text-xs sm:text-sm font-black flex items-center justify-center gap-2 shadow-lg shadow-orange-500/25 transition-all hover:scale-[1.02] active:scale-95 cursor-pointer bg-[#F97316] hover:bg-[#EA580C]">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.458L0 24zm6.002-3.693c1.615.957 3.178 1.462 4.736 1.463 5.485.002 9.948-4.463 9.95-9.953.001-2.66-1.025-5.16-2.887-7.026C16.001 2.923 13.506 1.897 10.85 1.897c-5.486 0-9.949 4.464-9.953 9.954-.001 2.052.541 4.06 1.567 5.814l-1.026 3.75 3.829-1.004z"></path></svg>
                    <span>تأكيد الموعد فوراً عبر واتساب</span>
                </a>

                <a href="{{ route('home') }}" class="w-full sm:w-auto px-7 py-3.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs sm:text-sm font-bold flex items-center justify-center gap-1.5 transition-colors cursor-pointer">
                    <span>العودة للمتجر الرئيسي</span>
                    <svg class="w-4 h-4 rotate-180 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>

            </div>

        </div>

    </div>
</div>
@endsection
