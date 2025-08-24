<script setup>
import axios from "axios";
import {computed, onMounted, ref} from "vue";
import {data} from "autoprefixer";
import ShareMenu from "@/components/products/romano/ShareMenu.vue";
import {usePage} from "@inertiajs/vue3";

const props = defineProps({
    product: Object
})
const isLoggedIn = usePage().props.auth.user
// console.log(isLoggedIn)
const like= ref(true)

const likeFetch=async (product) => {
    if ( isLoggedIn!=null) {
        try {
            const response = await axios.get(`/api/getlikestatus/${product.id}`)
            // console.log(response)
           like.value=response.data.like
        } catch (error) {
            // console.error('خطا در like', error)
        }
    }
}
onMounted(() => {
   likeFetch(props.product)
})
const page = usePage()
const currentUrl = page.url
const togglelike=async (product) => {
    try {
        const res = await axios.post("/api/changelike", {
            product_id: product.id,
            like: like.value === 1 ? 0 : 1
        });


        // آپدیت وضعیت like در محصول
       like.value = res.data.like;
    } catch (error) {
        console.log(error)
        if (error.response.status === 401) {

            if (typeof openLoginModal === 'function') {
                openLoginModal();
            } else {
                // window.openLoginModal?.();
            }

        }

        // console.error("خطا در لایک:", error);
    }
}
</script>

<template>
    <div class="flex lg:flex-col align-top text-2xl lg:w-1/12">
        <ul class="float-left">
            <li title="اضافه به علاقه مندی" class="inline-block mx-1 cursor-pointer" @click="togglelike(product)">
                <i :class="[
        'fa-heart',
        like === 1 ? 'fa-solid text-red-500' : 'fa-regular text-gray-500'
     ]"></i>
            </li>


            <li class="inline-block mx-1">

                <ShareMenu  />

            </li>


            <li class="inline-block mx-1"><i class="fa fa-code-compare text-gray-500"></i></li>
        </ul>
    </div>
</template>

<style scoped>

</style>
