<template>
    <div class="space-y-4">
        <!-- Search Input -->
        <input
            v-if="showSearchInput"
            v-model="searchQuery"
            type="text"
            placeholder="جستجوی دسته‌بندی..."
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
        />

        <ul class="space-y-2">
            <li
                v-for="category in filteredCategories"
                :key="category.id"
                :class="[
    'bg-white shadow-sm flex rounded-md p-3 border border-gray-400 cursor-pointer',
    selected === category.id ? 'ring-1 ring-blue-400 border-blue-500' : ''
  ]"
            >
                <div class="flex justify-between items-center w-full">
                    <!-- ناحیه قابل کلیک (نام دسته) -->
                    <div
                        class="flex-1 flex gap-2 items-center text-gray-800"
                        @click="selectCategory(category.id)"
                    >
      <span
          :class="selected === category.id ? 'text-blue-700 font-semibold' : ''"
          class="text-sm sm:text-base font-medium"
      >
        {{ category.name }}
      </span>
                    </div>

                    <!-- دکمه باز/بسته -->
                    <button
                        v-if="category.children_recursive?.length"
                        @click.stop="category.open = !category.open"
                        class="ml-4 text-gray-600 hover:text-black text-xl font-bold transition"
                    >
                        {{ category.open ? '−' : '+' }}
                    </button>
                </div>

                <transition name="fade">
                    <div
                        v-if="category.open && category.children_recursive?.length"
                        class="mt-2 ms-4 border-s-2 border-gray-200 ps-3"
                    >
                        <category-filterforaddporduct
                            :categories="category.children_recursive"
                            :show-search-input="false"
                            :selected="selected"
                            @update:selected="emitSelected"
                        />
                    </div>
                </transition>
            </li>
        </ul>
    </div>
</template>

<script setup>
import {reactive, ref, computed} from 'vue'
import CategoryTree from './CategoryTree.vue'

const props = defineProps({
    categories: Array,
    selected: [Number, null],
    showSearchInput: {
        type: Boolean,
        default: true
    }
})
const emit = defineEmits(['update:selected'])

const emitSelected = (val) => {
    emit('update:selected', val)
}

const selectCategory = (id) => {

    emitSelected(id)
}

// اضافه کردن ویژگی open به‌صورت بازگشتی
const addOpenRecursive = (categories) => {
    return categories.map((cat) => ({
        ...cat,
        open: false,
        children_recursive: cat.children_recursive
            ? addOpenRecursive(cat.children_recursive)
            : [],
    }))
}

const categoriesReactive = reactive(addOpenRecursive(props.categories))

// ----------------- SEARCH اضافه شد -----------------

const searchQuery = ref('')

// تابع بازگشتی برای فیلتر دسته‌بندی‌ها بر اساس جستجو
const filterCategories = (categories, query) => {


    return categories
        .map(category => {
            const children = category.children_recursive
                ? filterCategories(category.children_recursive, query)
                : [];

            const match = category.name.toLowerCase().includes(query.toLowerCase());
            console.log(children)
            if (match || children.length > 0) {
                return {
                    ...category,
                    open: true,
                    children_recursive: children
                };
            }

            return null;
        })
        .filter(Boolean);
};



const filteredCategories = computed(() => {
    if (!searchQuery.value) return categoriesReactive   ;
    return filterCategories(openAllCategories(categoriesReactive), searchQuery.value);
});

const openAllCategories = (categories) => {
    return categories.map(category => ({
        ...category,
        open: true,
        children_recursive: category.children_recursive ? openAllCategories(category.children_recursive) : []
    }))
};
//
// console.log("c", categoriesReactive)
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: all 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(-5px);
}
</style>
