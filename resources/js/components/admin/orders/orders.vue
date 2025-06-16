<template>
    <div class="p-6 max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">مدیریت سفارشات</h1>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded-lg shadow text-sm text-center">
                <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2">شناسه</th>
                    <th class="px-4 py-2">کاربر</th>
                    <th class="px-4 py-2">تاریخ</th>
                    <th class="px-4 py-2">وضعیت</th>
                    <th class="px-4 py-2">مجموع</th>
                    <th class="px-4 py-2">عملیات</th>
                </tr>
                <!-- Filters Row -->
                <tr>
                    <th class="px-4 py-1">
                        <input
                            v-model="filters.id"
                            type="text"
                            class="w-24 border rounded px-2 py-1 text-sm"
                            placeholder="جستجو"
                        />
                    </th>
                    <th class="px-4 py-1">
                        <input
                            v-model="filters.user_name"
                            type="text"
                            class="w-32 border rounded px-2 py-1 text-sm"
                            placeholder="نام کاربر"
                        />
                    </th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="order in orders" :key="order.id" class="border-t">
                    <td class="py-2">{{ order.id }}</td>
                    <td class="py-2">{{ order.user_name }}</td>
                    <td class="py-2">{{ formatDate(order.created_at) }}</td>
                    <td class="py-2">
                        <select
                            v-model="order.status"
                            @change="updateStatus(order)"
                            class="border rounded px-2 py-1 text-sm"
                        >
                            <option value="معلق">معلق</option>
                            <option value="در حال پردازش">در حال پردازش</option>
                            <option value="ارسال شده">ارسال شده</option>
                            <option value="تحویل داده شده">تحویل داده شده</option>
                            <option value="کنسل">کنسل</option>
                        </select>
                    </td>
                    <td class="py-2">{{ formatPrice(order.total) }} ریال</td>
                    <td class="py-2">
                        <router-link :to="`/admin/orders/${order.id}`" class="text-blue-600 hover:underline">
                            مشاهده
                        </router-link>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center items-center gap-4 mt-6">
            <button
                @click="goToPage(currentPage.value - 1)"
                :disabled="currentPage.value === 1"
                class="px-3 py-1 bg-gray-100 rounded hover:bg-gray-200 disabled:opacity-50"
            >
                قبلی
            </button>
            <span class="text-sm text-gray-700">
        صفحه {{ currentPage.value }} از {{ lastPage.value }}
      </span>
            <button
                @click="goToPage(currentPage.value + 1)"
                :disabled="currentPage.value === lastPage.value"
                class="px-3 py-1 bg-gray-100 rounded hover:bg-gray-200 disabled:opacity-50"
            >
                بعدی
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'
import debounce from 'lodash.debounce'

const orders = ref([])
const currentPage = ref(1)
const lastPage = ref(1)
const perPage = 10

const filters = ref({
    id: '',
    user_name: ''
})

// Fetch Orders
const fetchOrders = async (page = 1) => {
    currentPage.value = page
    try {
        const response = await axios.get('/api/orders', {
            params: {
                page: page,
                per_page: perPage,
                ...filters.value
            }
        })
        orders.value = response.data.data
        currentPage.value = response.data.current_page
        lastPage.value = response.data.last_page
    } catch (error) {
        console.error('خطا در دریافت سفارش‌ها', error)
    }
}

// Pagination
const goToPage = (page) => {
    if (page >= 1 && page <= lastPage.value) {
        fetchOrders(page)
    }
}

// Update status
const updateStatus = async (order) => {
    try {
       const a=await axios.put(`/api/orders/${order.id}/status`, {
            status: order.status
        }

        )
        console.log(a.data)
    } catch (error) {
        console.log(error)
        alert('خطا در بروزرسانی وضعیت')
    }
}

const formatDate = (dateStr) => {
    return new Date(dateStr).toLocaleDateString('fa-IR')
}

const formatPrice = (value) => {
    return new Intl.NumberFormat('fa-IR').format(value)
}

// Debounce search
const debouncedFetch = debounce(() => {
    fetchOrders(1)
}, 500)

watch(filters, debouncedFetch, { deep: true })

// Initial Load
fetchOrders()
</script>

<style scoped>
table th,
table td {
    text-align: center;
}
</style>
