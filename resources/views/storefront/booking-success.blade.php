@extends('layouts.storefront')

@section('title', 'تم استلام طلب الحجز بنجاح | مركز 2morro')

@section('content')
<div class="bg-[#F8FAFC] min-h-screen py-10 sm:py-16">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/90 shadow-sm text-center">
            
            <!-- Success Icon -->
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-sm ring-4 ring-emerald-50" style="background-color: #F97316 ; color: #ffffff;">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #ffffff;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>

            <!-- Centered Header -->
            <div class="space-y-2 mb-8">
                <span class="inline-block px-4 py-1.5 rounded-full text-xs font-black border border-emerald-200" style="background-color: #ECFDF5; color: #047857;">
                    تم تسجيل طلب الاستشارة بنجاح
                </span>

                <h1 class="text-2xl sm:text-3xl font-black text-slate-900">
                    شكراً لثقتكم في مركز 2morro
                </h1>
                
                <p class="text-xs sm:text-sm text-slate-500 font-medium max-w-md mx-auto leading-relaxed">
                    تم استلام طلب التقييم والاستشارة بنجاح، وسيقوم فريق الاستقبال بالتواصل معكم هاتفياً أو عبر الواتساب لتأكيد الموعد.
                </p>
            </div>

            <!-- Booking Summary Details Box -->
            <div class="bg-slate-50/80 rounded-2xl p-5 sm:p-6 border border-slate-200/80 text-right mb-8 space-y-3.5">
                
                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <span class="text-xs font-bold text-slate-500">رقم الحجز المرجعي:</span>
                    <span class="text-sm font-black font-mono px-2.5 py-1 rounded-lg bg-blue-50 border border-blue-100 text-blue-700" dir="ltr">#{{ $booking->booking_number }}</span>
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
                    <span class="text-xs font-bold text-slate-500">الفرع / المكان:</span>
                    <span class="text-xs sm:text-sm font-bold text-slate-800">{{ $booking->branch_label }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500">التاريخ والموعد:</span>
                    <span class="text-xs sm:text-sm font-black text-emerald-700">{{ $booking->booking_date->format('Y/m/d') }} — {{ $booking->booking_time }}</span>
                </div>

            </div>

            <!-- WhatsApp Pre-filled Confirmation Link -->
            @php
                $waMsg = "مرحباً مركز 2morro، لقد قمت بحجز استشارة برقم ({$booking->booking_number}) للطفل ({$booking->child_name} - {$booking->child_age}) - خدمة: ({$booking->service_type_label}) بتاريخ ({$booking->booking_date->format('Y/m/d')} - {$booking->booking_time}) بفرع: ({$booking->branch_label}). أود تأكيد الموعد.";
                $waUrl = "https://wa.me/201550504512?text=" . urlencode($waMsg);
            @endphp

            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                
                <a href="{{ $waUrl }}" target="_blank" class="w-full sm:w-auto px-7 py-3.5 rounded-2xl text-white text-xs sm:text-sm font-black flex items-center justify-center gap-2 shadow-lg shadow-emerald-500/25 transition-all hover:scale-[1.02] active:scale-95 cursor-pointer" style="background-color: #F97316  !important; color: #ffffff !important;">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" style="color: #ffffff !important;"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.458L0 24zm6.002-3.693c1.615.957 3.178 1.462 4.736 1.463 5.485.002 9.948-4.463 9.95-9.953.001-2.66-1.025-5.16-2.887-7.026C16.001 2.923 13.506 1.897 10.85 1.897c-5.486 0-9.949 4.464-9.953 9.954-.001 2.052.541 4.06 1.567 5.814l-1.026 3.75 3.829-1.004z"></path></svg>
                    <span style="color: #ffffff !important;">تأكيد الموعد فوراً عبر واتساب</span>
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
