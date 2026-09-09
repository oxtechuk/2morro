<template>
    <button
        class="w-full flex justify-center items-center gap-2 px-6 py-3 rounded-[8px] bg-primary text-white text-base font-medium hover:opacity-90 transition disabled:opacity-50 disabled:cursor-not-allowed"
        :disabled="!details.is_available"
        @click="$emit('click')"
    >
        <ClockIcon class="w-5 h-5 shrink-0" />
        {{ details.is_available ? $t("Pre-Order Now") : $t("Currently unavailable") }}
    </button>
</template>

<script setup>
import { ClockIcon } from "@heroicons/vue/24/outline";

defineProps({
    details: { type: Object, default: () => ({}) },
});
defineEmits(["click"]);
</script>
