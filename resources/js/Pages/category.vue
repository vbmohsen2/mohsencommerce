<script setup>
import {Head, usePage} from "@inertiajs/vue3";
import CategoryProducts from "./category/CategoryProducts.vue";
// const category = usePage().props.category.slug;



</script>

<template>
    <!--    <Head :title="appName" />-->
    <!--    <meta name="description" :content= "description"  />-->
    <!--    <meta name="csrf-token" :content="csrfToken" />-->
    <!--    <link rel="icon" href="/favicon.ico" type="image/png" />-->
    <!--    <meta property="og:type" content="website" />-->
    <!--    &lt;!&ndash;    <meta property="og:url" :content="window.location.href" />&ndash;&gt;-->
    <!--    <meta property="og:title" :content="appName" />-->
    <!--    <meta property="og:description" :content="description" />-->



    <section>
<category-products ></category-products>
    </section>
</template>

<style scoped>

</style>
