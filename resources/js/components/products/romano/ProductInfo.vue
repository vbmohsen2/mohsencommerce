<template>
    <div class="flex pr-8 pt-4 flex-col md:w-2/4 w-full">

        <!-- عنوان -->
        <div class="pt-4 pb-2">
            <h1 class="text-gray-600 text-3xl md:xl font-bold">{{ product.name }}</h1>
        </div>

        <!-- مشخصات -->
        <ul class="space-y-1 text-sm mb-4">
            <li v-for="(attr, index) in attributes" :key="index">
                <span class="text-gray-500">{{ attr.name }}:</span>
                {{ attr.value }}
            </li>
        </ul>

        <!-- خط جداکننده-->
        <div class="w-full border-t border-dashed border-gray-300 my-4"></div>

        <!-- انتخاب طرح -->
        <div class="w-full py-2" id="codeMessage">
            <h3 class="text-gray-700 mb-2 text-sm font-semibold">انتخاب طرح:</h3>
            <div class="flex flex-wrap gap-2">
                <button
                    v-for="(item, index) in codes"
                    :key="index"
                    @click="selectedCode = item.label"
                    class="flex items-center justify-center px-4 py-2 rounded-md text-sm font-semibold transition-all border"
                    :style="{
            backgroundColor: item.color,
            color: '#fff',
            borderColor: selectedCode === item.label ? '#10b981' : 'transparent',
            boxShadow: selectedCode === item.label ? '0 0 0 2px #10b981' : 'none',
          }"
                >
                    {{ item.label || 'بدون نام' }}
                </button>
            </div>

            <!-- نمایش طرح انتخاب‌شده -->
            <div v-if="selectedCode"  class="mt-3 text-green-600 text-sm font-medium">
                طرح انتخاب‌شده: {{ selectedCode }}
            </div>
        </div>

        <!-- قیمت و افزودن به سبد خرید -->
        <div class="w-full px-2 mt-6">
            <div v-if="hasDiscount" class="hidden md:block text-sm md:py-2 text-center">
                <span class="line-through mx-4">{{ formatNumber(product.price) }} تومان</span>
                <span class="rounded-lg bg-red-500 px-2 text-white">
          {{ discountPercent }}%
        </span>
            </div>

            <div class="hidden md:block text-2xl md:py-2 text-center">
                <span>{{ formatNumber(finalPrice) }} <span class="text-sm">تومان</span></span>
            </div>

            <div class="fixed bottom-2 right-0 z-10 w-full px-2 md:static md:px-0">
                <button
                    @click="handleAddToCart"
                    class="flex justify-between items-center text-center my-2 py-2 border rounded-lg lg:w-1/2 lg:mx-auto w-full bg-green-600 text-white"
                >
                    <!-- موبایل -->
                    <div class="md:hidden mx-auto flex-col text-center">
                        <div v-if="hasDiscount">
              <span class="rounded-lg text-sm bg-red-500 px-1">
                {{ discountPercent }}%
              </span>
                            <span class="line-through text-sm px-2">{{ formatNumber(product.price) }} تومان</span>
                        </div>
                        <div>
                            <span class="text-xl">{{ formatNumber(finalPrice) }} تومان</span>
                        </div>
                    </div>

                    <!-- آیکون -->
                    <svg
                        width="30"
                        height="30"
                        class="md:hidden mx-2"
                        viewBox="0 0 30 30"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <circle cx="15" cy="15" r="14.5" stroke="white" />
                        <line
                            x1="15"
                            y1="7.1"
                            x2="15"
                            y2="22.9"
                            stroke="white"
                            stroke-width="2"
                        />
                        <line
                            x1="7.132"
                            y1="14.966"
                            x2="22.868"
                            y2="15.034"
                            stroke="white"
                            stroke-width="2"
                        />
                    </svg>

                    <span class="hidden md:block mx-auto">افزودن سبد خرید</span>
                </button>
            </div>

            <!-- پیام موفقیت -->
            <div v-if="successMessage" class="text-green-600 text-sm mt-2 text-center">
                {{ successMessage }}
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import { router } from '@inertiajs/vue3'
const props = defineProps({
    product: Object
})
import { usePage } from '@inertiajs/vue3'
import axios from 'axios' // فقط اگر لازم شد فچ بک‌آپ گرفته شود

const page = usePage()
import { useCartStore } from '../../store/cart.js'
import {route} from "ziggy-js";

const cartStore = useCartStore()



// خصوصیات
const attributes = computed(() => {
    if (!props.product.attributes) return []
    return typeof props.product.attributes === 'string'
        ? JSON.parse(props.product.attributes)
        : props.product.attributes
})

// کدها
const codes = computed(() => {
    if (!props.product.code) return []
    try {
        return JSON.parse(props.product.code)
    } catch (e) {
        console.error('خطا در parse کردن code:', e)
        return []
    }
})

const selectedCode = ref('')
const successMessage = ref('')

// قیمت نهایی
const finalPrice = computed(() => {
    const discount = Number(props.product.discount_price)
    const price = Number(props.product.price)
    if (discount && discount > 0) {
        return discount
    }
    return price
})

const hasDiscount = computed(() => {
    const discount = Number(props.product.discount_price)
    return discount && discount > 0
})
const discountPercent = computed(() =>
    Math.round(
        ((props.product.price - props.product.discount_price) / props.product.price) * 100
    )
)

// افزودن به سبد خرید


const handleAddToCart = () => {
    if (!selectedCode.value) {
        const el = document.getElementById('codeMessage')
        const $toast = useToast();
        $toast.info('طرح یا رنگ انتخاب نشده است', { duration: 3000, position: 'top-right' });
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' })
        }
        successMessage.value = 'لطفاً یک طرح انتخاب کنید.'
        return
    }
    // پیام موفقیت محلی
    successMessage.value = `محصول با طرح "${selectedCode.value}" به سبد خرید اضافه شد ✅`

    // 1) آپدیت محلی فوری (optimistic)
    cartStore.addLocal({
        id: props.product.id,
        code: selectedCode.value,
        name: props.product.name,
        price: props.product.price,
        images: props.product.images ?? {},
        quantity: 1
    })

    // درخواست به سرور
    const url = `/addtocart/${props.product.id}?code=${encodeURIComponent(selectedCode.value)}`
    router.visit(url, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            // 2) وقتی پاسخ اینرشیا رسید، داده‌های سرور را روی store مرج کن
            const serverCartItems = page.props.cart?.items

            if (Array.isArray(serverCartItems)) {

                cartStore.setItems(serverCartItems)
            } else {
                // fallback: اگر سرور پروپ cart نفرستاد، با یک API صریح بگیری
                axios.get(route('cart.current')).then(res => {

                    cartStore.setItems(res.data.items || [])
                }).catch(() => {
                    // اگر fail شد، فعلاً به همان optimistic تکیه کن
                })
            }
        },
        onError: () => {
            // خطا — پیام موفقیت را بردار و در صورت نیاز rollback محلی
            successMessage.value = ''
            // (اختیاری) می‌توانی یک rollback هم انجام دهی — یا از سرور re-sync بگیر
        }
    })

    setTimeout(() => { successMessage.value = '' }, 4000)
}


// فرمت عدد
const formatNumber = (number) =>
    new Intl.NumberFormat('fa-IR').format(Number(number))
</script>
