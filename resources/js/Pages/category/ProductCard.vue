<template>
    <a
        :href="`/product/${product.slug}`"
        class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 border border-transparent hover:border-gray-300 p-2 flex flex-col group"
    >
        <!-- تصویر محصول -->
        <div class="relative w-full h-60 overflow-hidden rounded-2xl">
            <img
                :src="getMainImage(product.images)"
                :alt="product.name"
                class="w-full h-full md:object-cover object-scale-down transition-transform duration-300 group-hover:scale-105"
            />
        </div>

        <!-- عنوان -->
        <h3 class="text-sm font-medium mt-3 mb-1 text-gray-800 line-clamp-2 leading-snug">
            {{ product.name }}
        </h3>


        <!-- قیمت -->
        <div class="mt-auto flex items-center justify-between">
            <!-- قیمت نهایی (با تخفیف یا بدون) -->
            <div class="flex items-center gap-2">
                <div class="text-gray-800 font-bold text-lg">
                    {{ formatPrice(Number(product.discount_price) > 0 ? product.discount_price : product.price) }}
                </div>

                <!-- درصد تخفیف -->
                <span
                    v-if="Number(product.discount_price) > 0"
                    class="text-xs text-white bg-red-500 rounded-full px-2 py-0.5"
                >
      ٪{{ Math.round((1 - product.discount_price / product.price) * 100) }}
    </span>
            </div>

            <!-- قیمت اصلی (خط‌خورده) -->
            <div
                v-if="Number(product.discount_price) > 0"
                class="text-xs text-red-500 line-through"
            >
                {{ formatPrice(product.price) }}
            </div>
        </div>


        <!-- دکمه افزودن به سبد -->
        <!-- می‌تونی دوباره فعالش کنی اگه خواستی -->
        <!--
        <button
          @click.prevent="$emit('add-to-cart', product)"
          class="w-full mt-4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2 rounded-xl transition"
        >
          افزودن به سبد
        </button>
        -->
    </a>
</template>


<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
})

const formatPrice = (price) => {
    // const tomanPrice = price / 10; // چون قیمت‌ها به ریاله
    return new Intl.NumberFormat('fa-IR', {
        maximumFractionDigits: 0,
    }).format(price) + ' تومان';
}

function getMainImage(imageJson) {
    try {

        const images = JSON.parse(imageJson)
        return '/storage/images/products/' + images.main
    } catch {
        return '/placeholder.png'
    }
}

function redirecttoproductpage(){
    router.visit(`/product/${props.product.slug}`)}
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
