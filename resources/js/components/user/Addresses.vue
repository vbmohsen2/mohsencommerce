<template>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow space-y-6 font-sans">

        <h2 class="text-2xl font-bold mb-6">آدرس‌های شما</h2>

        <div v-if="addresses.length === 0" class="text-gray-500 text-center py-10">
            هیچ آدرسی ثبت نشده است.
        </div>

        <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2">
            <div
                v-for="(addr, index) in addresses"
                :key="index"
                class="border rounded p-4 shadow hover:shadow-lg transition cursor-default relative"
            >
                <template v-if="editIndex !== index">
                    <h3 class="text-lg font-semibold mb-2">{{ addr.city }}, {{ addr.province }}</h3>
                    <p class="text-gray-700 whitespace-pre-wrap">{{ addr.address }}</p>

                    <div class="mt-4 flex space-x-3 justify-end">
                        <button @click="startEditing(index)" class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                            ویرایش
                        </button>
                        <button @click="removeAddress(index)" class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                            حذف
                        </button>
                    </div>
                </template>

                <template v-else>
                    <input
                        v-model="editForm.city"
                        type="text"
                        placeholder="شهر"
                        class="w-full mb-2 border rounded px-3 py-2"
                    />
                    <input
                        v-model="editForm.province"
                        type="text"
                        placeholder="استان"
                        class="w-full mb-2 border rounded px-3 py-2"
                    />
                    <textarea
                        v-model="editForm.address"
                        rows="3"
                        placeholder="آدرس کامل"
                        class="w-full border rounded px-3 py-2 resize-none"
                    ></textarea>

                    <div class="mt-4 flex justify-end space-x-3">
                        <button @click="cancelEditing" class="px-3 py-1 text-sm bg-gray-400 text-white rounded hover:bg-gray-500">
                            لغو
                        </button>
                        <button @click="saveEditing" class="px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700">
                            ذخیره
                        </button>
                    </div>
                </template>
            </div>
        </div>

        <!-- دکمه افزودن آدرس جدید -->
        <div class="mt-6 text-center">
            <button @click="addNewAddress" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                افزودن آدرس جدید
            </button>
        </div>

    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import axios from 'axios'

const addresses = ref([])

const editIndex = ref(null)

const editForm = reactive({
    city: '',
    province: '',
    address: '',
})

const message = ref('')

onMounted(async () => {
    try {
        const res = await axios.get('/api/user/addresses')
        console.log(res)
        addresses.value = res.data.addresses || []
    } catch (e) {
        message.value = 'خطا در بارگذاری آدرس‌ها.'
    }
})

const startEditing = (index) => {
    editIndex.value = index
    Object.assign(editForm, addresses.value[index])
}

const cancelEditing = () => {
    editIndex.value = null
    editForm.city = ''
    editForm.province = ''
    editForm.address = ''
}

const saveEditing = async () => {
    try {
        if (!editForm.city.trim() || !editForm.province.trim() || !editForm.address.trim()) {
            alert('همه فیلدها باید پر شوند.')
            return
        }

        if (editIndex.value !== null) {
            addresses.value[editIndex.value] = { ...editForm }
        } else {
            addresses.value.push({ ...editForm })
        }

      consلهole.log( await axios.post('/user/addresses/update', {
            address: addresses.value,
        }))

        cancelEditing()
    } catch (error) {
        alert('خطا در ذخیره آدرس.')
    }
}

const removeAddress = async (index) => {
    if (!confirm('آیا مطمئن هستید که می‌خواهید این آدرس را حذف کنید؟')) return

    try {
        addresses.value.splice(index, 1)
        await axios.post('/user/addresses/update', {
            address: addresses.value,
        })
        if (editIndex.value === index) cancelEditing()
    } catch {
        alert('خطا در حذف آدرس.')
    }
}

const addNewAddress = () => {
    editIndex.value = addresses.value.length
    editForm.city = ''
    editForm.province = ''
    editForm.address = ''
}
</script>

<style scoped>
@media (max-width: 640px) {
    .grid {
        grid-template-columns: 1fr !important;
    }
}
</style>
