<template>
    <div class="flex flex-col h-full border-2 hover:border-blue-500 border-white rounded-md overflow-hidden">
        <a :href="`/product/${product.slug}`">
            <div class="w-full aspect-[3/4] overflow-hidden">
                <img
                    :src="`/storage/images/products/${mainImage}`"
                    :alt="product.name"
                    loading="lazy"
                    class="w-full h-full object-cover rounded object-center"
                />
            </div>
        </a>

        <div class="flex flex-col justify-between flex-1 p-2 space-y-2">
            <div class="text-center text-xs font-semibold leading-tight line-clamp-2">
                {{ product.name }}
            </div>

            <template v-if="product.discount_price && product.discount_price != 0.0">
                <div class="text-center text-green-600 text-sm font-bold">
                    {{ numberFormat(product.discount_price) }} تومان
                    <span class="text-xs text-red-500">
            ({{ discountPercent }}٪ تخفیف)
          </span>
                </div>
                <div class="text-center line-through text-sm text-gray-500">
                    {{ numberFormat(product.price) }} تومان
                </div>
            </template>

            <template v-else>
                <div class="text-center text-base text-gray-800">
                    {{ numberFormat(product.price) }} تومان
                </div>
            </template>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    product: Object,
})

const mainImage = computed(() => {
    try {
        const images = JSON.parse(props.product.images || '{}')
        return images.main || ''
    } catch {
        return ''
    }
})

const discountPercent = computed(() => {
    const { price, discount_price } = props.product
    return Math.round(((price - discount_price) / price) * 100)
})

function numberFormat(num) {
    return new Intl.NumberFormat('fa-IR').format(num)
}
</script>
