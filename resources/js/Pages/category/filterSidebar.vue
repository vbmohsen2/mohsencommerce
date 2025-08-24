<script setup>
import {computed} from "vue";

const props = defineProps({
    filters: Array,
    brands: Array,
    modelValue: Object,
    disabled: Boolean, // جدید
})

const emit = defineEmits(['update:modelValue'])

const hasSelectedFilters = computed(() => {
    if (!props.modelValue) return false
    return Object.values(props.modelValue).some(val => Array.isArray(val) && val.length > 0)
})

function toggleFilter(key, option) {
    if (props.disabled) return // غیرفعال بودن فیلترها

    const current = Array.isArray(props.modelValue[key]) ? props.modelValue[key] : []
    const updated = current.includes(option)
        ? current.filter(o => o !== option)
        : [...current, option]

    emit('update:modelValue', {
        ...props.modelValue,
        [key]: updated
    })
}

function removeFilterValue(key, option) {
    if (props.disabled) return

    if (!props.modelValue[key]) return
    const updated = props.modelValue[key].filter(o => o !== option)

    emit('update:modelValue', {
        ...props.modelValue,
        [key]: updated
    })
}

function clearAll() {
    if (props.disabled) return
    emit('update:modelValue', {})
}
</script>

<template>
    <div :class="{ 'opacity-50 pointer-events-none': disabled }" class="filter-container p-4  bg-white rounded shadow border border-gray-200">

        <!-- عنوان و دکمه پاک کردن همه -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-lg">فیلترها</h3>
            <button
                v-if="hasSelectedFilters && !disabled"
                @click="clearAll"
                class="text-red-600 hover:text-red-800 text-sm"
            >
                پاک کردن همه
            </button>
        </div>

        <!-- نمایش فیلترهای انتخاب شده -->
        <div v-if="hasSelectedFilters" class="mb-4 flex flex-wrap gap-2">
            <!-- برندها -->
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
              :disabled="disabled"
          >
            ×
          </button>
        </span>
            </template>

            <!-- ویژگی‌ها -->
            <template v-for="filter in filters" :key="'tag-' + filter.slug">
        <span
            v-if="Array.isArray(modelValue[filter.name])"
            v-for="option in modelValue[filter.name]"
            :key="filter.slug + '-' + option"
            class="flex items-center bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm"
        >
          {{ option }}
          <button
              @click="removeFilterValue(filter.slug, option)"
              class="mr-1 text-green-600 hover:text-green-900"
              aria-label="حذف فیلتر"
              :disabled="disabled"
          >
            ×
          </button>
        </span>
            </template>
        </div>

        <!-- برند -->
        <details  class="mb-3 border rounded p-3">
            <summary
                class="cursor-pointer font-medium select-none flex justify-between items-center"
            >
                برند
                <svg
                    class="w-4 h-4 transition-transform duration-300 group-open:rotate-180"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </summary>
            <div class="mt-2 space-y-1 max-h-40 overflow-auto">
                <label
                    v-for="brand in brands"
                    :key="brand"
                    class="flex items-center gap-2 cursor-pointer"
                >
                    <input
                        type="checkbox"
                        :value="brand"
                        :checked="Array.isArray(modelValue.brand) && modelValue.brand.includes(brand)"
                        @change="toggleFilter('brand', brand)"
                        :disabled="disabled"
                        class="cursor-pointer"
                    />
                    {{ brand }}
                </label>
            </div>
        </details>

        <!-- ویژگی‌ها -->
        <div v-for="filter in filters" :key="filter.slug" class="mb-3">
            <details  class="border rounded p-3">
                <summary
                    class="cursor-pointer font-medium select-none flex justify-between items-center"
                >
                    {{ filter.name }}
                    <svg
                        class="w-4 h-4 transition-transform duration-300 group-open:rotate-180"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </summary>
                <div class="mt-2 space-y-1 max-h-40 overflow-auto">
                    <label
                        v-for="option in filter.options"
                        :key="option"
                        class="flex items-center gap-2 cursor-pointer"
                    >
                        <input
                            type="checkbox"
                            :value="option"
                            :checked="Array.isArray(modelValue[filter.slug]) && modelValue[filter.slug].includes(option)"
                            @change="toggleFilter(filter.name, option)"
                            :disabled="disabled"
                            class="cursor-pointer"
                        />
                        {{ option }}
                    </label>
                </div>
            </details>
        </div>
    </div>
</template>

<style scoped>
/* حذف marker پیش‌فرض details */
details summary::-webkit-details-marker {
    display: none;
}
details summary {
    list-style: none;
}
/* انیمیشن چرخش فلش */
details[open] > summary svg {
    transform: rotate(180deg);
    transition: transform 0.3s ease;
}
</style>
