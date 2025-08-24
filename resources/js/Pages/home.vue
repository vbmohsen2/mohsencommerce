<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import Carousel from '../components/home/Carousel.vue';
import row from '../components/home/row.vue';
import Carousel2 from "@/components/home/carousel2/carousel2.vue";
import { computed } from 'vue';
import {useHead} from "@vueuse/head";

const { topDiscountedProducts, topseller, appName, description, csrfToken, currentUrl } = usePage().props;

const carouselImages = [
    { src: 'images/slides/shal.jpg' },
    { src: 'images/slides/romanoscarf2.jpg' },
    { src: 'images/slides/gemini shal.jpg' },
    { src: 'images/slides/scarf.jpg' },
];

const structuredData ={
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": appName,
    "url": currentUrl,
    "logo": "/favicon.ico",
    "sameAs": [
        "https://t.me/romanoscarfard",
        "https://www.instagram.com/romanoscarf.ard/"
    ]
};
useHead({
    script: [
        {
            type: 'application/ld+json',
            innerHTML: JSON.stringify(structuredData)
        }
    ]
});
</script>

<template>

    <Head>
        <title>{{ appName }}</title>
        <meta name="description" :content="description" />
        <meta name="csrf-token" :content="csrfToken" />
        <link rel="icon" href="/favicon.ico" type="image/png" />
        <link rel="canonical" :href="currentUrl" />

        <meta property="og:type" content="website" />
        <meta property="og:url" :content="currentUrl" />
        <meta property="og:title" :content="appName" />
        <meta property="og:description" :content="description" />
        <meta property="og:site_name" :content="appName" />
        <meta property="og:locale" content="fa_IR" />

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" :content="appName" />
        <meta name="twitter:description" :content="description" />


    </Head>

    <section>
        <div class="flex flex-col md:flex-row w-full md:h-72">
            <Carousel :images="carouselImages"></Carousel>
            <row></row>
        </div>
        <div class="mb-4 mt-8 text-xl">
            بیشترین تخفیف ها
        </div>
        <carousel2 :products="topDiscountedProducts"></carousel2>

        <div class="mb-4 mt-8 text-xl">
            بیشترین تخفیف ها
        </div>
        <carousel2 :products="topseller"></carousel2>
    </section>
</template>
