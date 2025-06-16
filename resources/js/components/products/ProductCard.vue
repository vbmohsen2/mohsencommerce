<template>
    <a  :href="`/product/${product.slug}`" class="bg-white rounded-2xl shadow cursor-pointer hover:shadow-lg border-2 border-transparent hover:border-gray-300 hover:border-opacity-60 transition p-4 flex flex-col">
        <img
            :src="getMainImage(product.images)"
            :alt="product.name"
            class="w-full h-40 object-contain mb-4"
        />

        <h3 class="text-sm font-medium mb-2 line-clamp-2">{{ product.name }}</h3>

        <div class="mt-auto">
            <div class="text-gray-700 font-bold text-lg">
                {{ formatPrice(product.price) }}
                <span v-if="product.discount" class="text-sm text-red-500 ml-2 line-through">
          {{ formatPrice(product.price + product.discount) }}
        </span>
            </div>

<!--            <button-->
<!--                @click="$emit('add-to-cart', product)"-->
<!--                class="w-full mt-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-4 rounded-xl"-->
<!--            >-->
<!--                افزودن به سبد-->
<!--            </button>-->
        </div>
    </a>
</template>

<script setup>
const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
})

const formatPrice = (price) => {
    return new Intl.NumberFormat('fa-IR', {
        style: 'currency',
        currency: 'IRR',
        maximumFractionDigits: 0,
    }).format(price)
}

function getMainImage(imageJson) {
    try {

        const images = JSON.parse(imageJson)
        return '/storage/images/products/' + images.main
    } catch {
        return '/placeholder.png'
    }
}

function redirecttoproductpage(){
    window.location.href=`/product/${props.product.slug}`
}
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
