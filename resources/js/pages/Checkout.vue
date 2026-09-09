<template>
    <div class="main-container">

        <!-- Breadcrumbs -->
        <div class="flex items-center gap-2 overflow-hidden pt-4">
            <router-link to="/" class="w-6 h-6">
                <HomeIcon class="w-5 h-5 text-slate-600" />
            </router-link>

            <div class="grow w-full overflow-hidden">
                <div class="space-x-1 text-slate-600 text-sm font-normal truncate">
                    <span>{{ $t('Home') }} </span>
                    <span>/</span>
                    <span>{{ $t('Cart') }}</span>
                    <span>/</span>
                    <span>{{ $t('Checkout') }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 my-3 gap-8">

            <div class="col-span-1 xl:col-span-2">

                <div class="py-4 border-b tran" :class="showProductItems ? 'border-primary' : 'border-slate-200'">
                    <!-- checkout -->
                    <div class="flex gap-2 justify-between items-center">
                        <div class="text-slate-950 text-lg sm:text-3xl font-medium leading-10">{{ $t('Checkout') }}
                        </div>
                        <div class="flex items-center gap-2 cursor-pointer"
                            @click="showProductItems = !showProductItems">
                            <div class="text-primary-600 text-lg font-medium leading-normal tracking-tight">
                                ({{ basketStore.checkoutTotalItems }} {{ $t('items') }})
                            </div>
                            <ChevronDownIcon class="w-5 h-5 text-primary-600 transition duration-300"
                                :class="showProductItems ? 'rotate-180' : ''" />
                        </div>
                    </div>

                    <!-- Product items -->
                    <div v-if="showProductItems">
                        <checkoutProducts />
                    </div>
                </div>

                <!-- Shipping Address -->
                <ShippingAddress />

                <div class="mt-6">
                    <div class="mb-1">
                        <span class="text-slate-950 text-xl font-medium leading-7">{{ $t('Note') }}</span>
                        <span class="text-slate-500 text-lg font-normal leading-7 tracking-tight">
                            ({{ $t('Optional') }})
                        </span>
                    </div>
                    <textarea v-model="note" rows="3" class="form-input"
                        :placeholder="$t('Write your note') + '...'"></textarea>
                </div>

                <!-- Payment Method Selector -->
                <PaymentMethodSelector v-model="paymentMethod" class="mt-4" />

            </div>

            <!-- Order Summary -->
            <CheckoutOrderSummary :note="note" :paymentMethod="paymentMethod" />

        </div>

    </div>
</template>

<script setup>
import { ChevronDownIcon, HomeIcon } from '@heroicons/vue/24/outline';
import { onMounted, ref } from 'vue';

import CheckoutOrderSummary from '../components/CheckoutOrderSummary.vue';
import checkoutProducts from '../components/checkoutProducts.vue';
import ShippingAddress from '../components/CheckoutShippingAddress.vue';
import PaymentMethodSelector from '../components/PaymentMethodSelector.vue';

import { useAuth } from '../stores/AuthStore';
const AuthStore = useAuth();

import { useBasketStore } from '../stores/BasketStore';
import { useMaster } from '../stores/MasterStore';

import { useRouter } from 'vue-router';
const router = new useRouter();

const master = useMaster();
const basketStore = useBasketStore();

const showProductItems = ref(false);

const note = ref("");

const paymentMethod = ref(master.cashOnDelivery ? 'cash' : 'instapay');

onMounted(() => {
    window.scrollTo(0, 0);
    basketStore.coupon_code = "";
    if (!AuthStore.user && !AuthStore.access_token) {
        router.push({ name: 'home' });
    }
    AuthStore.showAddressModal = false;
    AuthStore.showChangeAddressModal = false;
});
</script>
<style scoped>
.form-label {
    @apply text-slate-700 text-base font-normal leading-normal;
}

.form-input {
    @apply p-3 rounded-lg border border-slate-200 focus:border-primary w-full outline-none text-base font-normal leading-normal placeholder:text-slate-400;
}

.formInputCoupon {
    @apply rounded-lg border border-slate-200 focus:border-primary w-full outline-none text-base font-normal leading-normal placeholder:text-slate-400;
}

.radio-btn {
    @apply w-5 h-5 border appearance-none border-slate-300 rounded-full checked:bg-primary ring-primary checked:outline-1 outline-offset-1 checked:outline-primary checked:outline transition duration-100 ease-in-out m-0;
}

.radioBtn2 {
    @apply w-4 h-4 border appearance-none border-slate-300 rounded-full checked:bg-primary ring-primary checked:outline-1 outline-offset-1 checked:outline-primary checked:outline transition duration-100 ease-in-out m-0;
}
</style>
