<script setup>
import { useCartStore } from '../store/cart.js'

const cartStore = useCartStore()

// فرض می‌کنیم مقدار اولیه سبد خرید از صفحه اینرشیا (usePage) یا props پاس داده شده
import { usePage } from '@inertiajs/vue3'
import {watch} from "vue";

const page = usePage()
// ست کردن مقدار اولیه فقط یک بار
watch(
    () => page.props.cart?.items,
    (newItems) => {
        if (Array.isArray(newItems)) cartStore.setItems(newItems)

    },
    { immediate: true, deep: true }

)

cartStore.items = cartStore.items.map(item => ({
    ...item,
    images: JSON.parse(item.images)
}));

</script>

<template>
    <div v-if="cartStore.items.length > 0">
        <div v-for="item in cartStore.items" :key="item.id + '-' + item.code" class="flex justify-between gap-3 mb-4 border-b pb-2">


            <img
                :src="`/storage/images/products/thumb/${item.images.thumb}`"
                :alt="item.name"
                class="w-16 h-16 rounded object-cover"
            />            <div class="flex-grow justify-between">
                <h4 class="font-semibold">{{ item.name }}</h4>
                <p>طرح: {{ item.code }}</p>
                <p class="text-sm text-gray-600">{{ item.price.toLocaleString() }} تومان</p>
            </div>
            <div class="flex items-center mt-2 gap-2">
                <button @click="cartStore.decrease(item.id, item.code)" class="px-2 border">−</button>
                <span class="text-sm">{{ item.quantity }}</span>
                <button @click="cartStore.increase(item.id, item.code)" class="px-2 border">+</button>
                <button @click="cartStore.remove(item.id, item.code)" class="text-red-500 text-lg hover:text-red-700 ml-2" title="حذف">🗑</button>
            </div>
        </div>
        <div class="flex justify-between items-center mt-4 font-bold">
            <span>جمع کل:</span>
            <span>{{ cartStore.total.toLocaleString() }} تومان</span>
        </div>
        <div class="flex justify-between mt-4">
            <button @click="cartStore.clear" class="bg-red-500 px-2 text-center text-white py-2 rounded hover:bg-red-600">پاکسازی سبد خرید</button>
            <a href="/cart" class="px-2 bg-green-400 text-center text-white py-2 rounded hover:bg-green-600">ثبت سفارش</a>
        </div>
    </div>
    <p v-else class="text-center text-gray-500 mt-4">سبد خرید خالی است</p>
</template>
