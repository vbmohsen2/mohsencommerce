<template>
    <li class="inline-block mx-1 relative">
        <button @click="toggleMenu" class="text-gray-500 hover:text-blue-600">
            <i class="fa fa-link text-xl"></i>
        </button>

        <!-- بک‌دراپ برای موبایل -->
        <div
            v-if="showMenu && isMobile"
            class="fixed inset-0 bg-black bg-opacity-40 z-40"
            @click="closeMenu"
        ></div>

        <!-- منوی اشتراک‌گذاری -->
        <transition name="fade">
            <div
                v-if="showMenu"
                class="z-50"
                :class="isMobile ?
          'fixed bottom-4 left-1/2 -translate-x-1/2 w-11/12 max-w-sm p-4 bg-white rounded-xl shadow-xl'
          :
          'absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl p-4'"
            >
                <p class="text-gray-700 mb-3 text-sm font-semibold text-center">ارسال از طریق:</p>
                <div class="flex justify-between items-center text-xl">
                    <a :href="`https://t.me/share/url?url=${url}`" target="_blank" title="تلگرام" class="text-blue-400 hover:text-blue-500">
                        <i class="fab fa-telegram"></i>
                    </a>
                    <a :href="`https://wa.me/?text=${url}`" target="_blank" title="واتساپ" class="text-green-500 hover:text-green-600">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a :href="`sms:?body=${url}`" title="پیامک" class="text-gray-700 hover:text-gray-800">
                        <i class="fa fa-sms"></i>
                    </a>
                    <a :href="`https://www.instagram.com/?url=${url}`" target="_blank" title="اینستاگرام" class="text-pink-500 hover:text-pink-600">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <button @click="copyToClipboard" title="کپی لینک" class="text-gray-500 hover:text-blue-600">
                        <i class="fas fa-clipboard"></i>
                    </button>
                </div>
            </div>
        </transition>
    </li>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import {useToast} from "vue-toast-notification";

// تعریف prop برای URL محصول

const url=window.location.href

const showMenu = ref(false)
const isMobile = ref(false)

const toggleMenu = () => {
    showMenu.value = !showMenu.value
}
const closeMenu = () => {
    showMenu.value = false
}

onMounted(() => {
    isMobile.value = window.innerWidth < 768
    window.addEventListener('resize', () => {
        isMobile.value = window.innerWidth < 768
    })
})




const copyToClipboard = async () => {


    try {
        await navigator.clipboard.writeText(url)
        const $toast = useToast();
        closeMenu()
        let instance = $toast.info('در کلیپ برد کپی شد  ',{duration:3000,position:'top-right'});

    } catch (err) {
        alert('خطا در کپی لینک')
        console.error(err)
    }
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
