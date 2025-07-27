<template>
    <div class="text-sm text-gray-500  flex flex-wrap gap-1 pb-3  rtl:flex-row-reverse  ">
        <a href="/">فروشگاه اینترنتی</a>
        <template v-for="cat in breadcrumb" :key="cat.id">
            <span>/</span>
            <a :href="`/category/${cat.slug}`" class="hover:text-green-600 transition">
                {{ cat.name }}
            </a>
        </template>
    </div>
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

            <!-- Pagination -->
<!--            <nav v-if="totalPages > 1" class="flex justify-center items-center gap-1 mt-6 w-full">-->
<!--                <button-->
<!--                    @click="changePage(currentPage - 1)"-->
<!--                    :disabled="currentPage === 1"-->
<!--                    class="px-3 py-1 rounded border"-->
<!--                    :class="{ 'opacity-50': currentPage === 1 }"-->
<!--                >-->
<!--                    قبلی-->
<!--                </button>-->

<!--                <button-->
<!--                    v-for="pageNum in visiblePages"-->
<!--                    :key="pageNum"-->
<!--                    @click="changePage(pageNum)"-->
<!--                    class="px-3 py-1 rounded border"-->
<!--                    :class="{ 'bg-gray-800 text-white': currentPage === pageNum }"-->
<!--                >-->
<!--                    {{ pageNum }}-->
<!--                </button>-->

<!--                <button-->
<!--                    @click="changePage(currentPage + 1)"-->
<!--                    :disabled="currentPage === totalPages"-->
<!--                    class="px-3 py-1 rounded border"-->
<!--                    :class="{ 'opacity-50': currentPage === totalPages }"-->
<!--                >-->
<!--                    بعدی-->
<!--                </button>-->
<!--            </nav>-->



            <div v-if="loading" class="flex flex-col items-center justify-center py-6">

                <div class="loader mb-3"></div>
                <p class="text-gray-600 text-sm">در حال بارگذاری، لطفاً صبور باشید...</p>
            </div>
        </div>

    </div>
</template>

<script setup>
import { computed,onMounted, ref, watch} from 'vue'
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
const currentPage = ref(1)
const totalPages = ref(1)
const categoryId=ref()
const breadcrumb=ref()
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
        currentPage.value = 1
        products.value = []
        hasMore.value = true
    }

    const filtersWithoutBrand = { ...selectedFilters.value }
    delete filtersWithoutBrand.brand

    const { data } = await axios.get(`/api/categories/${props.categorySlug}/products`, {
        params: {
            brand: selectedFilters.value.brand,
            filters: filtersWithoutBrand,
            sort_by: sortBy.value,
            page: page.value,
        },
    })

    if (reset) {
        products.value = data.products.data
    } else {
        products.value.push(...data.products.data)
    }

    categoryId.value=data.category_id
    // console.log('categoryid',categoryId.value)
    totalPages.value = data.products.last_page || 1 // فرض می‌کنیم API شما اینو می‌ده
    currentPage.value = page.value
    hasMore.value = !!data.products.next_page_url
    page.value++
    loading.value = false

    // تغییر URL
    const newUrl = `?page=${currentPage.value}`
    window.history.pushState({}, '', newUrl)
    // console.log('data',data )
}
const categoryView=async () => {
    // console.log('categoryView',categoryId.value)
        try {
            const response = await axios.get(`/api/categories/breadcrumb/${categoryId.value}`)
            breadcrumb.value = response.data
            // console.log('breadcrumb', response.data)
        } catch (error) {
            console.error('خطا در دریافت breadcrumb:', error)
        }

}
onMounted(async () => {
    await fetchFilters()
    await fetchProducts()
    console.log(products.value[0].category_id)
    categoryView()
})

watch([selectedFilters, sortBy], () => {
    fetchProducts(true)
})
const changePage = (pageNum) => {
    if (pageNum < 1 || pageNum > totalPages.value) return

    page.value = pageNum
    currentPage.value = pageNum
    products.value = []
    fetchProducts(true)
    window.scrollTo({ top: 0, behavior: 'smooth' })
}
const visiblePages = computed(() => {
    const range = []
    const start = Math.max(1, currentPage.value - 2)
    const end = Math.min(totalPages.value, currentPage.value + 2)
    for (let i = start; i <= end; i++) {
        range.push(i)
    }
    return range
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
