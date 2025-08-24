<template>
    <div  class="relative w-full mx-auto">

        <input
            v-model="search"
            @input="onInput"
            type="text"
            placeholder="جستجوی محصول..."
            class="border border-gray-300 rounded-lg p-2 w-full
         focus:border-gray-100 focus:ring-1 focus:ring-gray-200 focus:outline-none
         transition duration-200"        />

        <div
            v-if="results.length && showDropdown"
            class="absolute left-0 right-0 bg-white shadow-lg rounded-lg z-50 mt-2 max-h-60 overflow-auto"
        >
            <ul>
                <li
                    v-for="item in results"
                    :key="item.id"
                    class="p-3 hover:bg-gray-100 cursor-pointer flex items-center gap-2"

                >
                    <a :href="`/product/${item.slug}`">
                    <img :src="`/storage/images/products/thumb/${getThumb(item.images)}`" alt="" class="w-10 h-10 object-cover rounded-md" />
                    <div class="flex-1">
                        <p class="font-semibold text-sm">{{ item.name }}</p>

                        <p v-if="Number(item.discount_price) === 0" class="text-xs text-gray-500">
                            {{ formatPrice(item.price) }}
                        </p>
                        <p v-else class="text-xs text-gray-500">
                            {{ formatPrice(item.discount_price) }}
                        </p>
                    </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import debounce from 'lodash/debounce'

const search = ref('')
const results = ref([])
const showDropdown = ref(false)

const fetchResults = debounce(async () => {
    if (!search.value.trim()) {
        results.value = []
        showDropdown.value = false
        return
    }

    try {
        const response = await axios.get(`/products/search?q=${search.value}`)
        results.value = response.data
        showDropdown.value = true
    } catch (error) {
        console.error(error)
    }
}, 500)
const getThumb = (images) => {
    if (!images) return ''
    if (typeof images === 'string') {
        try {
            const obj = JSON.parse(images)
            return obj.thumb || ''
        } catch {
            return ''
        }
    }
    // اگر از قبل آبجکت بود
    return images.thumb || ''
}
const onInput = () => {
    fetchResults()
}

const formatPrice = (price) => {
    // const tomanPrice = price / 10; // چون قیمت‌ها به ریاله
    return new Intl.NumberFormat('fa-IR', {
        maximumFractionDigits: 0,
    }).format(price) + ' تومان';
}
</script>
