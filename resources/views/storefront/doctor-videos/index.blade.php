@extends('layouts.storefront')

@section('title', 'شروحات وريلز الدكتور لعلاج وتأهيل الأطفال وتأخر الكلام | تمورو 2morro')
@section('meta_description', 'مكتبة فيديوهات وريلز توعوية متخصصة يقدمها أخصائيو مركز تمورو لشرح وعلاج تأخر النطق، تشتت الانتباه وفرط الحركة، التوحد، وتعديل سلوك الأطفال.')

@section('content')
<div class="bg-[#0f172a] text-white py-8 sm:py-12 border-b border-slate-800 relative overflow-hidden" 
     x-data="{ 
         shortsModalOpen: false, 
         activeReel: null, 
         reelsList: {{ Js::from($reels) }},
         openReel(reel) {
             this.activeReel = reel;
             this.shortsModalOpen = true;
         },
         nextReel() {
             let idx = this.reelsList.findIndex(r => r.id === this.activeReel.id);
             if (idx < this.reelsList.length - 1) {
                 this.activeReel = this.reelsList[idx + 1];
             }
         },
         prevReel() {
             let idx = this.reelsList.findIndex(r => r.id === this.activeReel.id);
             if (idx > 0) {
                 this.activeReel = this.reelsList[idx - 1];
             }
         }
     }">

    <!-- Background glowing accents -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-rose-600/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 -right-24 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <!-- 1. Header Banner -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-500/20 border border-rose-500/30 text-rose-400 text-xs font-black mb-3">
                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                    <span>منصة فيديو تمورو التفاعلية • YouTube Style</span>
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight mb-2">
                    شروحات وريلز الدكتور لعلاج وتأهيل الأطفال
                </h1>
                <p class="text-slate-400 text-sm sm:text-base max-w-2xl leading-relaxed">
                    فيديوهات توعوية وشروحات تشخيصية مبسطة لكل مرحلة عمرية ومشاكل النطق، تشتت الانتباه، وتعديل السلوك مع أدوات مساعدة من المتجر.
                </p>
            </div>

            <!-- Fast Search Form -->
            <form action="{{ route('doctor-videos.index') }}" method="GET" class="w-full md:w-80">
                <div class="relative">
                    <input type="text" name="q" value="{{ $searchQuery }}" placeholder="ابحث عن مشكلة أو شرح..." 
                           class="w-full bg-slate-800/90 border border-slate-700 text-white placeholder-slate-400 text-xs sm:text-sm rounded-2xl py-3 pr-10 pl-4 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition-all">
                    <button type="submit" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- 2. YouTube-Style Chips / Filter Bar (Horizontal Scroll) -->
        <div class="flex items-center gap-2 overflow-x-auto pb-4 no-scrollbar border-b border-slate-800 mb-8" style="scrollbar-width: none;">
            
            <!-- All -->
            <a href="{{ route('doctor-videos.index') }}" 
               class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold whitespace-nowrap transition-all {{ empty($selectedNeed) && empty($selectedAgeGroup) && empty($selectedAccess) && empty($selectedType) ? 'bg-white text-slate-900 shadow-md font-black' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
                الكل
            </a>

            <!-- Reels Only -->
            <a href="{{ route('doctor-videos.index', array_merge(request()->except('type'), ['type' => $selectedType === 'reels' ? null : 'reels'])) }}" 
               class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold whitespace-nowrap transition-all flex items-center gap-1.5 {{ $selectedType === 'reels' ? 'bg-rose-600 text-white shadow-md font-black' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
                <svg class="w-4 h-4 text-rose-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                <span>⚡ ريلز سريعة</span>
            </a>

            <!-- Free -->
            <a href="{{ route('doctor-videos.index', array_merge(request()->except('access'), ['access' => $selectedAccess === 'free' ? null : 'free'])) }}" 
               class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold whitespace-nowrap transition-all {{ $selectedAccess === 'free' ? 'bg-emerald-600 text-white font-black' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
                🔓 مجانية بالكامل
            </a>

            <!-- Paid / Exclusive -->
            <a href="{{ route('doctor-videos.index', array_merge(request()->except('access'), ['access' => $selectedAccess === 'paid' ? null : 'paid'])) }}" 
               class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold whitespace-nowrap transition-all flex items-center gap-1.5 {{ $selectedAccess === 'paid' ? 'bg-amber-600 text-white font-black' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
                <span>🔒 شروحات خاصة ومدفوعة</span>
            </a>

            <!-- Divider -->
            <div class="h-5 w-[1px] bg-slate-700 mx-1 flex-shrink-0"></div>

            <!-- Needs / Problem Chips -->
            @foreach($needs as $need)
                <a href="{{ route('doctor-videos.index', array_merge(request()->except('need'), ['need' => $selectedNeed == $need->id || $selectedNeed == $need->slug ? null : $need->slug])) }}" 
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold whitespace-nowrap transition-all {{ $selectedNeed == $need->id || $selectedNeed == $need->slug ? 'bg-blue-600 text-white font-black' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
                    {{ $need->name }}
                    @if($need->doctor_videos_count > 0)
                        <span class="text-[10px] opacity-75 ms-1">({{ $need->doctor_videos_count }})</span>
                    @endif
                </a>
            @endforeach

            <!-- Divider -->
            <div class="h-5 w-[1px] bg-slate-700 mx-1 flex-shrink-0"></div>

            <!-- Age Group Chips -->
            @foreach($ageGroups as $ag)
                <a href="{{ route('doctor-videos.index', array_merge(request()->except('age_group'), ['age_group' => $selectedAgeGroup == $ag->id || $selectedAgeGroup == $ag->slug ? null : $ag->slug])) }}" 
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold whitespace-nowrap transition-all {{ $selectedAgeGroup == $ag->id || $selectedAgeGroup == $ag->slug ? 'bg-purple-600 text-white font-black' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
                    {{ $ag->name }}
                </a>
            @endforeach

        </div>

        <!-- 3. YouTube Shorts / Reels Carousel Section -->
        @if($reels->isNotEmpty() && $selectedType !== 'videos')
            <div class="mb-12">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg sm:text-xl font-black text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-rose-500 animate-pulse" fill="currentColor" viewBox="0 0 24 24"><path d="M4 6.47v11.06c0 1.25 1.37 2.01 2.43 1.36l9.1-5.53c1.02-.62 1.02-2.1 0-2.72l-9.1-5.53C5.37 4.46 4 5.22 4 6.47z"/></svg>
                        <span>ريلز وسناكس توعوية سريعة (Shorts)</span>
                    </h2>
                    <span class="text-xs text-slate-400 font-bold">انقر للمشاهدة السريعة</span>
                </div>

                <!-- Horizontal Reels Track -->
                <div class="flex items-center gap-4 overflow-x-auto pb-4 no-scrollbar snap-x" style="scrollbar-width: none;">
                    @foreach($reels as $reel)
                        <div class="flex-shrink-0 w-44 sm:w-52 snap-start group cursor-pointer" @click="openReel({{ Js::from($reel) }})">
                            <div class="relative rounded-2xl overflow-hidden bg-slate-800 aspect-[9/16] shadow-lg border border-slate-700/60 transition-transform duration-300 group-hover:scale-[1.03] group-hover:border-rose-500">
                                
                                <!-- Thumbnail Image -->
                                @if($reel->thumbnail)
                                    <img src="{{ $reel->thumbnail_url }}" alt="{{ $reel->title }}" class="w-100 h-100 w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-900 to-slate-800">
                                        <svg class="w-12 h-12 text-rose-500/50" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                                    </div>
                                @endif

                                <!-- Gradient Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent flex flex-col justify-between p-3.5">
                                    <div class="flex items-center justify-between">
                                        <span class="bg-rose-600 text-white text-[10px] font-black px-2 py-0.5 rounded-full shadow-xs">
                                            ريلز
                                        </span>
                                        @if($reel->duration)
                                            <span class="bg-black/60 backdrop-blur-xs text-white text-[10px] font-monospace px-1.5 py-0.5 rounded">
                                                {{ $reel->duration }}
                                            </span>
                                        @endif
                                    </div>

                                    <div>
                                        @if($reel->need)
                                            <span class="text-rose-400 text-[11px] font-black block mb-1">{{ $reel->need->name }}</span>
                                        @endif
                                        <h3 class="text-white text-xs sm:text-sm font-bold line-clamp-2 leading-snug group-hover:text-rose-300 transition-colors">
                                            {{ $reel->title }}
                                        </h3>
                                        <div class="flex items-center gap-1 text-slate-400 text-[10px] mt-1 font-bold">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <span>{{ number_format($reel->views_count) }} مشاهدة</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- 4. Main YouTube Video Grid (16:9 Long Videos & Explanations) -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg sm:text-xl font-black text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    <span>شروحات وجلسات الدكتور التفصيلية</span>
                </h2>
                <span class="text-xs text-slate-400 font-bold">{{ $videos->total() }} فيديو متاح</span>
            </div>

            <!-- Video Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($videos as $video)
                    <div class="group flex flex-col">
                        <!-- Video Card Thumbnail -->
                        <a href="{{ route('doctor-videos.watch', $video->slug) }}" class="relative rounded-2xl overflow-hidden bg-slate-800 aspect-video shadow-md border border-slate-700/60 block transition-transform duration-300 group-hover:scale-[1.02]">
                            @if($video->thumbnail)
                                <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-800">
                                    <svg class="w-12 h-12 text-slate-600" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            @endif

                            <!-- Play Hover Overlay -->
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="w-12 h-12 rounded-full bg-rose-600/90 text-white flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 ms-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </span>
                            </div>

                            <!-- Duration Badge -->
                            @if($video->duration)
                                <span class="absolute bottom-2 left-2 bg-black/80 backdrop-blur-xs text-white text-[10px] font-monospace font-bold px-1.5 py-0.5 rounded-md">
                                    {{ $video->duration }}
                                </span>
                            @endif

                            <!-- Access Badge (Paid vs Free) -->
                            <div class="absolute top-2 right-2">
                                @if($video->is_paid)
                                    <span class="bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 text-[10px] font-black px-2 py-0.5 rounded-full shadow-md flex items-center gap-1">
                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                                        <span>مدفوع ({{ number_format($video->price, 0) }} ج.م)</span>
                                    </span>
                                @else
                                    <span class="bg-emerald-600/90 backdrop-blur-xs text-white text-[10px] font-black px-2 py-0.5 rounded-full shadow-xs">
                                        مجاني
                                    </span>
                                @endif
                            </div>
                        </a>

                        <!-- Video Card Details -->
                        <div class="mt-3 flex gap-3">
                            <!-- Avatar / Channel Icon -->
                            <div class="flex-shrink-0">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-rose-600 to-blue-600 p-0.5">
                                    <div class="w-full h-full bg-slate-900 rounded-full flex items-center justify-center text-white text-xs font-black">
                                        د
                                    </div>
                                </div>
                            </div>

                            <!-- Info -->
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('doctor-videos.watch', $video->slug) }}" class="text-white text-sm font-bold line-clamp-2 group-hover:text-rose-400 transition-colors leading-snug">
                                    {{ $video->title }}
                                </a>

                                <div class="flex items-center gap-1.5 text-xs text-slate-400 mt-1 flex-wrap">
                                    @if($video->need)
                                        <span class="text-rose-400 font-bold">{{ $video->need->name }}</span>
                                        <span>•</span>
                                    @endif
                                    @if($video->ageGroup)
                                        <span>{{ $video->ageGroup->name }}</span>
                                        <span>•</span>
                                    @endif
                                    <span>{{ number_format($video->views_count) }} مشاهدة</span>
                                </div>

                                @if($video->products_count > 0)
                                    <div class="mt-2 inline-flex items-center gap-1 text-[11px] font-bold text-emerald-400 bg-emerald-950/60 border border-emerald-800/40 px-2 py-0.5 rounded-md">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                        <span>يتضمن أدوات موصى بها من المتجر</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="w-16 h-16 rounded-2xl bg-slate-800 text-slate-600 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-1">لا توجد فيديوهات مطابقة للفلتر المحدد</h3>
                        <p class="text-sm text-slate-400 mb-4">جرب اختيار تصنيف آخر أو إلغاء بعض الفلاتر السريعة في الأعلى.</p>
                        <a href="{{ route('doctor-videos.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold transition-colors">
                            إعادة ضبط كافة الفلاتر
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($videos->hasPages())
                <div class="mt-10">
                    {{ $videos->links() }}
                </div>
            @endif
        </div>

    </div>

    <!-- 5. Interactive YouTube Shorts Modal Viewer (Alpine.js) -->
    <div x-show="shortsModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 bg-black/95 backdrop-blur-md flex items-center justify-center p-2 sm:p-4"
         @keydown.escape.window="shortsModalOpen = false">
        
        <!-- Close Button -->
        <button @click="shortsModalOpen = false" class="absolute top-4 left-4 z-50 p-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        <template x-if="activeReel">
            <div class="relative w-full max-w-sm sm:max-w-md aspect-[9/16] max-h-[90vh] rounded-3xl overflow-hidden bg-black shadow-2xl flex flex-col justify-between border border-slate-800">
                
                <!-- Video Player / Embed -->
                <template x-if="activeReel.video_source === 'youtube'">
                    <iframe :src="'https://www.youtube-nocookie.com/embed/' + (activeReel.video_path.match(/(?:youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*)/)?.[1] || '') + '?autoplay=1&controls=1'" 
                            class="w-full h-full border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                    </iframe>
                </template>

                <template x-if="activeReel.video_source !== 'youtube'">
                    <video :src="'/storage/' + activeReel.video_path" 
                           class="w-full h-full object-cover" 
                           autoplay controls playsinline loop>
                    </video>
                </template>

                <!-- Overlay Header & Next/Prev Controls -->
                <div class="absolute top-4 right-4 z-20 flex flex-col gap-2">
                    <button @click="prevReel()" class="p-2 rounded-full bg-black/50 text-white hover:bg-black/75 transition-colors" title="الريل السابق">
                        <svg class="w-5 h-5 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="nextReel()" class="p-2 rounded-full bg-black/50 text-white hover:bg-black/75 transition-colors" title="الريل التالي">
                        <svg class="w-5 h-5 -rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                </div>

                <!-- Bottom Video Info -->
                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/95 via-black/60 to-transparent p-5 text-right z-20 pointer-events-none">
                    <div class="pointer-events-auto">
                        <template x-if="activeReel.need">
                            <span class="text-rose-400 font-black text-xs block mb-1" x-text="activeReel.need.name"></span>
                        </template>
                        <h3 class="text-white font-bold text-base line-clamp-2 leading-snug mb-2" x-text="activeReel.title"></h3>
                        <p class="text-slate-300 text-xs line-clamp-2 mb-3 leading-relaxed" x-text="activeReel.description"></p>
                        
                        <div class="flex items-center gap-2">
                            <a :href="'/doctor-videos/' + activeReel.slug" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-black transition-colors inline-flex items-center gap-1.5">
                                <span>شاهد الشرح الكامل للمشكلة</span>
                                <svg class="w-3.5 h-3.5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </template>
    </div>

</div>
@endsection

