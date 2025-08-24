<template>
    <header  class=" w-full bg-white fixed top-0 left-0 z-50 box-border mx-auto  px-4 items-center  pt-1 pb-1 h-fit   shadow-xl  ">
        <div class="flex flex-col">
            <div class="flex justify-between flex-wrap  items-center  ">
                <!-- Logo -->
                <div  class="flex-grow-1  sm:order-1 order-2 w-20 md:justify-self-center">
                    <Link href="/">
                        <img src="/public/images/romanologo.jpg" alt="romano logo" class="h-16" />
                    </Link>
                </div>

                <!-- Search -->
                <div class="flex grow sm:order-2 order-4 max-sm:w-full justify-center  ">
                    <div class="w-3/4 max-sm:w-full ml-5 mb-2 m-2  flex rounded-lg bg-gray-300">
                        <img src="/public/images/search icon.svg" class="w-6 h-6 m-2" alt="" />
                        <ProductSearch />
                    </div>
                </div>

                <!-- User and Cart -->
                <div  class="flex  w-1/5  pb-2 sm-order-3 order-3  pt-2  px-4 space-x-2 justify-end   ">
                    <UserMenu :user="page.props.auth.user" />

                    <!-- User Dropdown (if logged in) -->
<!--                    <div v-if="showUserInfo" class="absolute left-20 mt-2 w-48 bg-white border rounded shadow-2xl z-50 p-4">-->
<!--                        <ul class="space-y-2">-->
<!--                            <li><link to="/user/dashboard">حساب کاربری</link></li>-->
<!--                            <li><link to="/user/orders">سفارشات</link></li>-->
<!--                            <li><link to="/user/addresses">آدرس‌ها</link></li>-->
<!--                            <li @click="logout">خروج</li>-->
<!--                        </ul>-->
<!--                    </div>-->

                    <!-- Cart -->
                    <div class="relative" id="cart-wrapper">
                        <button @click="toggleCart" class="flex items-center">
                            <div class="relative py-2">
                                <!-- فقط نمایش badge اگر cartCount > 0 -->
                                <div class=" absolute left-5 top-0 md:left-6" v-if="cartCount">
                                    <p class="flex h-2 w-1 sm:h-2 items-center justify-center rounded-full p-3  bg-red-300 text-white">
                                        {{ cartCount }}
                                    </p>
                                </div>
                                <svg
                                    class="w-8 h-8 sm:w-10 sm:h-10 min-w-[2rem] min-h-[1rem] text-gray-400"
                                    viewBox="0 0 64 64"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M10 10h6l8 30h28l6-16H18"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                    <circle cx="22" cy="52" r="3" fill="currentColor" />
                                    <circle cx="46" cy="52" r="3" fill="currentColor" />
                                </svg>

                            </div>
                        </button>

                        <!-- Desktop Cart Dropdown -->
                        <transition name="fade-slide">
                        <div v-if="showCartDropdown" class="absolute -left-2 mt-2 w-96 bg-white border rounded shadow-2xl z-50 p-4 hidden sm:block">
                            <CartContent />
                        </div>
                        </transition>
                        <!-- Mobile Cart Offcanvas -->
                        <transition name="slide-right">
                            <div v-if="showCartOffcanvas" class="fixed top-0 left-0 w-80 h-full bg-white z-50 shadow-lg overflow-y-auto p-2 block sm:hidden">
                            <div class="p-4 flex justify-between items-center border-b">
                                <h2 class="text-xl font-bold">سبد خرید</h2>
                                <button @click="closeCart">✖️</button>
                            </div>
                            <CartContent />
                        </div>
                            </transition>
                    </div>
                </div>

                <!-- Navbar -->
                <div class="order-1 sm:order-4 w-1/5 sm:w-full">
                    <Navbar />
                </div>
            </div>
        </div>

        <!-- Login Modal -->
<!--        <LoginModal :visible="showLoginModal" @close="showLoginModal = false" />-->
    </header>
</template>

<script setup>
import {ref, computed, onMounted, watch} from 'vue'
import ProductSearch from '../products/search.vue'
import CartContent from '../header/Cart.vue'
import Navbar from '../header/Navbar.vue'
import UserMenu from '../header/User.vue'
import { usePage, Link } from '@inertiajs/vue3'

const showLoginModal = ref(false)
const showUserInfo = ref(false)
const showCartDropdown = ref(false)
const showCartOffcanvas = ref(false)

const page = usePage()

// ✅ مقدار reactive برای cart count
const cartCount = ref(page.props.cart?.count)
watch(() => page.props.cart?.count, newVal => {
    cartCount.value = newVal
    // واکنش خاص اینجا
})
// 🔁 نمایش یا پنهان‌سازی منوی کاربر
const toggleLogin = () => {
    showUserInfo.value = !showUserInfo.value
}

// 🚪 خروج از حساب کاربری
const logout = () => {
    location.href = '/logout'
}

// 🛒 نمایش سبد خرید (dropdown یا offcanvas)
const toggleCart = () => {
    if (window.innerWidth >= 640) {
        showCartDropdown.value = !showCartDropdown.value
    } else {
        showCartOffcanvas.value = true
    }
}

const closeCart = () => {
    showCartOffcanvas.value = false

}

// ⛔️ بستن dropdown ها وقتی بیرون کلیک میشه
onMounted(() => {
    document.addEventListener('click', (e) => {
        if (!e.target.closest('#cart-wrapper')) {
            showCartDropdown.value = false
            showCartOffcanvas.value = false
        }
        if (!e.target.closest('#loginbtn')) {
            showUserInfo.value = false
        }
    })
})
</script>


<style scoped>
.fade-slide-enter-active, .fade-slide-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}
.fade-slide-enter-from, .fade-slide-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
.fade-slide-enter-to, .fade-slide-leave-from {
    opacity: 1;
    transform: translateY(0);
}

.slide-right-enter-active, .slide-right-leave-active {
    transition: transform 0.3s ease, opacity 0.3s ease;
}
.slide-right-enter-from, .slide-right-leave-to {
    transform: translateX(-100%);
    opacity: 0;
}
.slide-right-enter-to, .slide-right-leave-from {
    transform: translateX(0);
    opacity: 1;
}
</style>
