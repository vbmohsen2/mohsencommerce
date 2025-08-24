<template>
    <div>
        <Header />

        <main class="mt-44 container max-w-screen-lg px-6 sm:px-0  mx-auto ">
            <slot />
        </main>
        <Footer />
    </div>
</template>

<script setup>
import Header from '../components/header/Header.vue'

import Footer from '../footer.vue'
</script>
