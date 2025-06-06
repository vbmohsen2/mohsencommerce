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
                            <a :href="`/admin/products/${product.id}`" class="block">
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
                                        {{ product.price }} تومان
                                    </p>
                                    <p class="text-sm text-gray-600 mb-2">
                                        شماره محصول: {{ product.id }}
                                    </p>
                                    <div class="flex justify-between items-center mt-2">
                                        <span class="text-blue-500 text-sm hover:underline">مشاهده جزئیات</span>
                                        <input
                                            type="checkbox"
                                            v-model="product.is_active"
                                            @change="changeIsActive(product)"
                                            :true-value="1"
                                            :false-value="0"
                                        />
                                    </div>
                                </div>
                            </a>
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
const changeIsActive=(product)=>{
    const isChecked = product.is_active === 1; // یا Boolean(product.is_active)
    console.log(isChecked); // فقط true یا false
    //بعدا باید بنویسم
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
