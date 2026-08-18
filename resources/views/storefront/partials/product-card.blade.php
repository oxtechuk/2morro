<div class="bg-white rounded-2xl border border-slate-100 p-2.5 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col justify-between group">
    
    <!-- Image Box -->
    <div class="relative bg-[#F8FAFC] rounded-xl aspect-square flex items-center justify-center p-2 overflow-hidden">
        <!-- Badge -->
        @if($product->badge)
            <span class="absolute top-2 right-2 z-10 text-[9px] font-black px-2 py-0.5 rounded-full text-white bg-[#EF4444] shadow-xs">
                {{ $product->badge }}
            </span>
        @elseif($product->sale_price)
            <span class="absolute top-2 right-2 z-10 text-[9px] font-black px-2 py-0.5 rounded-full text-white bg-[#EF4444] shadow-xs">
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
                    // Smart fallback based on slug
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
    <div class="pt-2.5 flex flex-col flex-grow justify-between text-center">
        <div>
            <!-- Title -->
            <h3 class="text-xs font-bold text-slate-800 leading-tight truncate group-hover:text-blue-600 transition-colors">
                <a href="{{ route('product', $product->slug) }}">{{ $product->name }}</a>
            </h3>

            <!-- Rating Stars -->
            <div class="flex items-center justify-center gap-1 mt-1 text-slate-400">
                <div class="flex items-center text-amber-400 text-xs">
                    ★★★★★
                </div>
                <span class="text-[10px] text-slate-400 font-bold">({{ rand(120, 320) }}) 4.9</span>
            </div>
        </div>

        <!-- Price & Cart Action -->
        <div class="flex items-center justify-between mt-2.5 pt-2 border-t border-slate-50">
            <div class="flex items-baseline gap-1">
                @if($product->sale_price)
                    <span class="text-xs font-black text-[#102A63]">{{ number_format($product->sale_price, 0) }} جنيه</span>
                    <span class="text-[9px] text-slate-400 line-through font-semibold">{{ number_format($product->price, 0) }}</span>
                @else
                    <span class="text-xs font-black text-[#102A63]">{{ number_format($product->price, 0) }} جنيه</span>
                @endif
            </div>

            <!-- Quick Add to Cart Button -->
            <form action="{{ route('cart.add') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" title="أضف إلى السلة" class="w-7 h-7 rounded-lg bg-[#102A63] hover:bg-blue-600 text-white flex items-center justify-center transition-colors shadow-xs group/btn">
                    <svg class="w-3.5 h-3.5 transition-transform group-hover/btn:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </button>
            </form>
        </div>
    </div>

</div>
