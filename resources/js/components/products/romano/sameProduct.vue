<template>
    <div v-if="products.length" class="my-8">
        <h2 class="text-xl font-bold text-center mb-4">محصولات مشابه</h2>
        <Swiper
            :slides-per-view="2"
            :space-between="10"
            :pagination="{ clickable: true }"
            :breakpoints="{
        640: { slidesPerView: 2.5 },
        768: { slidesPerView: 3.5 },
        1024: { slidesPerView: 4.5 }
      }"
        >
            <SwiperSlide v-for="product in products" :key="product.id">
                <ItemCard :product="product" />
            </SwiperSlide>

            <template #pagination></template>
        </Swiper>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'
import { Swiper, SwiperSlide } from 'swiper/vue'
import 'swiper/css'
import 'swiper/css/pagination'
import 'swiper/css/navigation'

import ItemCard from './ItemCard.vue'
import {usePage} from "@inertiajs/vue3"; // همون چیزی که توی x-item-carousel نشون می‌دادی

// const props = defineProps({
//     product: {
//         type: Object,
//         required: true,
//     },
// })

const products = ref([])
products.value = usePage().props.related
// console.log(usePage().props.related)
const fetchRelated = async () => {
    // if (!props.product?.id) return
    // try {
    //     const res = await axios.get(`/api/products/${props.product.id}/related`)
    //     products.value = res.data
    // } catch (err) {
    //     console.error('خطا در گرفتن محصولات مرتبط:', err)
    // }
}

// onMounted(fetchRelated)
// watch(() => props.product.id, fetchRelated)
</script>

<style scoped>
.swiper-slide {
    height: auto !important;
    display: flex;
}
</style>
