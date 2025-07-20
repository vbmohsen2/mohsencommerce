<template>
    <div class="flex flex-col lg:flex-row w-full md:w-2/4  pb-6">
        <!-- آیکون‌ها -->
       <like-share-compare :product="product"></like-share-compare>

        <!-- تصاویر -->
        <div class="flex flex-col w-full justify-center">
            <!-- تصویر اصلی (دسکتاپ) -->
            <div class="mx-4 rounded-md hidden md:block relative overflow-hidden" ref="mainImageContainer">
                <img
                    :src="mainImageUrl"
                    loading="lazy"
                    alt="'Main Image ' + product.name"
                    decoding="async"
                    width="350"
                    height="350"
                    class="w-full   transition-transform duration-300 ease-in-out object-scale-down rounded-2xl"
                    ref="mainImageEl"
                />
            </div>

            <!-- گالری کوچک (دسکتاپ) -->
            <div class="md:flex hidden w-full justify-start md:h-1/6 my-4 gap-2">
                <div
                    class="cursor-pointer border border-gray-50 hover:border-green-300"
                    @click="setMainImage(images.main)"
                >
                    <img
                        :src="getImageUrl(images.main)"
                        class="w-full md:h-20 lg:h-20 "
                        :alt="'Thumbnail ' + images.main"
                    />
                </div>
                <div
                    v-for="(img, i) in images.gallery.slice(0, 5)"
                    :key="i"
                    class="cursor-pointer border border-gray-50 aspect-[3/4] hover:border-green-300"
                    @click="setMainImage(img, true)"
                >
                    <img
                        :src="getGalleryUrl(img)"
                        class="w-full md:h-20 lg:h-20"
                        :alt="'Thumbnail ' + img"
                    />
                </div>
                <div class="flex justify-center items-center px-2 cursor-pointer" @click="modalVisible = true">
                    <span class="text-4xl text-gray-500">...</span>
                </div>
            </div>

            <!-- مودال -->
            <div
                v-if="modalVisible"
                class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50"
            >
                <div class="bg-white p-6 rounded-md max-w-4xl w-full relative">
                    <button @click="modalVisible = false" class="absolute top-2 right-2 text-2xl text-gray-700">&times;</button>
                    <div class="grid grid-cols-3 gap-4">
                        <div
                            class="cursor-pointer border border-gray-50 hover:border-green-300"
                            @click="setMainImage(images.main); modalVisible = false"
                        >
                            <img :src="getImageUrl(images.main)" class="w-full" />
                        </div>
                        <div
                            v-for="(img, i) in images.gallery"
                            :key="'modal-' + i"
                            class="cursor-pointer hover:scale-105 transition-transform duration-200"
                            @click="setMainImage(img, true); modalVisible = false"
                        >
                            <img :src="getGalleryUrl(img)" class="w-full" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- اسلایدر موبایل -->
            <div class="md:hidden w-full">
                <div class="swiper mobilepimage w-full">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img :src="getImageUrl(images.main)" class="w-full max-h-96 object-contain" />
                        </div>
                        <div
                            class="swiper-slide"
                            v-for="(img, i) in images.gallery"
                            :key="'mobile-' + i"
                        >
                            <img :src="getGalleryUrl(img)" class="w-full max-h-96 object-contain" />
                        </div>
                    </div>
                    <!-- دایره پیشرفت روی تصویر، پایین وسط -->
                    <div
                        class="absolute bottom-2 left-25 transform z-10 -translate-x-1/2"
                        style="pointer-events: none;"
                    >
                        <svg
                            class="w-6 h-6"
                        viewBox="0 0 36 36"
                        >
                        <path
                            class="text-gray-300"
                            stroke-width="3"
                            stroke="currentColor"
                            fill="none"
                            d="M18 2.0845
           a 15.9155 15.9155 0 0 1 0 31.831
           a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <path
                            id="progress-circle"
                            class="text-blue-500 transition-all duration-100 ease-linear"
                            stroke-width="3"
                            stroke-linecap="round"
                            stroke="currentColor"
                            fill="none"
                            stroke-dasharray="100"
                            stroke-dashoffset="100"
                            d="M18 2.0845
           a 15.9155 15.9155 0 0 1 0 31.831
           a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        </svg>
                    </div>

                    <div class="swiper-pagination"></div>

                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import Swiper from 'swiper'
import 'swiper/swiper-bundle.css'
import axios from "axios";
import LikeShareCompare from "@/components/products/romano/like-share-compare.vue";



// props
const props = defineProps({
    product: Object
})

// Parse images با واکنش‌پذیری
const images = computed(() => {
    try {
        return JSON.parse(props.product.images)
    } catch (e) {
        console.error('مشکل در parse تصاویر محصول:', e)
        return { main: '', gallery: [] }
    }
})

// تصویر اصلی انتخاب‌شده
const selectedImage = ref({
    name: images.value.main,
    fromGallery: false
})


// computed: مسیر کامل تصویر اصلی
const mainImageUrl = computed(() => {
    if (!selectedImage.value.name) return ''
    const base = selectedImage.value.fromGallery ? '/storage/images/products/gallery/' : '/storage/images/products/'
    return base + selectedImage.value.name
})

// تغییر تصویر اصلی

const setMainImage = (imageName, isGallery = false) => {
    selectedImage.value = {
        name: imageName,
        fromGallery: isGallery
    }
}

// Modal
const modalVisible = ref(false)

// helpers برای ساخت مسیر
const getImageUrl = (img) => `/storage/images/products/${img}`
const getGalleryUrl = (img) => `/storage/images/products/gallery/${img}`

// Hover Zoom
const mainImageContainer = ref()
const mainImageEl = ref()

onMounted(() => {
    if (mainImageContainer.value && mainImageEl.value) {
        mainImageContainer.value.addEventListener('mousemove', (e) => {
            const rect = mainImageEl.value.getBoundingClientRect()
            const x = ((e.clientX - rect.left) / rect.width) * 100
            const y = ((e.clientY - rect.top) / rect.height) * 100
            mainImageEl.value.style.transformOrigin = `${x}% ${y}%`
            mainImageEl.value.style.transform = 'scale(2)'
        })

        mainImageContainer.value.addEventListener('mouseleave', () => {
            mainImageEl.value.style.transform = 'scale(1)'
        })
    }

    // Swiper init
    new Swiper('.swiper', {
        pagination: {
            el: '.swiper-pagination',
        },
    })
})


</script>
