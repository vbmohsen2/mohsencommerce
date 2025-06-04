import './bootstrap';
import Swiper from 'swiper/bundle';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'vue-tree-dnd'

import { createApp } from 'vue';
import CategoryFilter from './components/admin/product/CategoryFilter.vue';
import addProductPage from './components/admin/product/addProductPage.vue'
import editProduct from './components/admin/product/editProduct.vue'


// import CategoryList from "./components/admin/CategoryList.vue";
import CategoryTreeWithEdit from './components/admin/category/CategoryTreeWithEdit.vue';
import blogCategoryEdit from './components/admin/blog/blogCategoryEdit.vue';

import attributesedit from './components/admin/attributes/attributesEdit.vue';
import blogPosts from './components/admin/blog/blogPosts.vue';
import search from './components/products/search.vue';
import router from "./router";

const app = createApp({});
app.component('category-filter', CategoryFilter);
app.component('CategoryTreeWithEdit',CategoryTreeWithEdit);
app.component('addProductPage',addProductPage)
app.component('attributesedit',attributesedit)
app.component('blogCategoryEdit',blogCategoryEdit)
app.component('blogPosts',blogPosts)
app.component('editProduct',editProduct)
app.component('productsearch',search)
// app.component('CategoryList', CategoryList);
app.use(router)
app.mount('#app');


document.addEventListener("DOMContentLoaded", function () {



    new Swiper(".Itemcarousel", {

        slidesPerView: 3,
        spaceBetween: 15,

        pagination: {
            el: ".swiper-pagination",
            clickable: true},
        breakpoints: {
            300:{slidesPerView: 3},
            640: { slidesPerView: 3 },
            768: { slidesPerView: 4 },
            1024: { slidesPerView: 4 }
        }

    });

    new Swiper(".mobilepimage", {

        slidesPerView: 1,
        spaceBetween: 15,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            dynamicBullets: true,
        },

    });


    }, );

    var swiper = new Swiper(".swiperr", {
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            dynamicBullets: true, // تست گزینه‌های دیگر
        },
    });



    new Swiper(".productimages", {

        slidesPerView: 5,
        spaceBetween: 15,

        pagination: {
            el: ".swiper-pagination",
            clickable: true},
        breakpoints: {
            300:{slidesPerView: 3},
            640: { slidesPerView: 3 },
            768: { slidesPerView: 4 },
            1024: { slidesPerView: 4 }
        }


});


