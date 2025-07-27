<template>
    <div >

        <!-- آیکون سرچ -->
        <div class="pt-2 px-2 z-50 relative">
            <button @click="open = true" class="search-button">
                <i class="fa fa-search text-[1.3rem] sm:text-base text-gray-500"></i>
            </button>
        </div>
        <!-- لایه پس‌زمینه تیره -->
        <transition name="fade">
            <div
                v-if="open"
                class="fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm z-40"
                @click="closeSearch"
            ></div>
        </transition>

        <!-- پنجره سرچ -->
        <transition name="slide-down">
            <div
                v-if="open"
                ref="overlay"
                class="fixed inset-x-0 top-0 z-50 bg-white shadow-lg border-b border-gray-300 rounded-b-xl"
            >
                <div class="w-full sm:max-w-2xl mx-auto px-4 py-6 sm:py-10">
                    <input
                        ref="searchInput"
                        v-model="searchQuery"
                        @input="handleSearch"
                        type="text"
                        placeholder="جستجو در پست‌ها..."
                        class="w-full border rounded-lg px-4 py-2 text-sm sm:text-base shadow focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition-all duration-300"
                        autofocus
                    />

                    <div v-if="results.length" class="mt-4 space-y-3 max-h-80 overflow-y-auto">
                        <a
                            v-for="post in results"
                            :key="post.id"
                            :href="`/blog/${post.slug}`"
                            class="flex items-center gap-3 p-2 rounded-lg hover:bg-indigo-50 transition-all duration-200"
                        >
                            <img
                                v-lazy="`/storage/images/blog/${post.slug}/${post.postmedia[0]?.file_path}`"
                                :src="`/storage/images/blog/${post.slug}/${post.postmedia[0]?.file_path}`"
                                class="w-14 h-14 sm:w-16 sm:h-16 object-cover rounded-md shrink-0"
                                :alt="post.title"
                            />
                            <div class="text-gray-700 text-sm sm:text-base font-medium truncate">
                                {{ post.title }}
                            </div>
                        </a>
                    </div>

                    <div v-else-if="searchQuery && !loading" class="mt-4 text-gray-500 text-sm text-center">
                        هیچ نتیجه‌ای یافت نشد.
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import {ref, onMounted, onBeforeUnmount, nextTick, watch} from 'vue'
import axios from 'axios'
import debounce from 'lodash/debounce'



const open = ref(false)
const searchQuery = ref('')
const results = ref([])
const loading = ref(false)
const overlay = ref(null)
const searchInput = ref(null)


const handleSearch = debounce(async () => {
    if (!searchQuery.value.trim()) {
        results.value = []
        return
    }

    loading.value = true
    try {
        const { data } = await axios.get(`/api/blog/search/?q=${searchQuery.value}`)
        results.value = data
        // console.log(data)
    } catch (err) {
        // console.error(err)
    } finally {
        loading.value = false
    }
}, 400)

const handleClickOutside = (e) => {
    const clickedInsideOverlay = overlay.value?.contains(e.target)
    const clickedSearchButton = e.target.closest('.search-button')

    if (!clickedInsideOverlay && !clickedSearchButton) {
        open.value = false
    }
}
const closeSearch = () => {
    open.value = false
    searchQuery.value = ''
    results.value = []
}
onMounted(() => {

        document.addEventListener('click', handleClickOutside)
          window.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeSearch()
         })

})
watch(open, async (newVal) => {
    if (newVal) {
        await nextTick() // منتظر بمان تا DOM به‌روز شود
        searchInput.value?.focus()
    }
})
onBeforeUnmount(() => {
    // document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
.slide-down-enter-active,
.slide-down-leave-active {
    transition: all 0.3s ease-out; /* زمان را کاهش دادم برای حس واکنش سریع‌تر */
}
.slide-down-enter-from {
    transform: translateY(-50%);
    opacity: 0;
}
.slide-down-enter-to {
    transform: translateY(0);
    opacity: 1;
}
.slide-down-leave-to {
    transform: translateY(-50%);
    opacity: 0;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease-in-out; /* کمی کوتاه‌تر و نرم‌تر */
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
.fade-enter-to,
.fade-leave-from {
    opacity: 1;
}

/* بهینه‌سازی ریسپانسیو */
input {
    padding: 0.6rem 1rem; /* تغییر اندازه و فضای داخلی برای تطبیق بهتر در سایز‌های کوچک‌تر */
    font-size: 0.9rem; /* تنظیم فونت برای بهتر دیده شدن در موبایل */
}

@media (max-width: 768px) {
    .w-full {
        padding: 1rem; /* فضای داخلی برای سازگاری در سایز‌های کوچک‌تر */
    }
    .search-button {
        font-size: 1rem; /* سایز آیکون کوچک‌تر برای موبایل */
    }
}

@media (max-width: 480px) {
    .search-button i {
        font-size: 0.8rem; /* آیکون کوچکتر */
    }
    .text-sm {
        font-size: 0.8rem; /* متن کوچکتر برای نمایشگرهای کوچک‌تر */
    }
}
</style>
