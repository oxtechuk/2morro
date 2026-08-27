<div class="bg-white rounded-2xl border border-slate-200/80 p-2 sm:p-3 shadow-2xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col justify-between group h-full">
    
    <!-- Image Box -->
    <div class="relative bg-[#F8FAFC] rounded-xl aspect-square flex items-center justify-center p-2 overflow-hidden">
        <!-- Badge -->
        @if($product->badge)
            <span class="absolute top-1.5 right-1.5 z-10 text-[8px] sm:text-[9px] font-black px-2 py-0.5 rounded-full text-white bg-[#EF4444] shadow-xs">
                {{ $product->badge }}
            </span>
        @elseif($product->sale_price)
            <span class="absolute top-1.5 right-1.5 z-10 text-[8px] sm:text-[9px] font-black px-2 py-0.5 rounded-full text-white bg-[#EF4444] shadow-xs">
                خصم {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
            </span>
        @endif

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
                 class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
        </a>
    </div>

    <!-- Product Info -->
    <div class="pt-2 flex flex-col flex-grow justify-between text-right">
        <div>
            <!-- Title -->
            <h3 class="text-[11px] sm:text-xs font-bold text-slate-800 leading-snug line-clamp-2 min-h-[28px] sm:min-h-[32px] group-hover:text-[#2563ea] transition-colors">
                <a href="{{ route('product', $product->slug) }}">{{ $product->name }}</a>
            </h3>

            <!-- Rating Stars (Subtle) -->
            <div class="flex items-center gap-1 mt-1 text-slate-400">
                <div class="flex items-center text-amber-400 text-[10px] sm:text-xs">
                    ★★★★★
                </div>
                <span class="text-[9px] sm:text-[10px] text-slate-400 font-bold">(4.9)</span>
            </div>
        </div>

        <!-- Price & Cart Action -->
        <div class="flex items-center justify-between mt-2 pt-2 border-t border-slate-100">
            <div class="flex flex-col">
                @if($product->sale_price)
                    <span class="text-xs sm:text-sm font-black text-[#2563ea]">{{ number_format($product->sale_price, 0) }} ج.م</span>
                    <span class="text-[9px] text-slate-400 line-through font-semibold -mt-0.5">{{ number_format($product->price, 0) }} ج.م</span>
                @else
                    <span class="text-xs sm:text-sm font-black text-[#2563ea]">{{ number_format($product->price, 0) }} ج.م</span>
                @endif
            </div>

            <!-- Quick Add to Cart Button -->
            <form action="{{ route('cart.add') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" title="أضف إلى السلة" class="w-8 h-8 rounded-xl bg-blue-50 hover:bg-[#2563ea] text-[#2563ea] hover:text-white flex items-center justify-center transition-all duration-200 shadow-2xs group/btn active:scale-95">
                    <svg class="w-4 h-4 transition-transform group-hover/btn:scale-110" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </button>
            </form>
        </div>
    </div>

</div>
