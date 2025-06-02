<template>
    <draggable
        v-model="categories"
        item-key="id"
        :group="{ name: 'nested' }"
        :fallbackOnBody="true"
        :animation="200"
    >
        <template #item="{ element: category }">
            <div class="mb-2 p-3 border rounded shadow-sm bg-white">
                {{category.parent_id}}
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <button @click="category.open = !category.open">
                            {{ category.open ? '−' : '+' }}
                        </button>
                        <div v-if="category.editing">
                            <input v-model="category.name" class="border p-1 rounded" />
                            <button @click="saveCategory(category)">💾</button>
                            <button @click="cancelEdit(category)">❌</button>
                        </div>
                        <div v-else class="flex items-center gap-2">
                            <button @click="category.editing = true">✏️</button>
                            <span>{{ category.name }}</span>
                        </div>
                    </div>
                </div>

                <transition name="fade">
                    <div v-if="category.open && category.children_recursive?.length" class="pl-4 mt-2 border-s-2 border-gray-200">
                        <ChildCategoryTree :categories="category.children_recursive" />
                    </div>
                </transition>
            </div>
        </template>
    </draggable>
</template>

<script setup>
import { ref, watch } from 'vue'
import draggable from 'vuedraggable'
import ChildCategoryTree from './ChildCategoryTree.vue'

const props = defineProps({
    categories: Array
})

const categories = ref([])

watch(
    () => props.categories,
    (newVal) => {
        categories.value = newVal
    },
    { immediate: true }
)

function saveCategory(category) {
    category.originalName = category.name
    category.editing = false
    // اگر بخوای ذخیره واقعی سمت سرور بشه:
    // axios.put(`/api/categories/${category.id}`, { name: category.name })
}

function cancelEdit(category) {
    category.name = category.originalName
    category.editing = false
}





</script>
