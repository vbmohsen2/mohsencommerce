<template>
    <div class="p-4 ">
        <!-- Wrapper: در حالت دسکتاپ فیلتر در سمت راست، محصولات سمت چپ؛ در موبایل زیر هم -->
        <div class="flex flex-col md:flex-row  gap-6">
            <!-- بخش فیلتر (ستون راست در دسکتاپ) -->
            <div class="w-full md   md:w-fit">
                <div class="mb-4 lg:mb-0">
                    <!-- در موبایل این قسمت همیشه باز است؛ در دسکتاپ هم می‌توانید همیشه باز نگه دارید یا از details استفاده کنید -->
                    <details  class="mb-4 md:mb-0">
                        <summary class="cursor-pointer bg-blue-100 px-4 py-2 rounded-md text-gray-800 font-medium">
                            فیلتر دسته‌بندی
                        </summary>
                        <div class="mt-2 border p-2 rounded-md bg-white shadow">
                            <CategoryTree
                                v-if="categories.length"
                                :categories="categories"
                                :selected="selectedCategories"
                                @update:selected="val => {
                  selectedCategories = val;
                  currentPage = 1;
                  fetchProducts();
                }"
                            />
                        </div>
                    </details>
                </div>
            </div>

            <!-- بخش محصولات (ستون چپ در دسکتاپ) -->
            <div class="w-full lg:w-5/6">
                <!-- جستجو -->
                <div class="my-4">
                    <input
                        v-model="search"
                        @input="onSearch"
                        type="text"
                        placeholder="جستجوی محصول..."
                        class="w-full md:w-1/2 p-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"
                    />
                </div>

                <!-- محصولات -->
                <div v-if="products.data?.length" class="mt-4">
                    <h3 class="font-bold mb-4 text-lg">محصولات:</h3>

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <div
                            v-for="product in products.data"
                            :key="product.id"
                            class="border rounded-lg shadow-sm overflow-hidden transition hover:shadow-md"
                        >
                            <div class="border rounded-lg shadow-sm overflow-hidden transition hover:shadow-md flex flex-col h-full">

                                <!-- بخش کلیک‌پذیر (تصویر + متن) -->
                                <a
                                    :href="`/admin/products/${product.id}`"
                                    class="block cursor-pointer flex-grow"
                                >
                                    <img
                                        v-if="product.images"
                                        :src="getMainImage(product.images)"
                                        alt="product image"
                                        class="w-full h-40 object-cover"
                                    />

                                    <div class="p-3">
                                        <h4 class="font-semibold text-gray-800 text-lg mb-1 truncate">
                                            {{ product.name }}
                                        </h4>

                                        <p class="text-sm text-gray-600 mb-2">
                                            {{ Number(product.price).toLocaleString('en-US') }} تومان
                                        </p>

                                        <p class="text-sm text-gray-600">
                                            شماره محصول: {{ product.id }}
                                        </p>
                                    </div>
                                </a>

                                <!-- بخش دکمه‌ها (حذف و فعال/غیرفعال) -->
                                <div class="p-3 border-t flex justify-between items-center bg-gray-50">
                                    <button
                                        @click="deleteProduct(product)"
                                        class="flex items-center gap-1 px-2 py-1 rounded-md text-xs font-medium bg-red-500 text-white hover:bg-red-600 active:bg-red-700 transition shadow-sm"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        <span class="hidden sm:inline">حذف</span>
                                    </button>

                                    <input
                                        type="checkbox"
                                        v-model="product.is_active"
                                        @change="changeIsActive(product)"
                                        :true-value="1"
                                        :false-value="0"
                                    />
                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- صفحه‌بندی -->
                    <div class="flex gap-2 mt-6 flex-wrap justify-center">
                        <button
                            v-for="page in products.last_page"
                            :key="page"
                            @click="goToPage(page)"
                            :class="[
                'px-3 py-1 border rounded',
                products.current_page === page
                  ? 'bg-blue-500 text-white'
                  : 'bg-white hover:bg-gray-100'
              ]"
                        >
                            {{ page }}
                        </button>
                    </div>
                </div>

                <!-- در صورت نبود محصول -->
                <div v-else class="mt-4 text-gray-500">محصولی یافت نشد</div>
            </div>
        </div>
    </div>
</template>



<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'
import CategoryTree from './CategoryTree.vue'

const categories = ref([])
const selectedCategories = ref([])
const products = ref({})
const currentPage = ref(1)
const search = ref('')

const fetchCategories = async () => {
    const res = await axios.get('/api/categories')
    categories.value = res.data
}

const fetchProducts = async () => {
    const res = await axios.get('/api/products', {
        params: {
            categories: selectedCategories.value,
            page: currentPage.value,
            search: search.value
        }
    })
    products.value = res.data

}
const deleteProduct = async (product) => {
    if (confirm(`آیا از حذف محصول "${product.name}" مطمئن هستید؟`)) {
        try {
           console.log(await axios.delete(`/api/product/${product.id}`));
            fetchProducts(); // لیست را به‌روز کن
        } catch (error) {
            alert('خطا در حذف محصول');
            console.error(error);
        }
    }
}
const changeIsActive = async (product) => {
    try {
        await axios.patch(`/api/product/${product.id}/toggle-active`, {
            is_active: product.is_active
        });
        // اختیاری: پیام موفقیت یا نوتیفیکیشن
    } catch (error) {
        alert('خطا در تغییر وضعیت فعال بودن');
        console.error(error);
    }
}
const goToPage = (page) => {
    currentPage.value = page
    fetchProducts()
}
const getMainImage=(images)=> {
    try {
        const parsed = JSON.parse(images);
        if(parsed.thumb==null){
            return ''
        }

        return `/storage/images/products/thumb/${parsed.thumb}`;
    } catch (e) {
        return ''; // یا تصویر پیش‌فرض
    }
}
const onSearch = () => {
    currentPage.value = 1
    fetchProducts()
}

onMounted(async () => {
    await fetchCategories()
    await fetchProducts()
})

watch(selectedCategories, () => {
    currentPage.value = 1
    fetchProducts()
})
</script>
