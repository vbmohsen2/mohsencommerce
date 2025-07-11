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

        <!-- خط جداکننده زیبا -->
        <div class="w-full border-t border-dashed border-gray-300 my-4"></div>

        <!-- انتخاب طرح -->
        <div class="w-full py-2">
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
            <div v-if="selectedCode" class="mt-3 text-green-600 text-sm font-medium">
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

const props = defineProps({
    product: Object
})

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
        successMessage.value = 'لطفاً یک طرح انتخاب کنید.'
        return
    }

    // شبیه‌سازی افزودن به سبد خرید
    successMessage.value = `محصول با طرح "${selectedCode.value}" به سبد خرید اضافه شد ✅`
    const url = `/addtocart/${props.product.id}?code=${encodeURIComponent(selectedCode.value)}`;
    window.location.href = url;
    setTimeout(() => {
        successMessage.value = ''
    }, 4000)
}

// فرمت عدد
const formatNumber = (number) =>
    new Intl.NumberFormat('fa-IR').format(Number(number))
</script>
