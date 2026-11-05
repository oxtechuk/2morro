@extends('layouts.storefront')

@section('title', 'الصفحة غير موجودة (404) | متجر ومركز تمورو 2morro')
@section('meta_description', 'عفواً، الصفحة التي تبحث عنها غير موجودة أو تم نقلها. تفضل بتصفح منتجات تمورو أو العودة للصفحة الرئيسية.')
@section('robots', 'noindex, follow')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8 bg-white text-center">
    <div class="max-w-md w-full">
        <div class="w-24 h-24 rounded-3xl bg-rose-50 text-rose-500 mx-auto flex items-center justify-center mb-6 shadow-xs">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        <span class="text-xs font-black text-rose-600 bg-rose-100 px-3 py-1 rounded-full mb-3 inline-block">خطأ 404 • الصفحة غير موجودة</span>
        
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mb-3 tracking-tight">
            عفواً، لم نتمكن من العثور على هذه الصفحة!
        </h1>
        
        <p class="text-slate-500 text-sm mb-8 leading-relaxed">
            ربما تم نقل الصفحة، أو تم تغيير الرابط، أو أنها لم تعد متوفرة. يمكنك البحث في منتجات المتجر أو العودة للرئيسية.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('home') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-[#2563ea] hover:bg-blue-700 text-white font-bold text-sm transition-all shadow-md hover:scale-105">
                العودة للصفحة الرئيسية
            </a>
            <a href="{{ route('search') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm transition-colors">
                تصفح المنتجات والألعاب
            </a>
        </div>
    </div>
</div>
@endsection
