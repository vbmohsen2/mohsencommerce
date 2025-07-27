import './bootstrap';
import Swiper from 'swiper/bundle';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'vue-tree-dnd'
import VueLazyLoad from 'vue3-lazyload'


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
import users from './components/admin/user/user.vue'
import orders from './components/admin/orders/orders.vue'
import categoryProducts  from './components/products/CategoryProducts.vue'
import romanoProductPage from './components/products/romano/romanoProductPage.vue'
import searchposts from './components/blog/searchposts.vue'
import router from "./router";

const app = createApp({});
const headerApp=createApp({});

app.component('category-filter', CategoryFilter);
app.component('CategoryTreeWithEdit',CategoryTreeWithEdit);
app.component('addProductPage',addProductPage)
app.component('attributesedit',attributesedit)
app.component('blogCategoryEdit',blogCategoryEdit)
app.component('blogPosts',blogPosts)
app.component('editProduct',editProduct)
app.component('users', users)
app.component('orders',orders)
app.component('category-products', categoryProducts);
app.component('romanoProductPage',romanoProductPage)
app.component('searchposts',searchposts)

// app.component('CategoryList', CategoryList);
headerApp.use(VueLazyLoad)
headerApp.component('productsearch',search)
headerApp.component('searchposts',searchposts)


app.use(router)
app.mount('#app');
headerApp.mount('#headerapp')


document.addEventListener("DOMContentLoaded", function () {



    new Swiper(".Itemcarousel", {

        slidesPerView: 3,
        spaceBetween: 6,

        pagination: {
            el: ".swiper-pagination",
            clickable: true},
        breakpoints: {
            300:{slidesPerView: 2},
            640: { slidesPerView: 2.5 },
            768: { slidesPerView: 3 },
            1024: { slidesPerView: 4 }
        }

    });

    const swiper = new Swiper(".mobilepimage", {
        slidesPerView: 1,
        spaceBetween: 15,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            dynamicBullets: true,
        },
        autoplay: {
            delay: 3000, // مدت زمان هر اسلاید به میلی‌ثانیه
            disableOnInteraction: false,
        },
        on: {
            autoplayTimeLeft(swiper, time, progress) {
                const circle = document.getElementById('progress-circle');
                if (circle) {
                    const circumference = 100;
                    const offset = circumference * (1 - progress);
                    circle.style.strokeDashoffset = offset;
                }
            },
            slideChange() {
                // ریست کردن دایره وقتی اسلاید عوض میشه
                const circle = document.getElementById('progress-circle');
                if (circle) {
                    circle.style.transition = 'none';  // غیرفعال کردن انیمیشن برای ریست سریع
                    circle.style.strokeDashoffset = 100;  // کامل خالی کردن دایره
                    // کمی بعد انیمیشن رو دوباره فعال کن
                    setTimeout(() => {
                        circle.style.transition = 'stroke-dashoffset 0.1s linear';
                    }, 50);
                }
            }
        }
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


