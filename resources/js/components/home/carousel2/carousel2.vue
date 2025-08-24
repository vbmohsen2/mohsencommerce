<template>
    <div class="swiper Itemcarousel">
        <div class="swiper-wrapper">
            <div v-for="product in products" :key="product.id" class="swiper-slide">
                <ItemCarousel :product="product" />
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</template>

<script setup>
import { onMounted } from 'vue'
import Swiper from 'swiper'
import 'swiper/swiper-bundle.css'

import ItemCarousel from './ItemCarousel.vue' // ← اطمینان حاصل کن مسیر درست باشه

const props = defineProps({
    products: {
        type: Array,
        required: true
    }
})

onMounted(() => {
    new Swiper(".Itemcarousel", {

        slidesPerView: 3,
        spaceBetween: 6,

        pagination: {
            el: ".swiper-pagination",
            clickable: true},
        breakpoints: {
            300:{slidesPerView: 2},
            640: { slidesPerView: 2.5 },
            768: { slidesPerView: 3 },
            1024: { slidesPerView: 4 }
        }
    })
})
</script>

<style scoped>
.swiper-slide {
    height: auto !important;
    display: flex;
}
.swiper-pagination {
    margin-top: 10px;
}
</style>
