<template>
    <div class="max-w-5xl mx-auto p-4 space-y-6">
        <h2 class="text-2xl font-bold mb-4">سفارش‌های من</h2>

        <div
            v-for="order in orders"
            :key="order.id"
            class="border rounded cursor-pointer shadow-sm p-4 hover:shadow-md transition"
            @click="goToOrderDetail(order.id)"
        >
            <div class="flex justify-between flex-wrap gap-2 items-center mb-2">
                <div class="text-sm text-gray-600">شماره سفارش: <span class="font-medium text-black">{{ order.id }}</span></div>
                <div class="text-sm text-gray-600">وضعیت: <span class="font-medium text-black">{{ order.status }}</span></div>
                <div class="text-sm text-gray-600">روش ارسال: <span class="text-black">{{ order.shipping_method }}</span></div>
                <div class="text-sm text-gray-600">کد رهگیری: <span class="text-black">{{ order.tracking_number || '-' }}</span></div>
                <div class="text-sm text-gray-600">مبلغ کل: <span class="text-green-700 font-bold">{{ formatNumber(order.total) }} تومان</span></div>
            </div>

            <!-- نمایش حداکثر 3 آیتم -->
            <div class="flex items-center gap-4 mt-3 overflow-x-auto">
                <div
                    v-for="(item, i) in order.order_items.slice(0, 3)"
                    :key="i"
                    class="flex items-center gap-2 bg-gray-50 p-2 rounded-md"
                >
                    <img  :src="getThumb(item.product.images)" alt="" class="w-12 h-12 object-cover rounded" />
                    {{console.log(item.product.images)}}
                    <div class="text-sm">
                        <div class="font-medium text-gray-800">{{ item.product.name }}</div>
                        <div v-if="item.code" class="font-medium text-gray-800">طرح:{{ item.code }}</div>
                        <div class="text-xs text-gray-500">{{ item.quantity }} عدد</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- در صورت نداشتن سفارش -->
        <div v-if="orders.length === 0" class="text-center text-gray-400 mt-12">
            هیچ سفارشی ثبت نشده است.
        </div>
        <div v-if="lastPage > 1" class="flex justify-center mt-6 space-x-2 rtl:space-x-reverse">
            <button
                @click="fetchOrders(currentPage - 1)"
                :disabled="currentPage === 1"
                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
            >
                قبلی
            </button>

            <button
                v-for="page in lastPage"
                :key="page"
                @click="fetchOrders(page)"
                :class="[
      'px-3 py-1 rounded',
      page === currentPage ? 'bg-blue-600 text-white' : 'bg-gray-100 hover:bg-gray-300'
    ]"
            >
                {{ page }}
            </button>

            <button
                @click="fetchOrders(currentPage + 1)"
                :disabled="currentPage === lastPage"
                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
            >
                بعدی
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const orders = ref([])
const router = useRouter()
const currentPage = ref(1)
const lastPage = ref(1)

const fetchOrders = async (page = 1) => {
    try {
        const res = await axios.get(`/api/user/orders?page=${page}`)
        console.log(res)
        orders.value = res.data.data
        currentPage.value = res.data.current_page
        lastPage.value = res.data.last_page
    } catch (e) {
        console.error('خطا در دریافت سفارش‌ها', e)
    }
}
onMounted(() => fetchOrders())
const formatNumber = (number) =>
    new Intl.NumberFormat('fa-IR').format(Number(number))
// onMounted(async () => {
//     axios.defaults.withCredentials = true
//
//     try {
//         const res = await axios.get('/api/user/orders')
//         console.log(res)
//         orders.value = res.data.orders
//     } catch (e) {
//         console.log(e)
//     }
// })
const getThumb = (images) => {
    try {
        const imgObj = typeof images === 'string' ? JSON.parse(images) : images
        return `/storage/images/products/thumb/${imgObj.thumb}`
    } catch {
        return '/placeholder.jpg'
    }
}
const goToOrderDetail = (orderId) => {
    router.push({ name: 'user.order.detail', params: { id: orderId } })
}
</script>
