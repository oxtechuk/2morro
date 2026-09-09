<template>
    <div
        v-if="master.showTopHeader && master.topHeaderText"
        class="text-[11px] font-bold py-1.5 px-2 overflow-hidden shadow-2xs select-none transition-all duration-300"
        :style="{
            backgroundColor: master.topHeaderBgColor || '#2563ea',
            color: master.topHeaderTextColor || '#ffffff'
        }"
    >
        <div class="main-container flex items-center justify-center text-center">
            <a
                v-if="master.topHeaderLink"
                :href="master.topHeaderLink"
                class="hover:underline flex items-center justify-center gap-2 cursor-pointer w-full"
                :style="{ color: master.topHeaderTextColor || '#ffffff' }"
            >
                <span>{{ master.topHeaderText }}</span>
            </a>
            <span v-else class="w-full text-center">
                {{ master.topHeaderText }}
            </span>
        </div>
    </div>
</template>

<script setup>
import { useMaster } from "../stores/MasterStore";

const master = useMaster();
</script>
