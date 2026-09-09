<template>
    <div
        v-if="!isLoading"
        class="min-h-[200px] md:min-h-[300px] lg:min-h-[360px] xl:min-h-[380px] max-h-[420px] bg-no-repeat bg-cover bg-center flex items-center"
        :style="'background-image: url('+banners[0].thumbnail+')'"
        :dir="master.langDirection || 'ltr'"
    >
        <div
            class="container-3 w-full h-full flex items-center"
            :class="
                master.langDirection == 'ltr' ? 'justify-start' : 'justify-end'
            "
        >
            <div class="h-full w-full max-w-[601px] text-white">
                <p
                    class="text-white text-2xl md:text-4xl lg:text-5xl font-medium font-['Lato'] leading-tight md:leading-normal lg:leading-[60px] text-center md:text-start capitalize"
                >
                    {{ banners[0].title }}
                </p>
            </div>
        </div>
    </div>

    <!-- Skeleton loader -->
    <div v-else class="h-[200px] md:h-[300px] lg:h-[380px]">
            <div class="w-full h-full">
                <SkeletonLoader class="w-full h-full" />
            </div>
    </div>
</template>

<script setup>
import { Swiper, SwiperSlide } from "swiper/vue";
import {
    Navigation,
    Pagination,
    A11y,
    Autoplay,
    EffectFade,
} from "swiper/modules";
import { useMaster } from "../../stores/MasterStore";
const master = useMaster();
import SkeletonLoader from "../SkeletonLoader.vue";

// Import Swiper styles
import "swiper/css";
import "swiper/css/effect-fade";

import "swiper/css/navigation";
import "swiper/css/pagination";

const modules = [Navigation, Pagination, A11y, Autoplay, EffectFade];

const props = defineProps({
    banners: Array,
    ads: Array,
    isLoading: {
        type: Boolean,
        default: true,
    },
});
</script>

<style>
.mySwiper .swiper-button-prev,
.mySwiper .swiper-button-next {
    position: absolute;
    width: 40px;
    height: 40px;
    background-color: #fff;
    color: #475569 !important;
    border-radius: 8px !important;
    margin-top: auto;
    @apply hidden md:flex;
}

.mySwiper .swiper-button-next {
    left: auto;
    right: 20px;
    bottom: 20px;
}

.mySwiper .swiper-button-prev {
    left: auto;
    right: 70px;
    bottom: 20px;
}
[dir="ltr"] .mySwiper .swiper-button-prev {
    left: auto;
    right: 70px;
}

[dir="ltr"] .mySwiper .swiper-button-next {
    left: auto;
    right: 20px;
}

/* RTL */
[dir="rtl"] .mySwiper .swiper-button-prev {
    right: auto;
    left: 70px;
}

[dir="rtl"] .mySwiper .swiper-button-next {
    right: auto;
    left: 20px;
}

.mySwiper .swiper-button-prev:after,
.mySwiper .swiper-button-next:after {
    color: black;
    font-size: 12px !important;
    font-weight: bolder;
}

.mySwiper .swiper-pagination-bullet {
    background: white;
    opacity: 1;
    @apply h-2 w-2 md:w-4 md:h-4 rounded-lg transition-all duration-200;
}

.mySwiper .swiper-pagination-bullet-active {
    @apply bg-primary w-6 md:h-4 rounded-lg transition-all duration-200;
}
</style>
