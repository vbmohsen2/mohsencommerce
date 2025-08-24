<template>
    <div class="flex flex-col h-full border-2 hover:border-blue-500 border-white rounded-md overflow-hidden">
        <Link :href="`/product/${product.slug}`">
            <div class="w-full aspect-[3/4] overflow-hidden">
                <img
                    :src="`/storage/images/products/${mainImage}`"
                    :alt="product.name"
                    loading="lazy"
                    class="w-full h-full object-cover rounded object-center"
                />
            </div>
        </Link>

        <div class="flex flex-col justify-between flex-1 p-2 space-y-2">
            <div class="text-center text-xs font-semibold leading-tight line-clamp-2">
                {{ product.name }}
            </div>

            <div v-if="product.discount_price != 0">
                <div class="text-center text-green-600 text-sm font-bold">
                    {{ formatPrice(product.discount_price) }} تومان
                    <span class="text-xs text-red-500">
            ({{ discountPercent }}٪ تخفیف)
          </span>
                </div>
                <div class="text-center line-through text-sm text-gray-500">
                    {{ formatPrice(product.price) }} تومان
                </div>
            </div>

            <div v-else class="text-center text-base text-gray-800">
                {{ formatPrice(product.price) }} تومان
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    product: {
        type: Object,
        required: true
    }
})

let mainImage = ''

try {
    const images = JSON.parse(props.product.images || '{}')
    mainImage = images.main || ''
} catch (e) {
    console.warn('Invalid images JSON', e)
}

const discountPercent = computed(() => {
    const { price, discount_price } = props.product
    if (discount_price && price) {
        return Math.round(((price - discount_price) / price) * 100)
    }
    return 0
})

const formatPrice = (val) => {
    return new Intl.NumberFormat('fa-IR').format(val)
}
</script>
