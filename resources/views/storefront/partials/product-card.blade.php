<div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 hover:border-blue-200 p-2.5 sm:p-3.5 shadow-2xs hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group h-full relative overflow-hidden">
    
    <!-- Image Box -->
    <div class="relative bg-gradient-to-b from-[#F8FAFC] to-slate-100/70 rounded-xl sm:rounded-2xl aspect-square flex items-center justify-center p-2.5 overflow-hidden">
        
        <!-- Badges (Top Right) -->
        <div class="absolute top-2 right-2 z-10 flex flex-col items-end gap-1">
            @if($product->badge)
                <span class="text-[9px] sm:text-[10px] font-black px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-full text-white bg-gradient-to-r from-red-500 to-rose-600 shadow-xs">
                    {{ $product->badge }}
                </span>
            @elseif($product->sale_price)
                <span class="text-[9px] sm:text-[10px] font-black px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-full text-white bg-[#EF4444] shadow-xs">
                    خصم {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                </span>
            @endif
        </div>

        <!-- Badges (Top Left - Type / Age) -->
        <div class="absolute top-2 left-2 z-10">
            @if($product->type === 'digital')
                <span class="text-[8px] sm:text-[9px] font-extrabold px-2 py-0.5 rounded-full text-teal-700 bg-teal-50 border border-teal-200/60 shadow-2xs">
                    PDF فوري
                </span>
            @elseif($product->type === 'bundle')
                <span class="text-[8px] sm:text-[9px] font-extrabold px-2 py-0.5 rounded-full text-purple-700 bg-purple-50 border border-purple-200/60 shadow-2xs">
                    باقة توفير
                </span>
            @elseif($product->ageGroups && $product->ageGroups->count() > 0)
                <span class="text-[8px] sm:text-[9px] font-extrabold px-2 py-0.5 rounded-full text-slate-600 bg-white/90 backdrop-blur-xs border border-slate-200/60 shadow-2xs">
                    {{ $product->ageGroups->first()->name }}
                </span>
            @endif
        </div>

        <!-- Product Image with reliable fallback -->
        <a href="{{ route('product', $product->slug) }}" class="w-full h-full flex items-center justify-center">
            @php
                $imgUrl = null;
                if ($product->images && count($product->images) > 0) {
                    $imgUrl = asset('storage/' . $product->images[0]);
                } else {
                    if (str_contains($product->slug, 'clock')) {
                        $imgUrl = asset('storage/products/clock.jpg');
                    } elseif (str_contains($product->slug, 'puzzle')) {
                        $imgUrl = asset('storage/products/puzzle.jpg');
                    } elseif (str_contains($product->slug, 'bundle')) {
                        $imgUrl = asset('storage/products/sample-bundle.jpg');
                    } elseif (str_contains($product->slug, 'pdf') || str_contains($product->slug, 'worksheet')) {
                        $imgUrl = asset('storage/products/sample-pdf.jpg');
                    } else {
                        $imgUrl = asset('storage/products/sample-cards.jpg');
                    }
                }
            @endphp
            <img src="{{ $imgUrl }}" 
                 alt="{{ $product->name }}" 
                 onerror="this.onerror=null; this.src='{{ asset('storage/products/sample-cards.jpg') }}';"
                 class="w-full h-full object-contain group-hover:scale-108 transition-transform duration-500 ease-out">
        </a>
    </div>

    <!-- Product Info -->
    <div class="pt-2.5 sm:pt-3 flex flex-col flex-grow justify-between text-right">
        <div>
            <!-- Category & Rating Header -->
            <div class="flex items-center justify-between text-[10px] sm:text-[11px] mb-1">
                @if($product->categories && $product->categories->first())
                    <span class="text-[#2563ea] font-bold truncate max-w-[65%]">
                        {{ $product->categories->first()->name }}
                    </span>
                @else
                    <span class="text-slate-400 font-bold">تمورو التعليمي</span>
                @endif
                <div class="flex items-center gap-1 text-amber-400 font-bold text-[9px] sm:text-[10px]">
                    <span>★</span>
                    <span class="text-slate-400 font-bold">4.9</span>
                </div>
            </div>

            <!-- Title -->
            <h3 class="text-xs sm:text-sm font-black text-slate-800 leading-snug line-clamp-2 min-h-[34px] sm:min-h-[38px] group-hover:text-[#2563ea] transition-colors">
                <a href="{{ route('product', $product->slug) }}">{{ $product->name }}</a>
            </h3>

            <!-- Short Description (الوصف القصير) -->
            <p class="text-[10px] sm:text-[11px] text-slate-500 font-medium leading-relaxed line-clamp-2 mt-1 sm:mt-1.5 min-h-[28px] sm:min-h-[32px]" title="{{ $product->short_description ?: strip_tags($product->description) }}">
                {{ $product->short_description ?: \Illuminate\Support\Str::limit(strip_tags($product->description), 65) }}
            </p>
        </div>

        <!-- Bottom Section: Pricing & Dual CTA Buttons -->
        <div class="mt-2.5">
            <!-- Price Section -->
            <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                <div class="flex items-baseline gap-1.5 flex-wrap">
                    @if($product->sale_price)
                        <span class="text-sm sm:text-base font-black text-[#1360e2]">{{ number_format($product->sale_price, 0) }} ج.م</span>
                        <span class="text-[10px] sm:text-[11px] text-slate-400 line-through font-semibold">{{ number_format($product->price, 0) }} ج.م</span>
                    @else
                        <span class="text-sm sm:text-base font-black text-[#1360e2]">{{ number_format($product->price, 0) }} ج.م</span>
                    @endif
                </div>
                @if($product->sale_price)
                    <span class="text-[9px] sm:text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200/60">
                        وفر {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                    </span>
                @endif
            </div>

            <!-- Out of Stock or Action Buttons -->
            @if($product->type === 'physical' && $product->stock <= 0)
                <div class="mt-2.5 pt-2 border-t border-slate-100">
                    <button type="button" disabled class="w-full h-8 sm:h-9 rounded-xl bg-slate-100 text-slate-400 font-bold text-[10px] sm:text-xs flex items-center justify-center cursor-not-allowed">
                        نفذت الكمية حالياً
                    </button>
                </div>
            @else
                <!-- Dual Action Buttons: إضافة للسلة & شراء الآن -->
                <div class="grid grid-cols-2 gap-1.5 sm:gap-2 mt-2 pt-2 border-t border-slate-100">
                    <!-- زر إضافة للسلة -->
                    <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" 
                                title="أضف إلى السلة" 
                                class="w-full h-8 sm:h-9 rounded-xl bg-blue-50/90 hover:bg-[#2563ea] text-[#2563ea] hover:text-white font-bold text-[10px] sm:text-xs flex items-center justify-center gap-1 transition-all duration-200 border border-blue-100/80 active:scale-95 shadow-2xs group/btn cursor-pointer">
                            <svg class="w-3.5 h-3.5 transition-transform group-hover/btn:scale-110 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <span class="truncate">أضف للسلة</span>
                        </button>
                    </form>

                    <!-- زر شراء الآن -->
                    <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="buy_now" value="1">
                        <button type="submit" 
                                title="شراء فوري والدفع مباشرة" 
                                class="w-full h-8 sm:h-9 rounded-xl bg-[#f76d11] hover:bg-[#e05e0a] text-white font-bold text-[10px] sm:text-xs flex items-center justify-center gap-1 transition-all duration-200 active:scale-95 shadow-2xs hover:shadow-xs group/buy cursor-pointer">
                            <svg class="w-3.5 h-3.5 transition-transform group-hover/buy:scale-110 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span class="truncate">شراء الآن</span>
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

</div>
