<template>
    <div class="p-5 sm:p-7 bg-white rounded-2xl border border-slate-200/80 shadow-xs">
        <!-- Header -->
        <div class="flex items-center gap-3 pb-5 border-b border-slate-100">
            <span class="w-1.5 h-6 rounded-full bg-rose-600 inline-block"></span>
            <h3 class="text-slate-900 text-lg sm:text-xl font-bold tracking-tight">
                {{ $t('Payment Method') || 'طريقة الدفع وتحصيل الحساب' }}
            </h3>
        </div>

        <!-- Options Container -->
        <div class="mt-5 space-y-4">

            <!-- 1. Cash on Delivery (COD) -->
            <div
                v-if="master.cashOnDelivery"
                @click="selectMethod('cash')"
                class="payment-option-card relative rounded-xl border p-4 sm:p-5 cursor-pointer transition-all duration-300"
                :class="selectedMethod === 'cash' ? 'border-primary bg-primary-50/20 shadow-sm ring-1 ring-primary/30' : 'border-slate-200 bg-white hover:border-slate-300 hover:shadow-2xs'"
            >
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3.5">
                        <!-- Custom Radio -->
                        <div class="relative flex items-center justify-center">
                            <span class="w-5 h-5 rounded-full border transition-all duration-200 flex items-center justify-center"
                                :class="selectedMethod === 'cash' ? 'border-primary bg-primary' : 'border-slate-300 bg-white'">
                                <span v-if="selectedMethod === 'cash'" class="w-2 h-2 rounded-full bg-white"></span>
                            </span>
                        </div>

                        <!-- Title & Description -->
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-slate-900 text-sm sm:text-base font-bold">
                                    {{ $t('Cash on Delivery') }} (Cash on Delivery)
                                </span>
                                <span class="px-2 py-0.5 text-[11px] font-bold rounded-md bg-slate-100 text-slate-600 border border-slate-200/60">
                                    COD
                                </span>
                            </div>
                            <p class="text-slate-500 text-xs sm:text-sm font-normal mt-1 leading-relaxed">
                                {{ $t('Cash on delivery note') || 'الدفع نقداً للمندوب عند استلام الشحنة أمام باب منزلك (متاح فقط للمنتجات المادية).' }}
                            </p>
                        </div>
                    </div>

                    <!-- Icon -->
                    <div class="hidden sm:flex items-center justify-center w-10 h-10 rounded-xl bg-slate-50 border border-slate-200/80 shrink-0 text-slate-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- 2. InstaPay -->
            <div
                @click="selectMethod('instapay')"
                class="payment-option-card relative rounded-xl border p-4 sm:p-5 cursor-pointer transition-all duration-300"
                :class="selectedMethod === 'instapay' ? 'border-[#831F82] bg-purple-50/25 shadow-sm ring-1 ring-[#831F82]/30' : 'border-slate-200 bg-white hover:border-purple-300 hover:shadow-2xs'"
            >
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3.5">
                        <!-- Custom Radio -->
                        <div class="relative flex items-center justify-center">
                            <span class="w-5 h-5 rounded-full border transition-all duration-200 flex items-center justify-center"
                                :class="selectedMethod === 'instapay' ? 'border-[#831F82] bg-[#831F82]' : 'border-slate-300 bg-white'">
                                <span v-if="selectedMethod === 'instapay'" class="w-2 h-2 rounded-full bg-white"></span>
                            </span>
                        </div>

                        <!-- Title & Description -->
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-slate-900 text-sm sm:text-base font-bold flex items-center gap-1.5">
                                    <span class="text-[#831F82]">⚡</span>
                                    <span>الدفع عبر تطبيق إنستاباي (InstaPay)</span>
                                </span>
                                <span class="px-2 py-0.5 text-[11px] font-bold rounded-md bg-purple-100 text-[#831F82] border border-purple-200">
                                    تحويل فوري 0% رسوم
                                </span>
                            </div>
                            <p class="text-slate-500 text-xs sm:text-sm font-normal mt-1 leading-relaxed">
                                حول إجمالي المبلغ عبر تطبيق InstaPay إلى عنوان الدفع الرسمي أدناه وارفع صورة التحويل:
                            </p>
                        </div>
                    </div>

                    <!-- Logo -->
                    <div class="shrink-0">
                        <img :src="'assets/icons/instapay.svg'" alt="InstaPay Logo" class="h-8 sm:h-9 object-contain rounded-md shadow-2xs" />
                    </div>
                </div>

                <!-- Account Info Box -->
                <div
                    v-if="selectedMethod === 'instapay'"
                    class="mt-4 pt-3.5 border-t border-purple-100/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-purple-50/60 p-3.5 rounded-xl"
                >
                    <div class="flex items-center gap-2">
                        <span class="text-xs sm:text-sm font-bold text-slate-700">عنوان الدفع (IPA):</span>
                        <code class="px-2.5 py-1 text-xs sm:text-sm font-bold text-[#831F82] bg-white rounded-lg border border-purple-200 font-mono select-all">
                            hebaallaakrm@instapay
                        </code>
                    </div>

                    <button
                        type="button"
                        @click.stop="copyText('hebaallaakrm@instapay', 'instapay')"
                        class="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-bold text-[#831F82] bg-white hover:bg-purple-100/60 border border-purple-200 transition-colors shadow-2xs"
                    >
                        <svg v-if="copiedField === 'instapay'" class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span>{{ copiedField === 'instapay' ? 'تم النسخ ✓' : 'نسخ المعرف' }}</span>
                    </button>
                </div>
            </div>

            <!-- 3. Vodafone Cash / Wallets -->
            <div
                @click="selectMethod('vodafone_cash')"
                class="payment-option-card relative rounded-xl border p-4 sm:p-5 cursor-pointer transition-all duration-300"
                :class="selectedMethod === 'vodafone_cash' ? 'border-[#E60000] bg-rose-50/25 shadow-sm ring-1 ring-[#E60000]/30' : 'border-slate-200 bg-white hover:border-rose-300 hover:shadow-2xs'"
            >
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3.5">
                        <!-- Custom Radio -->
                        <div class="relative flex items-center justify-center">
                            <span class="w-5 h-5 rounded-full border transition-all duration-200 flex items-center justify-center"
                                :class="selectedMethod === 'vodafone_cash' ? 'border-[#E60000] bg-[#E60000]' : 'border-slate-300 bg-white'">
                                <span v-if="selectedMethod === 'vodafone_cash'" class="w-2 h-2 rounded-full bg-white"></span>
                            </span>
                        </div>

                        <!-- Title & Description -->
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-slate-900 text-sm sm:text-base font-bold flex items-center gap-1.5">
                                    <span class="text-[#E60000]">📱</span>
                                    <span>الدفع عبر المحافظ الإلكترونية (فودافون كاش / اتصالات / أورانج / وي)</span>
                                </span>
                                <span class="px-2 py-0.5 text-[11px] font-bold rounded-md bg-rose-100 text-[#E60000] border border-rose-200">
                                    فودافون كاش
                                </span>
                            </div>
                            <p class="text-slate-500 text-xs sm:text-sm font-normal mt-1 leading-relaxed">
                                حول المبلغ الإجمالي إلى رقم محفظة المركز المعتمدة أدناه ثم ارفع صورة التحويل:
                            </p>
                        </div>
                    </div>

                    <!-- Logo -->
                    <div class="shrink-0">
                        <img :src="'assets/icons/vodafone-cash.svg'" alt="Vodafone Cash Logo" class="h-8 sm:h-9 object-contain rounded-md shadow-2xs" />
                    </div>
                </div>

                <!-- Account Info Box -->
                <div
                    v-if="selectedMethod === 'vodafone_cash'"
                    class="mt-4 pt-3.5 border-t border-rose-100/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-rose-50/60 p-3.5 rounded-xl"
                >
                    <div class="flex items-center gap-2">
                        <span class="text-xs sm:text-sm font-bold text-slate-700">رقم المحفظة (فودافون كاش):</span>
                        <code class="px-2.5 py-1 text-xs sm:text-sm font-bold text-[#E60000] bg-white rounded-lg border border-rose-200 font-mono tracking-wider select-all">
                            01024308445
                        </code>
                    </div>

                    <button
                        type="button"
                        @click.stop="copyText('01024308445', 'vodafone')"
                        class="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-bold text-[#E60000] bg-white hover:bg-rose-100/60 border border-rose-200 transition-colors shadow-2xs"
                    >
                        <svg v-if="copiedField === 'vodafone'" class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span>{{ copiedField === 'vodafone' ? 'تم النسخ ✓' : 'نسخ الرقم' }}</span>
                    </button>
                </div>
            </div>

            <!-- 4. Bank Transfer / IBAN -->
            <div
                @click="selectMethod('bank_transfer')"
                class="payment-option-card relative rounded-xl border p-4 sm:p-5 cursor-pointer transition-all duration-300"
                :class="selectedMethod === 'bank_transfer' ? 'border-[#047857] bg-emerald-50/25 shadow-sm ring-1 ring-[#047857]/30' : 'border-slate-200 bg-white hover:border-emerald-300 hover:shadow-2xs'"
            >
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3.5">
                        <!-- Custom Radio -->
                        <div class="relative flex items-center justify-center">
                            <span class="w-5 h-5 rounded-full border transition-all duration-200 flex items-center justify-center"
                                :class="selectedMethod === 'bank_transfer' ? 'border-[#047857] bg-[#047857]' : 'border-slate-300 bg-white'">
                                <span v-if="selectedMethod === 'bank_transfer'" class="w-2 h-2 rounded-full bg-white"></span>
                            </span>
                        </div>

                        <!-- Title & Description -->
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-slate-900 text-sm sm:text-base font-bold flex items-center gap-1.5">
                                    <span class="text-[#047857]">🏛️</span>
                                    <span>التحويل البنكي المباشر (Bank Transfer / IBAN)</span>
                                </span>
                                <span class="px-2 py-0.5 text-[11px] font-bold rounded-md bg-emerald-100 text-[#047857] border border-emerald-200">
                                    حساب بنكي / آيبان
                                </span>
                            </div>
                            <p class="text-slate-500 text-xs sm:text-sm font-normal mt-1 leading-relaxed">
                                حول المبلغ من حسابك البنكي أو عبر تطبيق البنك باستخدام الآيبان (IBAN) وارفع صورة الإيصال:
                            </p>
                        </div>
                    </div>

                    <!-- Logo -->
                    <div class="shrink-0">
                        <img :src="'assets/icons/bank-transfer.svg'" alt="Bank Transfer Logo" class="h-8 sm:h-9 object-contain rounded-md shadow-2xs" />
                    </div>
                </div>

                <!-- Bank Info Box -->
                <div
                    v-if="selectedMethod === 'bank_transfer'"
                    class="mt-4 pt-3.5 border-t border-emerald-100/80 bg-emerald-50/60 p-3.5 rounded-xl space-y-2.5"
                >
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs sm:text-sm">
                        <div class="flex items-center gap-1.5 text-slate-700">
                            <span class="font-bold">اسم البنك:</span>
                            <span class="font-semibold text-slate-900">بنك القاهرة (Banque du Caire)</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-slate-700">
                            <span class="font-bold">اسم المستفيد:</span>
                            <span class="font-semibold text-slate-900">مركز 2morro - أ. هبة الله أكرم</span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-2 border-t border-emerald-200/50">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-xs sm:text-sm font-bold text-slate-700">رقم الآيبان (IBAN):</span>
                            <code class="px-2.5 py-1 text-xs font-bold text-[#047857] bg-white rounded-lg border border-emerald-200 font-mono select-all break-all">
                                EG480004202000002103050038654
                            </code>
                        </div>

                        <button
                            type="button"
                            @click.stop="copyText('EG480004202000002103050038654', 'iban')"
                            class="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-bold text-[#047857] bg-white hover:bg-emerald-100/60 border border-emerald-200 transition-colors shadow-2xs shrink-0"
                        >
                            <svg v-if="copiedField === 'iban'" class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <span>{{ copiedField === 'iban' ? 'تم النسخ ✓' : 'نسخ IBAN' }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- 5. Online Payment Gateways (Stripe, Credit Cards) -->
            <div
                v-if="master.onlinePayment && master.paymentGateways && master.paymentGateways.length > 0"
                @click="selectMethod('card')"
                class="payment-option-card relative rounded-xl border p-4 sm:p-5 cursor-pointer transition-all duration-300"
                :class="selectedMethod === 'card' || isGatewaySelected ? 'border-primary bg-blue-50/20 shadow-sm ring-1 ring-primary/30' : 'border-slate-200 bg-white hover:border-slate-300 hover:shadow-2xs'"
            >
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3.5">
                        <!-- Custom Radio -->
                        <div class="relative flex items-center justify-center">
                            <span class="w-5 h-5 rounded-full border transition-all duration-200 flex items-center justify-center"
                                :class="(selectedMethod === 'card' || isGatewaySelected) ? 'border-primary bg-primary' : 'border-slate-300 bg-white'">
                                <span v-if="selectedMethod === 'card' || isGatewaySelected" class="w-2 h-2 rounded-full bg-white"></span>
                            </span>
                        </div>

                        <!-- Title & Description -->
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-slate-900 text-sm sm:text-base font-bold">
                                    {{ $t('Credit or Debit Card') }} (الدفع بالبطاقات البنكية)
                                </span>
                                <span class="px-2 py-0.5 text-[11px] font-bold rounded-md bg-blue-100 text-blue-700 border border-blue-200">
                                    فيزا / ماستركارد
                                </span>
                            </div>
                            <p class="text-slate-500 text-xs sm:text-sm font-normal mt-1 leading-relaxed">
                                ادفع إلكترونياً بأمان تام عبر البطاقات البنكية (Visa / MasterCard).
                            </p>
                        </div>
                    </div>

                    <!-- Icon -->
                    <div class="hidden sm:flex items-center justify-center w-10 h-10 rounded-xl bg-slate-50 border border-slate-200/80 shrink-0 text-slate-700">
                        <img :src="'assets/icons/card.svg'" alt="Card" class="w-6 h-6" />
                    </div>
                </div>

                <!-- Gateways List -->
                <div
                    v-if="selectedMethod === 'card' || isGatewaySelected"
                    class="mt-4 pt-3.5 border-t border-slate-200/80"
                >
                    <span class="text-slate-700 block text-xs sm:text-sm font-semibold mb-2.5">
                        {{ $t('Available Payment Gateways') }}:
                    </span>
                    <div class="flex flex-wrap gap-3">
                        <label
                            v-for="gateway in master.paymentGateways"
                            :key="gateway.id"
                            :for="'gw-' + gateway.name"
                            class="flex items-center gap-3 border p-2.5 rounded-xl cursor-pointer transition-all duration-200"
                            :class="selectedGateway === gateway.name ? 'border-primary bg-white shadow-xs ring-1 ring-primary/40' : 'border-slate-200 bg-slate-50 hover:bg-white'"
                        >
                            <input
                                type="radio"
                                :id="'gw-' + gateway.name"
                                name="paymentGatewayOption"
                                :value="gateway.name"
                                v-model="selectedGateway"
                                class="sr-only"
                            />
                            <img :src="gateway.logo" :alt="gateway.name" class="w-24 h-10 object-contain" />
                        </label>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup>
import { computed, ref, watch } from 'vue';
import { useMaster } from '../stores/MasterStore';

const props = defineProps({
    modelValue: {
        type: String,
        default: 'instapay'
    }
});

const emit = defineEmits(['update:modelValue']);

const master = useMaster();

const selectedMethod = ref(props.modelValue || 'instapay');
const selectedGateway = ref(master.paymentGateways?.[0]?.name || null);
const copiedField = ref(null);

const isGatewaySelected = computed(() => {
    return master.paymentGateways?.some(g => g.name === selectedMethod.value);
});

const selectMethod = (method) => {
    selectedMethod.value = method;
    if (method === 'card') {
        if (!selectedGateway.value && master.paymentGateways?.length) {
            selectedGateway.value = master.paymentGateways[0]?.name;
        }
        emit('update:modelValue', selectedGateway.value || 'card');
    } else {
        emit('update:modelValue', method);
    }
};

watch(selectedGateway, (newGateway) => {
    if (selectedMethod.value === 'card' && newGateway) {
        emit('update:modelValue', newGateway);
    }
});

watch(() => props.modelValue, (newVal) => {
    if (newVal && newVal !== selectedMethod.value) {
        selectedMethod.value = newVal;
    }
});

const copyText = async (text, fieldName) => {
    try {
        if (navigator.clipboard && window.isSecureContext) {
            await navigator.clipboard.writeText(text);
        } else {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            document.execCommand('copy');
            textArea.remove();
        }
        copiedField.value = fieldName;
        setTimeout(() => {
            if (copiedField.value === fieldName) {
                copiedField.value = null;
            }
        }, 2500);
    } catch (e) {
        console.error('Copy failed', e);
    }
};
</script>

<style scoped>
.payment-option-card {
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
