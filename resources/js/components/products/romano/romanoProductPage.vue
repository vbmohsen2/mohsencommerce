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
    <div class="flex max-md:flex-col">

    <product-gallery :product="product" />
        <product-info :product="product"/>


    </div>
    <div class="pt-2 pb-4 w-full" v-html="product.description"></div>

    <same-product/>

</template>
<script setup>
import {onMounted, ref} from "vue";
import axios from "axios";
import ProductGallery from "@/components/products/romano/ProductGallery.vue";
import ProductInfo from "@/components/products/romano/ProductInfo.vue";
import SameProduct from "@/components/products/romano/sameProduct.vue";
import {usePage} from "@inertiajs/vue3";

const breadcrumb = ref([])
const { product } = defineProps({
    product: Object
})
breadcrumb.value=usePage().props.categories
// const categoryView=async (categoryId) => {
//     if (categoryId) {
//         try {
//             const response = await axios.get(`/api/categories/breadcrumb/${product.category.id}`)
//             breadcrumb.value = response.data
//             console.log(response.data)
//         } catch (error) {
//             console.error('خطا در دریافت breadcrumb:', error)
//         }
//     }
// }
onMounted(() => {
    // categoryView(product.category.id)
})


</script>
<style scoped>

</style>
