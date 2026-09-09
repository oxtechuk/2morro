<template>
    <div class="rounded-2xl border border-primary/20 overflow-hidden">
        <div class="flex items-center gap-2 px-4 py-2.5 bg-primary/5">
            <ClockIcon class="w-4 h-4 text-primary shrink-0" />
            <span class="text-primary text-sm font-semibold">{{ $t("Pre-Order Item") }}</span>
            <span
                v-if="!details.is_available"
                class="ml-auto text-red-500 text-xs font-medium"
                >{{ $t("Currently unavailable") }}</span
            >
        </div>
        <div class="px-4 py-3 grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="flex items-center gap-2">
                <TruckIcon class="w-4 h-4 text-slate-400 shrink-0" />
                <div class="min-w-0">
                    <div class="text-slate-400 text-xs">{{ $t("Expected Delivery") }}</div>
                    <div class="text-slate-800 text-sm font-medium truncate">
                        {{ details.expected_delivery_date || $t("To be announced") }}
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <ArrowPathIcon class="w-4 h-4 text-slate-400 shrink-0" />
                <div class="min-w-0">
                    <div class="text-slate-400 text-xs">{{ $t("Refund") }}</div>
                    <div
                        class="text-sm font-medium"
                        :class="details.is_refund ? 'text-emerald-500' : 'text-red-500'"
                    >
                        {{ details.is_refund ? $t("Refundable") : $t("Non-refundable") }}
                    </div>
                </div>
            </div>
            <div v-if="details.is_prepay" class="flex items-center gap-2 sm:col-span-2">
                <div class="w-4 h-4 flex items-center justify-center rounded bg-primary/10 text-primary shrink-0 text-[10px] font-bold">%</div>
                <div class="min-w-0">
                    <div class="text-slate-400 text-xs">{{ $t("Prepayment Required") }}</div>
                    <div class="text-primary text-sm font-semibold">
                        {{ master.showCurrency(parseFloat(details.prepay_amount || 0).toFixed(2)) }}
                        <span class="text-slate-400 font-normal">/ {{ $t("unit") }}</span>
                    </div>
                </div>
            </div>
        </div>
        <p
            v-if="details.preorder_notice"
            class="px-4 pb-3 text-slate-500 text-xs leading-relaxed"
        >
            {{ details.preorder_notice }}
        </p>
    </div>
</template>

<script setup>
import { ClockIcon, TruckIcon, ArrowPathIcon } from "@heroicons/vue/24/outline";
import { useMaster } from "../../stores/MasterStore";

defineProps({
    details: { type: Object, default: () => ({}) },
});

const master = useMaster();
</script>
