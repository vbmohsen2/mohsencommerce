<template>
    <transition name="slide-down">
        <div
            v-if="show"
            class="fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-start pt-16 px-4 overflow-auto"
            @click.self="close"
        >
            <div
                :class="{ 'opacity-50 pointer-events-none': loading }"
                class="bg-white rounded-md w-full max-w-md p-4 shadow-lg"
                @click.stop
            >
                <button
                    @click="close"
                    class="mb-4 text-right w-full font-semibold text-gray-600 hover:text-gray-900"
                    aria-label="بستن فیلترها"
                >
                    ✕
                </button>


                <!-- دکمه پاک کردن همه فیلترها -->
                <div v-if="hasSelectedFilters && !loading" class="mb-4 flex justify-between items-center">
                    <h3 class="font-semibold text-lg">فیلترها</h3>
                    <button
                        @click="clearAll"
                        class="text-red-600 hover:text-red-800 text-sm"
                    >
                        پاک کردن همه
                    </button>
                </div>
                <!-- برند -->
                <template v-if="Array.isArray(modelValue.brand)">
            <span
                v-for="brand in modelValue.brand"
                :key="'brand-' + brand"
                class="flex items-center bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm"
            >
              {{ brand }}
              <button
                  @click="removeFilterValue('brand', brand)"
                  class="mr-1 text-blue-600 hover:text-blue-900"
                  aria-label="حذف برند"
                  :disabled="loading"
              >
                ×
              </button>
            </span>
                </template>


                <template v-for="filter in filters" :key="'tag-' + filter.name">
            <span
                v-if="Array.isArray(modelValue[filter.name])"
                v-for="option in modelValue[filter.name]"
                :key="filter.slug + '-' + option"
                class="flex items-center bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm"
            >
              {{ option }}
              <button
                  @click="removeFilterValue(filter.name, option)"
                  class="mr-1 text-green-600 hover:text-green-900"
                  aria-label="حذف فیلتر"
                  :disabled="loading"
              >
                ×
              </button>
            </span>
                </template>


                <details  >
                    <summary class="font-bold mb-2 cursor-pointer">برند</summary>
                    <div class="space-y-2 mt-2">
                        <label v-for="brand in brands" :key="brand" class="flex items-center space-x-2 rtl:space-x-reverse">
                            <input
                                type="checkbox"
                                :value="brand"
                                :checked="Array.isArray(modelValue.brand) && modelValue.brand.includes(brand)"
                                @change="toggleFilter('brand', brand)"
                                :disabled="loading"
                                class="cursor-pointer"
                            />
                            <span>{{ brand }}</span>
                        </label>
                    </div>
                </details>

                <div v-for="filter in filters" :key="filter.slug" class="mt-4">
                    <details>
                        <summary class="font-bold cursor-pointer">{{ filter.name }}</summary>
                        <div class="space-y-2 mt-2">
                            <label v-for="option in filter.options" :key="option" class="flex items-center space-x-2 rtl:space-x-reverse">
                                <input
                                    type="checkbox"
                                    :value="option"
                                    :checked="Array.isArray(modelValue[filter.name]) && modelValue[filter.name].includes(option)"
                                    @change="toggleFilter(filter.name, option)"
                                    :disabled="loading"
                                    class="cursor-pointer"
                                />
                                <span>{{ option }}</span>
                            </label>
                        </div>
                    </details>
                </div>
            </div>
        </div>

    </transition>
</template>

<script setup>
import {computed} from "vue";

const props = defineProps({
    filters: Array,
    brands: Array,
    modelValue: Object,
    loading: Boolean,
    show: Boolean,
})

const emit = defineEmits(['update:modelValue', 'close'])

function toggleFilter(key, option) {
    const current = Array.isArray(props.modelValue[key]) ? props.modelValue[key] : []
    const updated = current.includes(option)
        ? current.filter(o => o !== option)
        : [...current, option]

    emit('update:modelValue', {
        ...props.modelValue,
        [key]: updated,
    })
}

const hasSelectedFilters = computed(() => {
    if (!props.modelValue) return false
    return Object.values(props.modelValue).some(val => Array.isArray(val) && val.length > 0)
})

function clearAll() {
    if (props.loading) return
    emit('update:modelValue', {})
}
function removeFilterValue(key, option) {
    if (props.loading) return
    if (!props.modelValue[key]) return
    const updated = props.modelValue[key].filter(o => o !== option)

    emit('update:modelValue', {
        ...props.modelValue,
        [key]: updated,
    })
}
function close() {
    emit('close')
}
</script>

<style scoped>
.slide-down-enter-active,
.slide-down-leave-active {
    transition: transform 0.3s ease, opacity 0.3s ease;
}
.slide-down-enter-from,
.slide-down-leave-to {
    transform: translateY(-20px);
    opacity: 0;
}
.slide-down-enter-to,
.slide-down-leave-from {
    transform: translateY(0);
    opacity: 1;
}
</style>
