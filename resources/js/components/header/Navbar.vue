<script setup>
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'

// گرفتن دسته‌بندی‌ها از props
const { parents = [], children = [] } = usePage().props.navbarcategories ?? {}

// وضعیت منوها
const showMobileMenu = ref(false)
const showMegaMenu = ref(false)
const activeSubmenuId = ref(null)
const megaMenuHovering = ref(false)
const showChildrenMobile = ref({}) // کنترل باز شدن زیرمنوها در موبایل

// توگل منوی موبایل
function toggleMobileMenu() {
    showMobileMenu.value = !showMobileMenu.value
}

// کنترل مگامنو
function handleMouseEnter() {
    showMegaMenu.value = true
}
function handleMouseLeave() {
    setTimeout(() => {
        if (!megaMenuHovering.value) {
            showMegaMenu.value = false
            activeSubmenuId.value = null
        }
    }, 200)
}

// ورود و خروج موس از مگامنو
function onMegaMenuEnter() {
    megaMenuHovering.value = true
}
function onMegaMenuLeave() {
    megaMenuHovering.value = false
    showMegaMenu.value = false
    activeSubmenuId.value = null
}

// توگل زیرمنو موبایل
function toggleMobileSubmenu(id) {
    showChildrenMobile.value[id] = !showChildrenMobile.value[id]
}
function childrenOf(parentId) {
    return children.filter(c => c.parent_id === parentId)
}
</script>

<template>
    <nav class="px-4 relative">
        <div class=" mx-auto  flex items-center justify-between">

            <!-- دکمه موبایل -->
            <button @click="toggleMobileMenu" class="sm:hidden text-xl">
                <i class="fa fa-bars"></i>
            </button>

            <!-- ناوبار دسکتاپ -->
            <div class="hidden sm:flex gap-6 items-center">
                <!-- فقط یک دکمه دسته‌بندی -->
                <div class="relative"

                >
<!--                    <button-->
<!--                        @mouseenter="handleMouseEnter"-->
<!--                        @mouseleave="handleMouseLeave"-->
<!--                        class="px-4 py-2 hover:text-green-600 text-lg font-semibold">-->
<!--                        دسته‌بندی‌ها-->
<!--                    </button>-->

                    <!-- مگامنو -->
                    <div
                        v-show="showMegaMenu"
                        @mouseenter="onMegaMenuEnter"
                        @mouseleave="onMegaMenuLeave"
                        class="absolute right-0 top-10 z-50 bg-gray-100 shadow-lg w-[600px] p-6 rounded-md flex gap-8"
                    >
                        <!-- والد -->
                        <div class="w-1/3">
                            <ul>
                                <li
                                    v-for="parent in parents"
                                    :key="parent.id"
                                    class="py-2 hover:text-green-700 cursor-pointer"
                                    @mouseenter="activeSubmenuId = parent.id"
                                >
                                    {{ parent.name }}
                                </li>
                            </ul>
                        </div>

                        <!-- زیرمنوها -->
                        <div class="w-2/3">
                            <div
                                v-for="parent in parents"
                                :key="'submenu-' + parent.id"
                                v-show="activeSubmenuId === parent.id"
                            >
                                <ul>
                                    <li
                                        v-for="child in children.filter(c => c.parent_id === parent.id)"
                                        :key="child.id"
                                        class="py-2 hover:text-green-700"
                                    >
                                        <a :href="`/category/${child.slug}`">{{ child.name }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    v-for="parent in parents"
                    :key="'submenu-' + parent.id"
                >
                    <a :href="`/category/${parent.slug}`" class="hover:text-green-600">{{ parent.name }}</a>
                </div>
                <!-- سایر آیتم‌ها -->
                <button class="max-sm:hidden mx-2 py-2 hover:text-green-600" >
                    <i class="fa-solid  fa-file-lines pl-4"><span class="px-2 font-thin"><a href="/blog">بلاگ</a></span></i>
                </button>                <a href="/about" class="hover:text-green-600">درباره ما</a>
                <a href="/contact" class="hover:text-green-600">تماس با ما</a>
            </div>
        </div>

        <!-- منوی موبایل -->
        <transition name="slide">
            <div
                v-if="showMobileMenu"
                class="fixed top-0 right-0 z-50 h-full w-2/3 md:w-2/3 bg-white shadow-lg p-4"
            >
                <div class="flex justify-between items-center border-b pb-2 mb-4">
                    <span class="text-lg font-bold">منو</span>
                    <button @click="toggleMobileMenu" class="text-xl">&times;</button>
                </div>
                <ul>
                    <li class="mb-2">
                        <a href="/" class="block p-2 hover:bg-gray-100">خانه</a>
                    </li>

                    <li
                        v-for="parent in parents"
                        :key="'mobile-parent-' + parent.id"
                        class="mb-2 border-b pb-2"
                    >
                        <div
                            class="flex justify-between items-center p-2 hover:bg-gray-100 cursor-pointer"
                            @click="childrenOf(parent.id).length && toggleMobileSubmenu(parent.id)"
                        >
                            <a :href="`/category/${parent.slug}`">{{ parent.name }}</a>

                            <!-- فقط اگه زیرمنو داشته باشه -->
                            <template v-if="childrenOf(parent.id).length">
                                <i
                                    :class="[
                  'transition-transform duration-300',
                  showChildrenMobile[parent.id] ? 'fa fa-chevron-up' : 'fa fa-chevron-down'
                ]"
                                ></i>
                            </template>
                        </div>

                        <!-- زیرمنو با انیمیشن -->
                        <transition name="submenu">
                            <ul
                                v-show="showChildrenMobile[parent.id]"
                                class="pl-4"
                            >
                                <li
                                    v-for="child in childrenOf(parent.id)"
                                    :key="'mobile-child-' + child.id"
                                    class="p-2 hover:bg-gray-50"
                                >
                                    <a :href="`/category/${child.slug}`">{{ child.name }}</a>
                                </li>
                            </ul>
                        </transition>
                    </li>

                    <li class="mb-2">
                        <a href="/blog" class="block p-2 hover:bg-gray-100">بلاگ</a>
                    </li>
                    <li class="mb-2">
                        <a href="/about" class="block p-2 hover:bg-gray-100">درباره ما</a>
                    </li>
                    <li class="mb-2">
                        <a href="/contact" class="block p-2 hover:bg-gray-100">تماس با ما</a>
                    </li>
                </ul>
            </div>
        </transition>

        <!-- پس زمینه -->
        <transition name="fade">
            <div
                v-if="showMobileMenu"
                class="fixed inset-0 bg-black bg-opacity-40 z-40"
                @click="toggleMobileMenu"
            ></div>
        </transition>
    </nav>
</template>
<style scoped>
/* انیمیشن باز شدن منوی موبایل */
.slide-enter-active, .slide-leave-active {
    transition: transform 0.3s ease;
}
.slide-enter-from {
    transform: translateX(100%);
}
.slide-leave-to {
    transform: translateX(100%);
}

/* انیمیشن fade بک‌دراپ */
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}

/* انیمیشن زیرمنو */
.submenu-enter-active, .submenu-leave-active {
    transition: all 0.3s ease;
    overflow: hidden;
}
.submenu-enter-from, .submenu-leave-to {
    max-height: 0;
    opacity: 0;
}
.submenu-enter-to, .submenu-leave-from {
    max-height: 500px;
    opacity: 1;
}

</style>
