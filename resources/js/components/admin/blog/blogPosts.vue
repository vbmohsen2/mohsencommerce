<template>
    <div class="flex flex-col w-full pt-4 px-4">
        <!-- عنوان و فیلترها -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <h2 class="text-lg font-bold">پست‌ها</h2>
                <button
                    @click="goTonewPost"
                    class="bg-gray-200 border px-3 py-1 rounded-md shadow hover:bg-gray-300 transition"
                >
                    پست جدید
                </button>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <select
                    v-model="selectedCategory"
                    @change="fetchPosts"
                    class="border p-2 rounded-md bg-white focus:outline-none focus:ring focus:border-blue-300"
                >
                    <option value="">دسته‌بندی‌ها</option>
                    <option
                        v-for="category in categories"
                        :key="category.id"
                        :value="category.id"
                    >
                        {{ category.name }}
                    </option>
                </select>
                <input
                    v-model="search"
                    @input="onSearch"
                    type="text"
                    placeholder="جستجوی پست..."
                    class="p-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300 w-full"
                />
            </div>
        </div>

        <!-- فیلتر وضعیت -->
        <div class="flex flex-wrap gap-4 mt-4 text-sm">
            <a href="#" class="text-blue-600 hover:underline">
                همه پست‌ها ({{ postStats.total }})
            </a>
            <a href="#" class="text-blue-600 hover:underline">
                منتشر شده ({{ postStats.published }})
            </a>
            <a href="#" class="text-blue-600 hover:underline">
                منتشر نشده ({{ postStats.unpublished }})
            </a>
        </div>

        <!-- جدول (فقط در دسکتاپ) -->
        <div class="hidden sm:grid grid-cols-7 gap-2 font-bold bg-gray-200 p-4 mt-6 rounded-md shadow">
<!--            <div class="">No</div>-->
            <div >عنوان</div>
            <div>نویسنده</div>
            <div>دسته‌بندی</div>
            <div>تگ‌ها</div>
            <div>اسلاگ</div>
            <div>منتشر شده</div>
            <div></div>
        </div>

        <!-- نمایش پست‌ها -->
        <div v-for="post in posts.data" :key="post.id">
            <!-- برای موبایل: کارت -->
            <div class="sm:hidden border p-4 rounded-lg mt-4 shadow hover:shadow-md transition">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="font-semibold text-base text-indigo-700 cursor-pointer" @click="goToPost(post.slug)">
                        {{ post.title }}
                    </h3>
                    <input
                        type="checkbox"
                        v-model="post.is_published"
                        :true-value="1"
                        :false-value="0"
                        class="h-4 w-4 text-indigo-600"
                    />
                </div>

                <div class="text-sm text-gray-700 mb-1">✍️ {{ post.user.name }}</div>
                <div class="text-sm text-gray-600 mb-1">📁 {{ post.category.name }}</div>
                <div class="text-sm text-gray-500 break-words mb-2">🔗 {{ post.slug }}</div>

                <div class="flex flex-wrap gap-1 mt-2">
        <span
            v-for="tag in post.post_tags"
            :key="tag.id"
            class="text-xs bg-indigo-100 text-indigo-800 px-2 py-0.5 rounded-full"
        >
            {{ tag.name }}
        </span>
                </div>

                <!-- 🗑️ دکمه حذف -->
                <div class="mt-4 text-end">
                    <button
                        @click="deletePost(post.id)"
                        class="inline-flex items-center gap-1 text-xs px-3 py-1 bg-red-100 text-red-700 hover:bg-red-200 rounded-full transition"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0a1 1 0 011-1h4a1 1 0 011 1m-7 0h8"/>
                        </svg>
                        حذف
                    </button>
                </div>
            </div>


            <!-- برای دسکتاپ: جدول -->
            <div
                class="hidden sm:grid grid-cols-7 gap-3 items-center p-4 border-b rounded-lg transition hover:bg-indigo-50 hover:shadow-md hover:-translate-y-0.5"
            >
<!--                <div class="text-xs min-w-fit">{{post.id}}</div>-->
                <div  class="text-sm font-medium text-gray-800 leading-snug break-words line-clamp-3 cursor-pointer"
                      @click="goToPost(post.slug)">
                    {{ post.title }}
                </div>
                <div class="text-sm text-gray-700">
                    {{ post.user.name }}
                </div>
                <div class="text-sm text-gray-600">
                    {{ post.category.name }}
                </div>
                <div class="flex flex-wrap gap-1">
          <span
              v-for="tag in post.post_tags"
              :key="tag.id"
              class="text-xs bg-indigo-100 text-indigo-800 px-2 py-0.5 rounded-full"
          >
            {{ tag.name }}
          </span>
                </div>
                <div class="break-words text-xs text-gray-500">
                    {{ post.slug }}
                </div>

                <div @click.stop>
                    <input
                        type="checkbox"
                        v-model="post.is_published"
                        :true-value="1"
                        :false-value="0"
                        class="h-4 w-4 text-indigo-600 focus:ring-0"
                    />


                </div>
                <div>
                    <button
                        @click="deletePost(post.id)"
                        class="flex items-center gap-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-full shadow transition-all duration-200 text-sm"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0a1 1 0 011-1h4a1 1 0 011 1m-7 0h8" />
                        </svg>
                        حذف
                    </button>
                </div>
            </div>

        </div>

        <!-- صفحه‌بندی -->
        <div class="flex gap-2 mt-6 flex-wrap justify-center">
            <button
                v-for="page in posts.last_page"
                :key="page"
                @click="goToPage(page)"
                :class="[
          'px-3 py-1 border rounded',
          posts.current_page === page
            ? 'bg-blue-500 text-white'
            : 'bg-white hover:bg-gray-100'
        ]"
            >
                {{ page }}
            </button>
        </div>
    </div>
</template>




<script setup>
import axios from 'axios'
import {computed, onMounted, ref, watch} from "vue";
import { useRouter } from 'vue-router'
import { debounce } from 'lodash'
import {useToast} from "vue-toast-notification";




const router = useRouter()
const categories = ref([])
const posts = ref({})
const currentPage = ref(1)
const search = ref('')
const selectedCategories = ref([])
const selectedCategory=ref('')
const fetchCategories = async () => {
    const res = await axios.get('/api/blog/categories')
    categories.value = res.data
}

const fetchPosts = async () => {
    const res = await axios.get('/api/blog/postsvue', {
        params: {
            categories: selectedCategory.value,
            page: currentPage.value,
            search: search.value,


        }
    })
    posts.value = res.data

}

const goToPage = (page) => {
    currentPage.value = page
    fetchPosts()
}

const onSearch = debounce(() => {

    currentPage.value = 1
    fetchPosts()
},500)
watch(selectedCategories, () => {
    currentPage.value = 1
    fetchPosts()
})

const postStats = computed(() => {
    const postList = posts.value.data || [] // احتیاط برای مواقعی که posts هنوز لود نشده

    const total = postList.length
    const published = postList.filter(post => post.is_published == 1).length
    const unpublished = total - published

    return {
        total,
        published,
        unpublished
    }
})

function goToPost (slug) {
    // اگر روتری داری که پست را بر اساس اسلاگ نشان دهد، نامش را جایگزین کن
    router.push({ name: 'posts.edit', params: { slug } })
}
function goTonewPost(){
    router.push({name:'posts.new'})
}

const deletePost = async (id) => {
    if (confirm("آیا مطمئن هستید که می‌خواهید این پست را حذف کنید؟")) {
        try {
            await axios.delete(`/api/blog/deletepost/${id}`);
            const $toast = useToast();
            let instance = $toast.error("پست حذف شد");
            // یا مثلاً رفرش کن یا از لیست بردار
        } catch (error) {
            const $toast = useToast();
            let instance = $toast.error("خطا در حذف پست");
        }
    }
    await fetchPosts()
};
onMounted(async () => {
    await fetchCategories()
    await fetchPosts()
})
</script>
