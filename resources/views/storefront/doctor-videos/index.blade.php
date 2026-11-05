@extends('layouts.storefront')

@section('title', 'شروحات وريلز الدكتور لعلاج وتأهيل الأطفال وتأخر الكلام | تمورو 2morro')
@section('meta_description', 'مكتبة فيديوهات وريلز توعوية متخصصة يقدمها أخصائيو مركز تمورو لشرح وعلاج تأخر النطق، تشتت الانتباه وفرط الحركة، التوحد، وتعديل سلوك الأطفال.')

@section('content')
<div class="bg-[#F8FAFC] text-slate-800 py-6 sm:py-10" 
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- 1. Header Banner (Clean Light Identity) -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-2xs mb-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-black bg-blue-50 text-[#2563ea] border border-blue-100 mb-3">
                        <span class="w-2 h-2 rounded-full bg-[#2563ea]"></span>
                        <span>منصة شروحات واستشارات الدكتور</span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight mb-2">
                        شروحات وفيديوهات الدكتور لعلاج وتأهيل الأطفال
                    </h1>
                    <p class="text-slate-500 text-xs sm:text-sm max-w-2xl leading-relaxed font-semibold">
                        مكتبة مرئية شاملة يقدمها أخصائيو مركز تمورو لشرح وعلاج مشاكل النطق وتأخر الكلام وتشتت الانتباه وتعديل السلوك مع أدوات عملية من المتجر.
                    </p>
                </div>

                <!-- Fast Search Form -->
                <form action="{{ route('doctor-videos.index') }}" method="GET" class="w-full md:w-80 flex-shrink-0">
                    <div class="relative">
                        <input type="text" name="q" value="{{ $searchQuery }}" placeholder="ابحث عن مشكلة أو شرح..." 
                               class="w-full bg-slate-50 border border-slate-200 text-slate-800 placeholder-slate-400 text-xs sm:text-sm rounded-2xl py-3 pr-10 pl-4 focus:outline-none focus:bg-white focus:border-[#2563ea] focus:ring-1 focus:ring-[#2563ea] transition-all">
                        <button type="submit" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#2563ea] transition-colors cursor-pointer" title="بحث">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 2. Clean Light Filter Chips Bar -->
        <div class="bg-white p-3 sm:p-4 rounded-2xl border border-slate-200/80 shadow-2xs mb-6">
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1" style="scrollbar-width: none;">
                
                <!-- All -->
                <a href="{{ route('doctor-videos.index') }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex-shrink-0 cursor-pointer {{ empty($selectedNeed) && empty($selectedAgeGroup) && empty($selectedAccess) && empty($selectedType) ? 'bg-[#2563ea] text-white shadow-xs font-black' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    الكل
                </a>

                <!-- Reels Only (No emoji, clean SVG) -->
                <a href="{{ route('doctor-videos.index', array_merge(request()->except('type'), ['type' => $selectedType === 'reels' ? null : 'reels'])) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex items-center gap-1.5 flex-shrink-0 cursor-pointer {{ $selectedType === 'reels' ? 'bg-rose-600 text-white shadow-xs font-black' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>ريلز سريعة</span>
                </a>

                <!-- Free (No emoji, clean SVG) -->
                <a href="{{ route('doctor-videos.index', array_merge(request()->except('access'), ['access' => $selectedAccess === 'free' ? null : 'free'])) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex items-center gap-1.5 flex-shrink-0 cursor-pointer {{ $selectedAccess === 'free' ? 'bg-emerald-600 text-white shadow-xs font-black' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>شروحات مجانية</span>
                </a>

                <!-- Paid / Exclusive (No emoji, clean SVG) -->
                <a href="{{ route('doctor-videos.index', array_merge(request()->except('access'), ['access' => $selectedAccess === 'paid' ? null : 'paid'])) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex items-center gap-1.5 flex-shrink-0 cursor-pointer {{ $selectedAccess === 'paid' ? 'bg-amber-600 text-white shadow-xs font-black' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <span>شروحات مدفوعة</span>
                </a>

                <!-- Divider -->
                @if($needs->isNotEmpty())
                    <div class="h-5 w-[1px] bg-slate-200 mx-1 flex-shrink-0"></div>

                    <!-- Needs / Problem Chips (Only those with videos) -->
                    @foreach($needs as $need)
                        <a href="{{ route('doctor-videos.index', array_merge(request()->except('need'), ['need' => $selectedNeed == $need->id || $selectedNeed == $need->slug ? null : $need->slug])) }}" 
                           class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex-shrink-0 cursor-pointer flex items-center gap-1.5 {{ $selectedNeed == $need->id || $selectedNeed == $need->slug ? 'bg-[#2563ea] text-white font-black shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                            <span>{{ $need->name }}</span>
                            <span class="text-[10px] px-1.5 py-0.2 rounded-full font-black {{ $selectedNeed == $need->id || $selectedNeed == $need->slug ? 'bg-white/25 text-white' : 'bg-slate-200 text-slate-600' }}">
                                {{ $need->doctor_videos_count }}
                            </span>
                        </a>
                    @endforeach
                @endif

                <!-- Divider -->
                @if($ageGroups->isNotEmpty())
                    <div class="h-5 w-[1px] bg-slate-200 mx-1 flex-shrink-0"></div>

                    <!-- Age Group Chips (Only those with videos) -->
                    @foreach($ageGroups as $ag)
                        <a href="{{ route('doctor-videos.index', array_merge(request()->except('age_group'), ['age_group' => $selectedAgeGroup == $ag->id || $selectedAgeGroup == $ag->slug ? null : $ag->slug])) }}" 
                           class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex-shrink-0 cursor-pointer flex items-center gap-1.5 {{ $selectedAgeGroup == $ag->id || $selectedAgeGroup == $ag->slug ? 'bg-purple-600 text-white font-black shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                            <span>{{ $ag->name }}</span>
                            <span class="text-[10px] px-1.5 py-0.2 rounded-full font-black {{ $selectedAgeGroup == $ag->id || $selectedAgeGroup == $ag->slug ? 'bg-white/25 text-white' : 'bg-slate-200 text-slate-600' }}">
                                {{ $ag->doctor_videos_count }}
                            </span>
                        </a>
                    @endforeach
                @endif

            </div>
        </div>

        <!-- Active Filter Indicator Bar (When filters are applied) -->
        @if($selectedNeed || $selectedAgeGroup || $selectedAccess || $selectedType || $searchQuery)
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3 bg-blue-50/70 border border-blue-100 p-3 sm:p-4 rounded-2xl">
                <div class="flex items-center gap-2 flex-wrap text-xs">
                    <span class="font-bold text-slate-700">التصفيات الحالية:</span>
                    @if($searchQuery)
                        <span class="bg-white border border-blue-200 text-slate-700 px-2.5 py-1 rounded-lg font-bold">بحث: "{{ $searchQuery }}"</span>
                    @endif
                    @if($selectedType)
                        <span class="bg-white border border-blue-200 text-slate-700 px-2.5 py-1 rounded-lg font-bold">{{ $selectedType === 'reels' ? 'ريلز سريعة' : 'فيديوهات تفصيلية' }}</span>
                    @endif
                    @if($selectedAccess)
                        <span class="bg-white border border-blue-200 text-slate-700 px-2.5 py-1 rounded-lg font-bold">{{ $selectedAccess === 'free' ? 'مجانية' : 'مدفوعة' }}</span>
                    @endif
                    @if($selectedNeed)
                        @php $currentNeedObj = $needs->first(fn($n) => $n->slug == $selectedNeed || $n->id == $selectedNeed); @endphp
                        <span class="bg-white border border-blue-200 text-slate-700 px-2.5 py-1 rounded-lg font-bold">{{ $currentNeedObj?->name ?? $selectedNeed }}</span>
                    @endif
                    @if($selectedAgeGroup)
                        @php $currentAgObj = $ageGroups->first(fn($a) => $a->slug == $selectedAgeGroup || $a->id == $selectedAgeGroup); @endphp
                        <span class="bg-white border border-blue-200 text-slate-700 px-2.5 py-1 rounded-lg font-bold">{{ $currentAgObj?->name ?? $selectedAgeGroup }}</span>
                    @endif
                </div>

                <a href="{{ route('doctor-videos.index') }}" class="text-xs font-bold text-[#2563ea] hover:underline flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    <span>إلغاء التصفية وعرض الكل</span>
                </a>
            </div>
        @endif

        <!-- 3. Shorts / Reels Carousel Section -->
        @if($reels->isNotEmpty() && $selectedType !== 'videos')
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-2xs mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-base sm:text-lg font-black text-slate-900 leading-tight">
                                مقاطع ريلز توعوية سريعة
                            </h2>
                            <p class="text-xs text-slate-500 font-semibold mt-0.5">شروحات سريعة ومبسطة لملاحظة سلوك وتطور الطفل</p>
                        </div>
                    </div>
                    <span class="text-xs text-slate-400 font-bold hidden sm:inline">انقر لمشاهدة المقطع</span>
                </div>

                <!-- Horizontal Reels Track -->
                <div class="flex items-center gap-3.5 sm:gap-4 overflow-x-auto pb-2 no-scrollbar snap-x" style="scrollbar-width: none;">
                    @foreach($reels as $reel)
                        <div class="flex-shrink-0 w-36 sm:w-48 snap-start group cursor-pointer" @click="openReel({{ Js::from($reel) }})">
                            <div class="relative rounded-2xl overflow-hidden bg-slate-900 aspect-[9/16] shadow-sm border border-slate-200 hover:border-rose-400 transition-all duration-300 group-hover:-translate-y-1 group-hover:shadow-md">
                                
                                <!-- Thumbnail Image -->
                                @if($reel->thumbnail)
                                    <img src="{{ $reel->thumbnail_url }}" alt="{{ $reel->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-slate-900">
                                        <svg class="w-10 h-10 text-rose-500/60" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                                    </div>
                                @endif

                                <!-- Gradient Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent flex flex-col justify-between p-3">
                                    <div class="flex items-center justify-between">
                                        <span class="bg-rose-600 text-white text-[10px] font-black px-2 py-0.5 rounded-full shadow-xs">
                                            ريلز
                                        </span>
                                        @if($reel->duration)
                                            <span class="bg-black/60 backdrop-blur-xs text-white text-[10px] font-mono px-1.5 py-0.5 rounded">
                                                {{ $reel->duration }}
                                            </span>
                                        @endif
                                    </div>

                                    <div>
                                        @if($reel->need)
                                            <span class="text-rose-300 text-[10px] sm:text-[11px] font-black block mb-0.5">{{ $reel->need->name }}</span>
                                        @endif
                                        <h3 class="text-white text-xs sm:text-sm font-bold line-clamp-2 leading-snug group-hover:text-rose-200 transition-colors">
                                            {{ $reel->title }}
                                        </h3>
                                        <div class="flex items-center gap-1 text-slate-300 text-[10px] mt-1 font-bold">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <span>{{ number_format($reel->views_count) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- 4. Main Video Grid (16:9 Detailed Videos & Explanations) -->
        <div class="mb-10">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#2563ea] flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-black text-slate-900 leading-tight">
                            شروحات وجلسات الدكتور التفصيلية
                        </h2>
                        <p class="text-xs text-slate-500 font-semibold mt-0.5">جلسات تشخيص وتوجيهات عملية خطوة بخطوة</p>
                    </div>
                </div>
                <span class="text-xs font-bold px-3 py-1 rounded-full bg-slate-200/70 text-slate-700">
                    {{ $videos->total() }} فيديو
                </span>
            </div>

            <!-- Video Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
                @forelse($videos as $video)
                    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 hover:border-blue-200 p-3 sm:p-3.5 shadow-2xs hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                        
                        <div>
                            <!-- Video Thumbnail -->
                            <a href="{{ route('doctor-videos.watch', $video->slug) }}" class="relative rounded-xl sm:rounded-2xl overflow-hidden bg-slate-100 aspect-video block shadow-2xs">
                                @if($video->thumbnail)
                                    <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400">
                                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    </div>
                                @endif

                                <!-- Play Hover Overlay -->
                                <div class="absolute inset-0 bg-slate-950/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <span class="w-11 h-11 rounded-full bg-[#2563ea] text-white flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5 ms-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    </span>
                                </div>

                                <!-- Duration Badge -->
                                @if($video->duration)
                                    <span class="absolute bottom-2 left-2 bg-black/75 backdrop-blur-xs text-white text-[10px] font-mono font-bold px-1.5 py-0.5 rounded-md">
                                        {{ $video->duration }}
                                    </span>
                                @endif

                                <!-- Access Badge (Paid vs Free) -->
                                <div class="absolute top-2 right-2">
                                    @if($video->is_paid)
                                        <span class="bg-amber-500 text-slate-950 text-[10px] font-black px-2.5 py-0.5 rounded-full shadow-xs flex items-center gap-1">
                                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                                            <span>مدفوع ({{ number_format($video->price, 0) }} ج.م)</span>
                                        </span>
                                    @else
                                        <span class="bg-emerald-600 text-white text-[10px] font-black px-2.5 py-0.5 rounded-full shadow-xs">
                                            مجاني
                                        </span>
                                    @endif
                                </div>
                            </a>

                            <!-- Meta Chips (Need & Age) -->
                            <div class="flex items-center gap-1.5 text-xs text-slate-500 mt-2.5 flex-wrap">
                                @if($video->need)
                                    <span class="text-[10px] font-black px-2 py-0.5 rounded-md bg-blue-50 text-[#2563ea]">{{ $video->need->name }}</span>
                                @endif
                                @if($video->ageGroup)
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-slate-100 text-slate-600">{{ $video->ageGroup->name }}</span>
                                @endif
                                <span class="text-[10px] font-bold text-slate-400 ms-auto flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span>{{ number_format($video->views_count) }}</span>
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 class="text-xs sm:text-sm font-black text-slate-900 line-clamp-2 mt-2 leading-snug group-hover:text-[#2563ea] transition-colors">
                                <a href="{{ route('doctor-videos.watch', $video->slug) }}">{{ $video->title }}</a>
                            </h3>

                            <!-- Description -->
                            @if($video->description)
                                <p class="text-[11px] text-slate-500 font-medium leading-relaxed line-clamp-2 mt-1">
                                    {{ Str::limit(strip_tags($video->description), 85) }}
                                </p>
                            @endif
                        </div>

                        <!-- Card Footer -->
                        <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between">
                            @if($video->products_count > 0)
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200/60 px-2 py-0.5 rounded-md">
                                    <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    <span>يتضمن أدوات موصى بها</span>
                                </span>
                            @else
                                <span class="text-[10px] font-bold text-slate-400">شروحات مركز تمورو</span>
                            @endif

                            <a href="{{ route('doctor-videos.watch', $video->slug) }}" class="text-xs font-black text-[#2563ea] hover:text-blue-700 flex items-center gap-0.5 transition-colors">
                                <span>مشاهدة</span>
                                <svg class="w-3 h-3 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-white rounded-3xl border border-dashed border-slate-200 p-8">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-[#2563ea] flex items-center justify-center mx-auto mb-3">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-base font-black text-slate-900 mb-1">لا توجد فيديوهات مطابقة للفلتر المحدد</h3>
                        <p class="text-xs text-slate-500 mb-4 font-semibold">جرب اختيار تصنيف آخر أو إلغاء بعض خيارات الفلترة أعلاه.</p>
                        <a href="{{ route('doctor-videos.index') }}" class="inline-flex items-center px-5 py-2.5 rounded-xl bg-[#2563ea] hover:bg-blue-700 text-white text-xs font-bold transition-colors shadow-xs">
                            إعادة ضبط كافة الفلاتر
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($videos->hasPages())
                <div class="mt-8">
                    {{ $videos->links() }}
                </div>
            @endif
        </div>

    </div>

    <!-- 5. Interactive Shorts Modal Viewer (Alpine.js) -->
    <div x-show="shortsModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-2 sm:p-4"
         @keydown.escape.window="shortsModalOpen = false">
        
        <!-- Close Button -->
        <button @click="shortsModalOpen = false" class="absolute top-4 left-4 z-50 p-2.5 rounded-full bg-white/20 hover:bg-white/30 text-white transition-colors cursor-pointer" title="إغلاق">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        <template x-if="activeReel">
            <div class="relative w-full max-w-sm sm:max-w-md aspect-[9/16] max-h-[90vh] rounded-3xl overflow-hidden bg-black shadow-2xl flex flex-col justify-between border border-slate-700">
                
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
                    <button @click="prevReel()" class="p-2 rounded-full bg-black/60 text-white hover:bg-black/85 transition-colors cursor-pointer" title="السابق">
                        <svg class="w-5 h-5 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="nextReel()" class="p-2 rounded-full bg-black/60 text-white hover:bg-black/85 transition-colors cursor-pointer" title="التالي">
                        <svg class="w-5 h-5 -rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                </div>

                <!-- Bottom Video Info -->
                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/95 via-black/60 to-transparent p-5 text-right z-20 pointer-events-none">
                    <div class="pointer-events-auto">
                        <template x-if="activeReel.need">
                            <span class="text-rose-400 font-black text-xs block mb-1" x-text="activeReel.need.name"></span>
                        </template>
                        <h3 class="text-white font-bold text-sm sm:text-base line-clamp-2 leading-snug mb-1.5" x-text="activeReel.title"></h3>
                        <p class="text-slate-300 text-xs line-clamp-2 mb-3 leading-relaxed" x-text="activeReel.description"></p>
                        
                        <div class="flex items-center gap-2">
                            <a :href="'/doctor-videos/' + activeReel.slug" class="px-4 py-2 rounded-xl bg-[#2563ea] hover:bg-blue-700 text-white text-xs font-black transition-colors inline-flex items-center gap-1.5 shadow-sm">
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
