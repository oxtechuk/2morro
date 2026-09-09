import { ref, computed } from "vue";
import { useMaster } from "../stores/MasterStore";
import { useAuth } from "../stores/AuthStore";

/**
 * Shared pre-order state for every ProductDetails theme.
 *
 * Pass the theme's `product` ref; get back the modal toggle, the
 * `isPreOrder` gate (module on + setting on + product flagged) and the
 * resolved pre-order details, plus the open/close handlers.
 *
 * @param {import("vue").Ref<object>} product
 */
export function usePreOrder(product) {
    const masterStore = useMaster();
    const authStore = useAuth();

    const showPreOrderModal = ref(false);
    const isPreOrder = computed(
        () => masterStore.preOrder && product.value?.is_preorder
    );
    const preOrderDetails = computed(() => product.value?.pre_order_details ?? {});

    const openPreOrder = () => {
        if (!authStore.token) {
            authStore.loginModal = true;
            return;
        }
        showPreOrderModal.value = true;
    };

    const closePreOrder = () => {
        showPreOrderModal.value = false;
    };

    return {
        showPreOrderModal,
        isPreOrder,
        preOrderDetails,
        openPreOrder,
        closePreOrder,
    };
}
