<template>

    <div class="flex flex-col w-full pt-4 px-4">
        <div class="space-x-2 w-full inline-flex    text-base ">
            <h2>پست ها</h2>
            <span class="px-2"><button  @click="goTonewPost" class="bg-gray-200 border px-2 rounded-md shadow-md ">پست جدید</button></span>
        </div>
        <div class="my-4  inline-flex justify-between">
            <div class="inline-flex justify-between space-x-2 items-center">

                <a href="" class="px-2" >
                    <span class="text-blue-500">همه پست ها</span>
                    ({{postStats.total}})
                </a>
                <a href="" class="px-2">
                    <span class="text-blue-500">پست های منتشر شده</span>
                    ({{postStats.published}})
                </a>
                <a href="">
                    <span class="text-blue-500">پست های منتشر نشده</span>
                    ({{postStats.unpublished}})
                </a>
            </div>
            <div>
                <select v-model="selectedCategory" @change="fetchPosts"
                        class="border p-2 rounded-md w-full appearance-none bg-white focus:outline-none focus:ring focus:border-blue-300">
                    <option value="">  دسته‌بندی ها  </option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>

            </div>
            <div>
                <input
                    v-model="search"
                    @input="onSearch"
                    type="text"
                    placeholder="جستجوی پست..."
                    class="w-full  p-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"
                />

            </div>

        </div>

        <!-- Header -->
        <div class="grid grid-cols-6 sm:gap-2 gap-16 space-y-2 font-bold bg-gray-200 p-4 items-center rounded-md shadow-md">
            <div>عنوان</div>
            <div>نویسنده</div>
            <div>دسته‌بندی</div>
            <div>تگ‌ها</div>
            <div>اسلاگ</div>
            <div>منتشر شده</div>
        </div>

        <!-- Rows -->

        <div
            v-for="post in posts.data"
            :key="post.id"

            class="grid grid-cols-2 sm:grid-cols-6 gap-x-4 gap-y-2 items-center
           p-4 border-b rounded-lg
           transition-all duration-200 ease-in-out
           hover:bg-indigo-50 hover:shadow-md hover:-translate-y-0.5"
        >
            <!-- عنوان -->
            <div class="truncate font-semibold text-gray-800 cursor-pointer" @click="goToPost(post.slug)">
                {{ post.title }}
            </div>

            <!-- نویسنده -->
            <div class="hidden sm:block text-sm text-gray-700">
                {{ post.user.name }}
            </div>

            <!-- دسته‌بندی -->
            <div class="hidden sm:block text-sm text-gray-600">
                {{ post.category.name }}
            </div>

            <!-- تگ‌ها -->
            <div class="flex flex-wrap gap-1">
      <span
          v-for="tag in post.post_tags"
          :key="tag.id"
          class="text-xs bg-indigo-100 text-indigo-800 px-2 py-0.5 rounded-full"
      >
        {{ tag.name }}
      </span>
            </div>

            <!-- اسلاگ -->
            <div class="hidden sm:block break-all text-xs text-gray-500">
                {{ post.slug }}
            </div>

            <!-- چک‌باکس -->
            <div @click.stop>
                <input
                    type="checkbox"
                    v-model="post.is_published"
                    :true-value="1"
                    :false-value="0"
                    class="h-4 w-4 text-indigo-600 rounded focus:ring-0"
                />
            </div>
        </div>

    </div>
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





</template>


<script setup>
import axios from 'axios'
import {computed, onMounted, ref, watch} from "vue";
import { useRouter } from 'vue-router'
import { debounce } from 'lodash'




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
onMounted(async () => {
    await fetchCategories()
    await fetchPosts()
})
</script>
