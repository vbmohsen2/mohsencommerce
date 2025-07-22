<template>
    <div class="grid grid-cols-1 md:grid-cols-[250px_1fr] gap-4 relative">
        <!-- Filters -->
        <aside class="hidden md:block sticky top-4 h-fit">
            <FilterSidebar :filters="filters" :brands="brands" v-model="selectedFilters" :disabled="loading" />
        </aside>

        <div class="md:hidden">
            <button @click="showMobileFilters = true" class="text-xl"><i class="fas fa-sliders-h"></i> </button>
            <MobileFilterDrawer
                :filters="filters"
                :brands="brands"
                v-model="selectedFilters"
                :loading="loading"
                :show="showMobileFilters"
                @close="showMobileFilters = false"
            />
        </div>

        <!-- Products -->
        <div>
            <div class="flex justify-between items-center mb-4">
                <select v-model="sortBy" class="p-2 border rounded">
                    <option value="latest">جدیدترین</option>
                    <option value="expensive">بیشترین قیمت</option>
                    <option value="cheap">کمترین قیمت</option>
                    <option value="popular">محبوب‌ترین</option>
                </select>
            </div>

            <div class=" grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2">
                <ProductCard v-for="product in products" :key="product.id" :product="product" />
            </div>

            <div v-if="loading" class="flex flex-col items-center justify-center py-6">
                <div class="loader mb-3"></div>
                <p class="text-gray-600 text-sm">در حال بارگذاری، لطفاً صبور باشید...</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue'
import axios from 'axios'
import ProductCard from './ProductCard.vue'
import FilterSidebar from './FilterSidebar.vue'
import MobileFilterDrawer from './MobileFilterDrawer.vue'

const props = defineProps({
categorySlug:String
})

const products = ref([])
const filters = ref([])
const brands = ref([])
const selectedFilters = ref({})
const sortBy = ref('latest')
const page = ref(1)
const loading = ref(false)
const hasMore = ref(true)
const showMobileFilters = ref(false)

const fetchFilters = async () => {
    const { data } = await axios.get(`/api/categories/${props.categorySlug}/filters`)
    filters.value = data.attributes
    brands.value = data.brands
    // console.log(filters.value)
}

const fetchProducts = async (reset = false) => {
    if (loading.value || (!hasMore.value && !reset)) return
    loading.value = true
    if (reset) {
        page.value = 1
        products.value = []
        hasMore.value = true
    }

    const filtersWithoutBrand = { ...selectedFilters.value }
    delete filtersWithoutBrand.brand

    const { data } = await axios.get(`/api/categories/${props.categorySlug}/products`, {
        params: {
            brand: selectedFilters.value.brand,       // به طور جدا
            filters: filtersWithoutBrand,             // فقط attributes
            sort_by: sortBy.value,
            page: page.value,
        },
    })

    products.value.push(...data.data)
    hasMore.value = !!data.next_page_url
    page.value++
    loading.value = false
}

onMounted(() => {
    fetchFilters()
    fetchProducts()
})

watch([selectedFilters, sortBy], () => {
    fetchProducts(true)
})

window.addEventListener('scroll', () => {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500) {
        fetchProducts()
    }
})
</script>
<style scoped>
.loader {
    width: 48px;
    height: 48px;
    border: 5px solid #e0e0e0;
    border-top-color: #6366f1; /* رنگ بنفش مدرن */
    border-radius: 50%;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
</style>
