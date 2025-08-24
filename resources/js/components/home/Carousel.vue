<template>
    <div class="relative w-full lg:w-1/2 sm:h-60 md:h-full  overflow-hidden rounded-xl">
        <swiper
            :modules="[Autoplay, Pagination]"
            :slides-per-view="1"
            :loop="true"
            :autoplay="{ delay: 5000 }"
            :pagination="{ el: '.custom-pagination', clickable: true, renderBullet }"
            class="h-full"
        >
            <swiper-slide v-for="(image, index) in images" :key="index">
                <div class="slide w-full flex-shrink-0 flex items-center justify-center h-full">
                    <a :href="image.link || '#'">
                        <img
                            :src="image.src"
                            loading="lazy"
                            class="w-full h-full object-fill object-center"
                            :alt="`Slide ${index}`"
                        />
                    </a>
                </div>
            </swiper-slide>
        </swiper>

        <!-- Indicators -->
        <div class="custom-pagination absolute bottom-2 left-1/2 transform -translate-x-1/2 flex space-x-2 z-10"></div>
    </div>
</template>

<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/autoplay';
import { Autoplay, Pagination } from 'swiper/modules';

const props = defineProps({
    images: {
        type: Array,
        required: true,
    },
});

// Custom dot rendering function to match your HTML style
const renderBullet = (index, className) => {
    return `<button class="${className} w-3 h-2 px-3 mx-2 rounded-full transition-all"></button>`;
};
</script>

<style scoped>
.swiper-pagination-bullet {
    @apply bg-gray-400;
}
.swiper-pagination-bullet-active {
    @apply bg-gray-800;
}
</style>
