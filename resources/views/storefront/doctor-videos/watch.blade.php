@extends('layouts.storefront')

@section('title', $video->title . ' - تشخيص وعلاج | شروحات دكتور تمورو')
@section('meta_description', Str::limit(strip_tags($video->description ?? $video->title), 160))
@section('og_type', 'video.other')
@section('og_image', $video->thumbnail_url ?? '')

@section('content')
<div class="bg-[#F8FAFC] text-slate-800 min-h-screen py-6 sm:py-10" 
     x-data="{
         isLocked: {{ !$hasAccess ? 'true' : 'false' }},
         previewLimit: {{ $video->preview_seconds ?? 45 }},
         currentTime: 0,
         paywallTriggered: false,
         initPlayer() {
             const v = this.$refs.videoPlayer;
             if (v && this.isLocked && this.previewLimit > 0) {
                 v.addEventListener('timeupdate', () => {
                     this.currentTime = v.currentTime;
                     if (v.currentTime >= this.previewLimit) {
                         v.pause();
                         this.paywallTriggered = true;
                     }
                 });
             }
         },
         shareVideo() {
             if (navigator.share) {
                 navigator.share({
                     title: '{{ addslashes($video->title) }}',
                     text: 'شاهد شرح الدكتور على منصة تمورو',
                     url: window.location.href,
                 });
             } else {
                 navigator.clipboard.writeText(window.location.href);
                 alert('تم نسخ رابط الشرح للمشاركة!');
             }
         }
     }" 
     x-init="initPlayer()">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb & Back -->
        <div class="mb-5 flex items-center justify-between text-xs sm:text-sm text-slate-500">
            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('home') }}" class="hover:text-[#2563ea] transition-colors font-medium">الرئيسية</a>
                <span>/</span>
                <a href="{{ route('doctor-videos.index') }}" class="hover:text-[#2563ea] transition-colors font-medium">شروحات الدكتور</a>
                <span>/</span>
                <span class="text-[#2563ea] font-bold truncate max-w-xs">{{ $video->title }}</span>
            </div>
            <a href="{{ route('doctor-videos.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-[#2563ea] transition-colors">
                <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                <span>كافة الشروحات</span>
            </a>
        </div>

        <!-- 2-Column Watch Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Column 1: Video Player & Details (8 Cols) -->
            <div class="lg:col-span-8 flex flex-col gap-6">

                <!-- The Video Screen & Player Container -->
                <div class="relative w-full rounded-3xl overflow-hidden bg-black shadow-lg border border-slate-200 {{ $video->video_type === 'reel' ? 'max-w-md mx-auto aspect-[9/16]' : 'aspect-video' }}">
                    
                    @if($hasAccess)
                        <!-- FULL UNLOCKED ACCESS -->
                        @if($video->video_source === 'youtube')
                            <iframe src="{{ $video->youtube_embed_url }}?autoplay=1&rel=0" 
                                    class="w-full h-full border-0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                            </iframe>
                        @else
                            <video src="{{ $video->video_url }}" 
                                   controls 
                                   autoplay 
                                   playsinline 
                                   class="w-full h-full object-contain bg-black">
                            </video>
                        @endif

                    @else
                        <!-- LOCKED / PAYWALL PREVIEW ACCESS -->
                        @if($video->video_source === 'youtube')
                            <div class="relative w-full h-full">
                                <iframe src="{{ $video->youtube_embed_url }}?autoplay=1&rel=0" 
                                        class="w-full h-full border-0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                </iframe>
                                
                                <!-- Paywall Lock Overlay Triggered -->
                                <div x-show="paywallTriggered || previewLimit <= 0" 
                                     class="absolute inset-0 z-30 bg-slate-950/90 backdrop-blur-md flex flex-col items-center justify-center p-6 text-center text-white">
                                    <div class="w-16 h-16 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center mb-4 border border-amber-500/30">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    </div>
                                    <h3 class="text-xl sm:text-2xl font-black mb-2">هذا الشرح متاح للمشتركين فقط</h3>
                                    <p class="text-sm text-slate-300 max-w-md mb-6 leading-relaxed">
                                        انتهت فترة المعاينة المجانية. احصل على التوجيهات الطبية الكاملة وخطوات العلاج والتأهيل المنزلي مدى الحياة.
                                    </p>

                                    <!-- Price & Purchase Action -->
                                    <div class="bg-slate-900/90 border border-amber-500/30 rounded-2xl p-4 sm:p-5 w-full max-w-sm mb-4">
                                        <div class="text-xs text-slate-400 font-bold mb-1">سعر الشرح والاستشارة المصورة:</div>
                                        <div class="text-2xl sm:text-3xl font-black text-amber-400 mb-4">{{ number_format($video->price, 2) }} ج.م</div>
                                        
                                        @auth
                                            <form action="{{ route('doctor-videos.purchase', $video->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-sm transition-all shadow-md hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                                    <span>فتح ومشاهدة الشرح الآن</span>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="block w-full py-3.5 px-4 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-sm text-center transition-all shadow-md">
                                                تسجيل الدخول لشراء الشرح
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- HTML5 Player with timer check -->
                            <div class="relative w-full h-full">
                                <video x-ref="videoPlayer" 
                                       src="{{ $video->video_url }}" 
                                       controls 
                                       autoplay 
                                       playsinline 
                                       class="w-full h-full object-contain bg-black">
                                </video>

                                <!-- Paywall Lock Overlay -->
                                <div x-show="paywallTriggered || previewLimit <= 0" 
                                     class="absolute inset-0 z-30 bg-slate-950/90 backdrop-blur-md flex flex-col items-center justify-center p-6 text-center text-white">
                                    <div class="w-16 h-16 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center mb-4 border border-amber-500/30">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    </div>
                                    <h3 class="text-xl sm:text-2xl font-black mb-2">هذا الشرح متاح للمشتركين فقط</h3>
                                    <p class="text-sm text-slate-300 max-w-md mb-6 leading-relaxed">
                                        انتهت فترة المعاينة المجانية. احصل على التوجيهات الطبية الكاملة وخطوات العلاج والتأهيل المنزلي مدى الحياة.
                                    </p>

                                    <!-- Price & Purchase Action -->
                                    <div class="bg-slate-900/90 border border-amber-500/30 rounded-2xl p-4 sm:p-5 w-full max-w-sm mb-4">
                                        <div class="text-xs text-slate-400 font-bold mb-1">سعر الشرح والاستشارة المصورة:</div>
                                        <div class="text-2xl sm:text-3xl font-black text-amber-400 mb-4">{{ number_format($video->price, 2) }} ج.م</div>
                                        
                                        @auth
                                            <form action="{{ route('doctor-videos.purchase', $video->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-sm transition-all shadow-md hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                                    <span>فتح ومشاهدة الشرح الآن</span>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="block w-full py-3.5 px-4 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-sm text-center transition-all shadow-md">
                                                تسجيل الدخول لشراء الشرح
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

                </div>

                <!-- Video Title & Action Bar (Light Card) -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-2xs">
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 leading-tight mb-3">
                        {{ $video->title }}
                    </h1>

                    <div class="flex flex-wrap items-center justify-between gap-4 pb-4 border-b border-slate-100">
                        <!-- Badges & Diagnostics -->
                        <div class="flex items-center gap-2 flex-wrap">
                            @if($video->need)
                                <span class="bg-blue-50 border border-blue-200 text-[#2563ea] text-xs font-black px-3 py-1 rounded-full">
                                    {{ $video->need->name }}
                                </span>
                            @endif
                            @if($video->ageGroup)
                                <span class="bg-purple-50 border border-purple-200 text-purple-700 text-xs font-bold px-3 py-1 rounded-full">
                                    {{ $video->ageGroup->name }}
                                </span>
                            @endif
                            <span class="text-xs text-slate-500 font-bold flex items-center gap-1">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span>{{ number_format($video->views_count) }} مشاهدة</span>
                            </span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-2">
                            <button @click="shareVideo()" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                <span>مشاركة</span>
                            </button>

                            @if($video->is_paid)
                                @if($hasAccess)
                                    <span class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-black flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <span>شرح مفتوح لك مدى الحياة</span>
                                    </span>
                                @else
                                    <span class="px-3 py-1.5 rounded-xl bg-amber-50 text-amber-800 border border-amber-200 text-xs font-black flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        <span>{{ number_format($video->price, 0) }} ج.م</span>
                                    </span>
                                @endif
                            @else
                                <span class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-black flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>شرح مجاني</span>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Doctor / Center Bio -->
                    <div class="mt-4 pt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#2563ea] border border-blue-100 flex items-center justify-center font-black text-base flex-shrink-0">
                                د
                            </div>
                            <div>
                                <div class="text-slate-900 font-black text-sm sm:text-base">فريق د. هبة الله أكرم • مركز تمورو 2morro</div>
                                <div class="text-slate-500 text-xs font-medium">أخصائيو تخاطب، تنمية مهارات، وتعديل سلوك الأطفال</div>
                            </div>
                        </div>
                        <a href="{{ route('booking.index') }}" class="px-5 py-2.5 rounded-xl text-white text-xs font-black transition-all shadow-xs hover:scale-105 whitespace-nowrap self-start sm:self-auto" style="background-color: #f76d11;">
                            حجز استشارة وتقييم
                        </a>
                    </div>
                </div>

                <!-- Video Description Box -->
                @if($video->description)
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-2xs" x-data="{ expanded: false }">
                        <h3 class="text-sm font-black text-slate-900 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#2563ea]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>تفاصيل الشرح وإرشادات وتوجيهات الحالة:</span>
                        </h3>
                        <div class="text-slate-600 text-xs sm:text-sm leading-relaxed whitespace-pre-line" :class="expanded ? '' : 'line-clamp-4'">
                            {{ $video->description }}
                        </div>
                        <button @click="expanded = !expanded" class="text-[#2563ea] hover:underline text-xs font-bold mt-2 inline-flex items-center gap-1 cursor-pointer">
                            <span x-text="expanded ? 'عرض أقل' : 'عرض المزيد من التفاصيل'"></span>
                            <svg class="w-3.5 h-3.5 transition-transform" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </div>
                @endif

                <!-- Recommended Store Products Box (Upsell) -->
                @if($video->products->isNotEmpty())
                    <div class="bg-white rounded-3xl p-6 border border-emerald-200/80 shadow-2xs">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <div class="text-xs font-black text-emerald-600 uppercase tracking-wider mb-0.5">حلول وأدوات عملية موصى بها</div>
                                <h3 class="text-base sm:text-lg font-black text-slate-900 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    <span>أدوات وألعاب يوصي بها الدكتور لتأهيل هذه الحالة</span>
                                </h3>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($video->products as $product)
                                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-emerald-300 transition-all flex items-center gap-3.5 group">
                                    <a href="{{ route('product', $product->slug) }}" class="flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden bg-white border border-slate-200 aspect-square">
                                        <img src="{{ $product->thumbnail_url ?? asset('assets/icons-admin/box.svg') }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                    </a>
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('product', $product->slug) }}" class="text-slate-900 text-xs sm:text-sm font-black line-clamp-1 group-hover:text-[#2563ea] transition-colors">
                                            {{ $product->name }}
                                        </a>
                                        <div class="text-[#2563ea] font-black text-sm mt-0.5">{{ number_format($product->price, 2) }} ج.م</div>
                                        
                                        <form action="{{ route('cart.add') }}" method="POST" class="mt-2">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="w-full py-1.5 px-3 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold transition-colors flex items-center justify-center gap-1 cursor-pointer">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                                <span>أضف للسلة الآن</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            <!-- Column 2: Suggested Videos Sidebar (4 Cols) -->
            <div class="lg:col-span-4 flex flex-col gap-4">
                <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-2xs">
                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100">
                        <h3 class="text-sm sm:text-base font-black text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#2563ea]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <span>شروحات مقترحة</span>
                        </h3>
                    </div>

                    <!-- Related Video Cards -->
                    <div class="flex flex-col gap-3">
                        @forelse($relatedVideos as $rel)
                            <a href="{{ route('doctor-videos.watch', $rel->slug) }}" class="flex gap-3 p-2 rounded-2xl hover:bg-slate-50 border border-transparent hover:border-slate-200 transition-all group">
                                <!-- Thumbnail (Compact) -->
                                <div class="relative w-32 sm:w-36 flex-shrink-0 aspect-video rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                    @if($rel->thumbnail)
                                        <img src="{{ $rel->thumbnail_url }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        </div>
                                    @endif

                                    @if($rel->duration)
                                        <span class="absolute bottom-1 left-1 bg-black/75 text-white text-[9px] font-mono px-1 rounded">
                                            {{ $rel->duration }}
                                        </span>
                                    @endif

                                    @if($rel->is_paid)
                                        <span class="absolute top-1 right-1 bg-amber-500 text-slate-950 text-[9px] font-black px-1.5 py-0.2 rounded-full">
                                            مدفوع
                                        </span>
                                    @endif
                                </div>

                                <!-- Info -->
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-slate-900 text-xs font-bold line-clamp-2 leading-snug group-hover:text-[#2563ea] transition-colors">
                                        {{ $rel->title }}
                                    </h4>
                                    @if($rel->need)
                                        <span class="text-[10px] text-[#2563ea] font-bold block mt-1">{{ $rel->need->name }}</span>
                                    @endif
                                    <div class="text-[10px] text-slate-400 mt-1">
                                        {{ number_format($rel->views_count) }} مشاهدة
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-slate-400 text-xs py-4 text-center">لا توجد شروحات أخرى مقترحة حالياً.</div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof window.trackEcommerceEvent === 'function') {
            window.trackEcommerceEvent('ViewContent', {
                content_name: '{{ addslashes($video->title) }}',
                content_ids: ['{{ $video->id }}'],
                content_type: 'doctor_video',
                value: {{ (float)$video->price }},
                currency: 'EGP'
            });
        }
    });
</script>
@endsection
