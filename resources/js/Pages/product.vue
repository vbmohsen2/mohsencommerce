<script setup>
import {Head, usePage} from "@inertiajs/vue3";
const { appName } = usePage().props


import Product from "../components/products/romano/romanoProductPage.vue";
import {useHead} from "@vueuse/head";
import {computed} from "vue";
// console.log(usePage().props)
const { csrfToken,currentUrl,siteUrl } = usePage().props;
const productprops=usePage().props.product



const productMainImage = computed(() => {
    try {
        const images = JSON.parse(productprops.images);
        return images.main;
    } catch (e) {
        console.error("Failed to parse product images JSON:", e);
        return '';
    }
});



// Create the product schema as a computed property for reactivity

    const isDiscounted = productprops.discount_price > 0;
   const  finalprice = isDiscounted ? productprops.discount_price : productprops.price;
    const availabilityStatus = productprops.stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock';

const structuredData = {
    "@context": "https://schema.org",
    "@type": "Product",
    "name": productprops.name,
    "image": [`${siteUrl}/storage/images/products/${productMainImage.value}`],
    "description": productprops.seo_description,
    "offers": {
        "@type": "Offer",
        "price": finalprice * 10,
        "priceCurrency": "IRR",
        "availability": availabilityStatus
    }
}
useHead({
    script: [
        {
            type: 'application/ld+json',
            innerHTML: JSON.stringify(structuredData)
        }
    ]
})
</script>

<template>


<head>
    <title>{{productprops.name}}</title>
    <meta name="description" :content="productprops.seo_description" />
    <meta name="csrf-token" :content="csrfToken" />
    <meta property="og:type" content="product" />
    <meta property="og:url" content="{{ currentUrl }}" />
    <meta property="og:title" content="{{ productprops.name }}" />
    <meta property="og:description" content="{{ productprops.seo_description }}" />


    <meta property="og:image" :content="`${siteUrl}/storage/images/products/${productMainImage.value}`" />



    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:title" content="{{ productprops.name }}" />
    <meta property="twitter:description" content="{{productprops.seo_description}}" />
    <meta property="twitter:image" :content="`${siteUrl}/storage/images/products/${productMainImage.value}`" />
</head>

    <section>

    <product :product='productprops' />
    </section>
</template>

<style scoped>

</style>
