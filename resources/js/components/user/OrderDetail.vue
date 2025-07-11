

<script setup>
import {ref, onMounted, computed} from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const router = useRouter()
const order = ref(null)

onMounted(async () => {
    try {

        const res = await axios.get(`/api/user/orders/${route.params.id}`)
        console.log(res)
        order.value = res.data.order


    } catch (e) {
        console.error('خطا در دریافت جزئیات سفارش', e)
    }
})
const formatNumber = (number) =>
    new Intl.NumberFormat('fa-IR').format(Number(number))
const getThumb = (images) => {
    try {
        const imgObj = typeof images === 'string' ? JSON.parse(images) : images
        return `/storage/images/products/thumb/${imgObj.thumb}`
    } catch {
        return '/placeholder.jpg'
    }
}

const formatDate = (dateStr) => {
    const date = new Date(dateStr)
    return date.toLocaleDateString('fa-IR')
}
const parsedAddress = computed(() => {
    try {
        return typeof order.value?.address === 'string'
            ? JSON.parse(order.value.address)
            : order.value?.address || {}
    } catch {
        return {}
    }
})

const goBack = () => {
    router.push({ name: 'user.orders' })
}
</script>
<template>
    <div class="max-w-5xl mx-auto p-4 space-y-6">


        <div v-if="order" class="space-y-3">
            <h2 class="text-2xl font-bold mb-4">جزئیات سفارش #{{ order.id }}</h2>
            <!-- اطلاعات کلی سفارش -->
            <div class="bg-white p-4 rounded shadow-md">
                <div class="grid md:grid-cols-2 gap-4 text-sm">
                    <div><strong>وضعیت:</strong> {{ order.status }}</div>
                    <div><strong>تاریخ سفارش:</strong> {{ formatDate(order.created_at) }}</div>
                    <div><strong>روش ارسال:</strong> {{ order.shipping_method }}</div>
                    <div><strong>کد رهگیری:</strong> {{ order.tracking_number || '-' }}</div>
                    <div><strong>مبلغ کل:</strong> <span class="text-green-600 font-semibold">{{ formatNumber(order.total) }} تومان</span></div>
                </div>
            </div>

            <!-- آدرس -->
            <div class="bg-white p-4 rounded shadow-md text-sm">
                <strong>آدرس ارسال:</strong>
                <div class="mt-1 text-gray-700 leading-relaxed">
                    {{ parsedAddress.province }}، {{ parsedAddress.city }}<br>
                    {{ parsedAddress.address }}
                </div>
            </div>

            <!-- آیتم‌های سفارش -->
            <div class="bg-white p-4 rounded shadow-md">
                <h3 class="text-lg font-semibold mb-4">محصولات سفارش</h3>
                <div v-for="item in order.order_items" :key="item.id" class="flex items-center gap-4 mb-4 border-b pb-2">
                    <img
                        :src="getThumb(item.product.images)"
                        alt="product"
                        class="w-16 h-16 object-cover rounded"
                    />
                    <div class="text-sm space-y-1">
                        <div class="font-medium">{{ item.product.name }}</div>
                        <div>تعداد: {{ item.quantity }}</div>
                        <div>قیمت واحد: {{ formatNumber(item.price) }} تومان</div>
                        <div class="text-green-600">قیمت کل:   {{ formatNumber(item.price*item.quantity) }} تومان</div>
                    </div>
                </div>
            </div>

            <!-- دکمه برگشت -->
            <div class="text-left mt-6">
                <button @click="goBack" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    بازگشت
                </button>
            </div>
        </div>

        <div v-else class="text-center text-gray-400">در حال بارگذاری...</div>
    </div>
</template>
