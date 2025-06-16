<template>
    <div class="max-w-4xl mx-auto p-4">
        <h2 class="text-2xl font-semibold mb-4">جزئیات سفارش</h2>

        <div class="bg-white shadow rounded-lg p-4 mb-6 space-y-4">
            <div>
                <label class="block font-medium mb-1">شماره سفارش:</label>
                <p>{{ order.id }}</p>
            </div>

            <div>
                <label class="block font-medium mb-1">وضعیت:</label>
                <select v-model="order.status" @change="updateStatus" class="border rounded px-3 py-2 w-full">
                    <option v-for="s in statuses" :key="s" :value="s">{{ s }}</option>
                </select>
            </div>

            <div>
                <label class="block font-medium mb-1">استان:</label>
                <input v-model="address.province" @blur="updateAddress" type="text"
                       class="border rounded px-3 py-2 w-full mb-2"/>
            </div>

            <div>
                <label class="block font-medium mb-1">شهر:</label>
                <input v-model="address.city" @blur="updateAddress" type="text"
                       class="border rounded px-3 py-2 w-full mb-2"/>
            </div>

            <div>
                <label class="block font-medium mb-1">آدرس دقیق:</label>
                <textarea v-model="address.address" @blur="updateAddress" rows="3"
                          class="border rounded px-3 py-2 w-full resize-none"></textarea>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-3">آیتم‌های سفارش</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-right">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">نام محصول</th>
                        <th class="px-4 py-2">تعداد</th>
                        <th class="px-4 py-2">قیمت واحد</th>
                        <th class="px-4 py-2">مجموع</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in order.order_items" :key="item.id" class="border-t">
                        <td class="px-4 py-2">{{ item.product.name }}</td>
                        <td class="px-4 py-2">{{ item.quantity }}</td>
                        <td class="px-4 py-2">{{ formatPrice(item.price) }}</td>
                        <td class="px-4 py-2">{{ formatPrice(item.price * item.quantity) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const order = ref({})
const statuses = ['معلق', 'در حال پردازش', 'ارسال شده', 'تحویل داده شده', 'کنسل']

// آدرس را به صورت جداگانه ذخیره میکنیم
const address = reactive({
    province: '',
    city: '',
    address: ''
})

const fetchOrder = async () => {
    try {
        const { data } = await axios.get(`/api/orders/${route.params.id}`)
        order.value = data.order

        // پارس کردن JSON آدرس
        if (order.value.address) {
            const addr = typeof order.value.address === 'string' ? JSON.parse(order.value.address) : order.value.address
            address.province = addr.province || ''
            address.city = addr.city || ''
            address.address = addr.address || ''
        }
    } catch (error) {
        alert('خطا در بارگذاری سفارش')
    }
}

const updateStatus = async () => {
    try {
        await axios.put(`/api/orders/${order.value.id}/status`, {
            status: order.value.status
        })
        alert('وضعیت با موفقیت بروزرسانی شد')
    } catch (error) {
        alert('خطا در بروزرسانی وضعیت')
    }
}

const updateAddress = async () => {
    try {
        await axios.put(`/api/orders/${order.value.id}/address`, {
            province: address.province,
            city: address.city,
            address: address.address,
        })
        // alert('آدرس با موفقیت بروزرسانی شد')
    } catch (error) {
        alert('خطا در بروزرسانی آدرس')
    }
}

const formatPrice = (value) => {
    return new Intl.NumberFormat('fa-IR').format(value) + ' ریال'
}

onMounted(fetchOrder)
</script>
