<template>
    <ul class="space-y-2">
        <li
            v-for="category in categoriesReactive"
            :key="category.id"
            class="bg-white shadow-sm rounded-md p-3 border border-gray-400"
        >
            <div class="flex justify-between items-center">
                <label class="flex gap-2 items-center text-gray-800">
                    <input
                        type="checkbox"
                        :value="category.id"
                        :checked="selected.includes(category.id)"
                        @change="toggleCategory(category.id)"
                        class="accent-blue-500 w-4 h-4"
                    />
                    <span class="text-sm sm:text-base font-medium">{{ category.name }}</span>
                </label>

                <button
                    v-if="category.children_recursive?.length"
                    @click="category.open = !category.open"
                    class="text-gray-600 hover:text-black text-xl font-bold transition"
                >
                    {{ category.open ? '−' : '+' }}
                </button>
            </div>

            <transition name="fade">
                <div
                    v-if="category.open && category.children_recursive?.length"
                    class="mt-2 ms-4 border-s-2 border-gray-200 ps-3"
                >
                    <CategoryTree
                        :categories="category.children_recursive"
                        :selected="selected"
                        @update:selected="emitSelected"
                    />
                </div>
            </transition>
        </li>
    </ul>
</template>

<script setup>
import {  reactive } from 'vue'
import CategoryTree from './CategoryTree.vue'

const props = defineProps({
    categories: Array,
    selected: Array,
})
const emit = defineEmits(['update:selected'])

const emitSelected = (val) => {
    emit('update:selected', val)
}

const toggleCategory = (id) => {
    const index = props.selected.indexOf(id)
    if (index > -1) {
        emitSelected([...props.selected.filter((i) => i !== id)])
    } else {
        emitSelected([...props.selected, id])
    }
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
