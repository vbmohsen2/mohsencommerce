<template>
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-6">ایجاد محصول جدید</h1>

        <form @submit.prevent="submitForm" class="space-y-8">
            <div class="border p-2 space-x-2 space-y-2">
                <span class="px-2">نام محصول: <input v-model="productName" class=" border px-2 py-1 rounded" type="text"></span>
                <span>اسلاگ : <input v-model="productSlug" class=" border px-2 py-1 rounded" type="text"></span>
            </div>
            <div class="border p-2">
                <span>تعداد: <input v-model="productStock" class=" border px-2 py-1 rounded" type="text"></span>
            </div>
            <div class="border p-2">
                <span>فعال: <input v-model="productIsActive" class=" border px-2 py-1 rounded" type="checkbox"></span>
            </div>

            <!-- دسته‌بندی -->
            <CategorySelector
                :categories="categories"
                :show-search-input="true"
                :selected="selectedCategory"
                @update:selected="selectedCategory = $event"
            />

            <!-- عکس‌ها و توضیحات -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- عکس‌ها -->
                <div class="space-y-6">

                    <!-- Thumbnail -->
                    <div class="border border-gray-300 rounded-md p-4">
                        <label class="block text-gray-700 font-semibold mb-2">عکس شاخص (Thumbnail)</label>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                            <input
                                type="file"
                                @change="handleThumbnailUpload"
                                accept="image/*"
                                class="file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            />
                            <div v-if="thumbnailPreview" class="w-24 h-24 rounded overflow-hidden border">
                                <img :src="thumbnailPreview" alt="پیش‌نمایش" class="w-full h-full object-cover"/>
                            </div>
                        </div>
                    </div>

                    <!-- Main Image -->
                    <div class="border border-gray-300 rounded-md p-4">
                        <label class="block text-gray-700 font-semibold mb-2">عکس اصلی (Main Image)</label>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                            <input
                                type="file"
                                @change="handleMainImageUpload"
                                accept="image/*"
                                class="file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100"
                            />
                            <div v-if="mainImagePreview" class="w-24 h-24 rounded overflow-hidden border">
                                <img :src="mainImagePreview" alt="پیش‌نمایش" class="w-full h-full object-cover"/>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery -->
                    <div class="border border-gray-300 rounded-md p-4">
                        <label class="block text-gray-700 font-semibold mb-2">سایر عکس‌ها:</label>

                        <div class="flex flex-wrap gap-3 mb-3">
                            <div
                                v-for="(img, index) in galleryPreviews"
                                :key="index"
                                class="relative w-24 h-24 rounded-lg overflow-hidden border border-gray-300 shadow-sm"
                            >
                                <img :src="img" class="w-full h-full object-cover transition"/>
                                <button
                                    type="button"
                                    @click="removeGalleryImage(index)"
                                    class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-700"
                                >
                                    ✕
                                </button>
                            </div>
                        </div>

                        <label
                            for="galleryInput"
                            class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg cursor-pointer hover:bg-blue-700 transition w-fit"
                        >
                            افزودن عکس جدید
                        </label>
                        <input
                            id="galleryInput"
                            type="file"
                            multiple
                            accept="image/*"
                            @change="handleGalleryChange"
                            class="hidden"
                        />
                    </div>
                </div>

                <!-- ویرایشگر Quill -->
                <div class="col-span-full w-full border border-gray-300 rounded-md p-4">
                    <label class="block text-gray-700 font-semibold mb-2">توضیحات محصول</label>
                    <div class="w-full">
                        <QuillEditor
                            theme="snow" toolbar="full"
                            v-model:content="prodcutdesription"
                            content-type="html"
                            class="w-full min-h-[300px] max-h-[500px] overflow-auto"
                        />
                    </div>
                </div>
                {{ prodcutdesription }}
                <div class="border p-2">
                    <p>sku: <input v-model="productsku" class=" border px-2 py-1 rounded" type="text"></p>
                </div>
                <div class="border p-2">
                    <p>برند: <input v-model="productBrand" class=" border px-2 py-1 rounded" type="text"></p>
                </div>
                <div class="border p-2">
                    <p>وزن: <input v-model="productWeight" class=" border px-2 py-1 rounded" type="text"> کیلوگرم</p>
                </div>
                <div class="border p-2">
                    <span>قیمت: <input v-model="productPrice" class=" border px-2 py-1 rounded"
                                       type="text"> تومان</span>
                </div>
                <div class="border p-2">
                    <span>تخفیف: <input v-model="productDiscount" class=" border px-2 py-1 rounded"
                                        type="text"> تومان</span>
                </div>
                <div class="flex flex-col border p-2">
                    <p class="text-2xl">خصوصیات</p>
                    <!-- نمایش ویژگی‌ها از داده‌ها -->
                    <div
                        v-for="(attributeGroup, groupIndex) in productattributes"
                        :key="groupIndex"
                        class="border p-4 rounded-md shadow-sm bg-white space-y-3"
                    >
                        <div v-for="(item, index) in attributeGroup" :key="index">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                {{ item.name }}:
                            </label>

                            <select
                                v-if="item.input_type==='select'"
                                v-model="formValues[item.name]"
                                class="w-full border px-2 py-1 rounded text-center"
                            >
                                <option v-for="(option, i) in item.options" :key="i" class="text-center"
                                        :value="option">
                                    {{ option }}
                                </option>
                            </select>

                            <input
                                v-else
                                type="text"
                                v-model="formValues[item.name]"
                                class="w-full border px-2 py-1 rounded"
                            />
                        </div>
                    </div>

                    <!-- ویژگی‌های اضافه شده توسط کاربر -->
                    <div
                        v-for="(value, key, index) in extraFields"
                        :key="'extra_' + index"
                        class="col-span-1 md:col-span-2 flex flex-col md:flex-row gap-2 items-start"
                    >
                        <input
                            type="text"
                            v-model="extraFields[key].name"
                            placeholder="نام ویژگی"
                            class="border px-2 py-1 rounded w-full md:w-1/2"
                        />:
                        <input
                            type="text"
                            v-model="extraFields[key].value"
                            placeholder="مقدار"
                            class="border px-2 py-1 rounded w-full md:w-1/2"
                        />

                    </div>
                    <button
                        type="button"
                        @click="addExtraField"
                        class="bg-blue-100 text-center my-2"
                    >
                        + افزودن ویژگی جدید
                    </button>
                </div>

                <!-- دکمه‌ها -->
                <div class="flex justify-between items-center pt-4">


                </div>

            </div>
            <div v-if="formError.length" class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-4">
                <ul class="list-disc pl-5">
                    <li v-for="(error, index) in formError" :key="index">
                        <strong>{{ error.field }}:</strong> {{ error.message }}
                    </li>
                </ul>
            </div>
            <!-- دکمه ثبت -->
            <div class=" w-full mt-6">
                <button type="submit"
                        class="px-6 py-2 w-full text-center bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    ذخیره محصول
                </button>
            </div>
        </form>

        <!-- نمایش دسته‌بندی انتخاب شده -->
        <!--        <div v-if="selectedCategory" class="mt-8 p-4 bg-green-100 border rounded">-->
        <!--            <strong>دسته‌بندی انتخاب شده:</strong> {{ selectedCategory }}-->
        <!--        </div>-->
    </div>
</template>


<script setup>
import {computed, onMounted, reactive, ref, watch} from 'vue'
import CategorySelector from './CategoryFilterforaddporduct.vue'
import axios from "axios";

import {QuillEditor} from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import 'quill/dist/quill.core.css'

import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const props = defineProps({
    categories: Array,
})

const thumbnail = ref(null)
const mainImage = ref(null)
const galleryImages = ref([])

const thumbnailPreview = ref(null)
const mainImagePreview = ref(null)
const galleryPreviews = ref([])
const uploadProgress = ref(0)
const selectedCategory = ref(null)
const prodcutdesription = ref()
const productattributes = ref([])
const formValues = reactive({})
const extraFields = reactive([])
const productsku = ref();
const productBrand = ref();
const productPrice = ref();
const productWeight = ref()
const productName = ref()
const productDiscount = ref()
const productStock = ref()
const productIsActive = ref()
const formError = ref([]);
const productSlug=ref();
// محدودیت تعداد و فرمت مجاز
const MAX_IMAGES = 20
const ALLOWED_FORMATS = ['image/jpeg', 'image/png', 'image/webp']


watch(selectedCategory, (newVal, oldVal) => {
    handleCategoryChange(newVal)
})
watch(productName,(newVal,oldVal)=>{
    handleSlug(newVal)
})
const handleCategoryChange = async (category) => {

    try {
        const res = await axios.post("/api/categories/attributes", { data: category });

        // اگر پاسخ معتبر نبود یا آرایه خالی بود


            productattributes.value = res.data;

    } catch (error) {
        // اگر کد 500 یا هر خطای دیگری رخ داد
        // console.error("خطا در دریافت اطلاعات:", error);
        productattributes.value = []; // آرایه رو کامل خالی کن
    }


}
const addExtraField = () => {

    extraFields.push({
        name: '',
        value: ''
    })
    if (extraFields.length > 0) {
        formError.value = formError.value.filter(error => error.field !== 'extra');
    }

}
const handleSlug=async (newVal) => {

    let slug
    try {
        slug= await axios.post("/slugify", {data:newVal});
        slug = slug.data.slug;
    } catch (err) {
        alert(err);
        console.error(err);
    }
    productSlug.value=slug

}
const handleThumbnailUpload = async (e) => {
    const file = e.target.files[0]
    thumbnail.value = await compressImage(file, "thumb");
    thumbnailPreview.value = URL.createObjectURL(file)
}


// const loging = () => {
//     const result = []
//
//     for (const [key, value] of Object.entries(formValues)) {
//         result.push({ name: key, value })
//     }
//
//     console.log(JSON.stringify(result, null, 2))
// }
const handleMainImageUpload = async (e) => {
    const file = e.target.files[0]

    const compressedFile = await compressImage(file, "main");
    mainImage.value = compressedFile
    mainImagePreview.value = URL.createObjectURL(compressedFile)
}

// اضافه کردن تصاویر گالری
// اضافه کردن تصاویر گالری با فشرده سازی
const handleGalleryChange = async (event) => {
    const files = Array.from(event.target.files);

    if (galleryPreviews.value.length + files.length > MAX_IMAGES) {
        alert(`حداکثر ${MAX_IMAGES} عکس میتوانید اضافه کنید.`);
        return;
    }

    for (const file of files) {
        if (!ALLOWED_FORMATS.includes(file.type)) {
            alert('فقط فرمت‌های jpg, jpeg, png, webp مجاز هستند.');
            continue;
        }

        const compressedFile = await compressImage(file, "gallery");

        await new Promise((resolve) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                galleryPreviews.value.push(URL.createObjectURL(compressedFile));
                galleryImages.value.push(compressedFile);
                resolve();  // اینجا میگه فایل تموم شد، برو بعدی
            };
            reader.readAsDataURL(compressedFile);
        });
    }

    event.target.value = '';
};


// حذف تصویر خاص از گالری
// حذف عکس
const removeGalleryImage = (index) => {
    galleryPreviews.value.splice(index, 1)
    galleryImages.value.splice(index, 1)
}

// فشرده سازی عکس (با Canvas)
const compressImage = (file, type) => {
    let MAX_WIDTH = 800;
    if (type === "thumb") {
         MAX_WIDTH = 200
    }
    if (type === "gallery") {
        MAX_WIDTH = 800
    }
    if (type === "main") {
        MAX_WIDTH = 1600
    }
    return new Promise((resolve) => {
        const img = new Image()
        const reader = new FileReader()

        reader.onload = (e) => {
            img.src = e.target.result
        }

        img.onload = () => {
            const canvas = document.createElement('canvas')
            const ctx = canvas.getContext('2d')


            const scaleSize = MAX_WIDTH / img.width
            canvas.width = MAX_WIDTH
            canvas.height = img.height * scaleSize

            ctx.drawImage(img, 0, 0, canvas.width, canvas.height)

            canvas.toBlob((blob) => {
                resolve(new File([blob], file.name, {type: file.type}))
            }, file.type, 0.7)
        }

        reader.readAsDataURL(file)
    })
}

// ارسال فرم با نوار پیشرفت
const submitForm = async () => {

    const formData = new FormData()
    const attributes = []

    for (const [key, value] of Object.entries(formValues)) {
        attributes.push({name: key, value})
    }


    if (extraFields.length) {
        for (const field of extraFields) {
            if (field.name.trim()) {
                attributes.push({name: field.name, value: field.value})
            }
        }
    }
    if (!attributes.length) {
        formError.value.push({field: 'extra', message: 'فیلدهای خصوصیات  نباید خالی باشند.'});
        return
    }


    formData.append('name', productName.value)
    formData.append('slug',productSlug.value)
    formData.append('description', prodcutdesription.value)
    formData.append('price', productPrice.value)
    formData.append('discount', productDiscount.value)
    formData.append('stock', productStock.value)
    formData.append('sku', productsku.value)
    formData.append('categoryid', selectedCategory.value)
    formData.append('is_active', productIsActive.value);
    formData.append('brand', productBrand.value)
    formData.append('weight', productWeight.value)
    formData.append('attributes', JSON.stringify(attributes))



    galleryImages.value.forEach((file, index) => {
        formData.append(`gallery[${index}]`, file)
    })
    formData.append('mainimage', mainImage.value)
    formData.append('thumbimage', thumbnail.value)
    //
    try {
        const response = await axios.post('/api/addproduct', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
            onUploadProgress: (progressEvent) => {
                uploadProgress.value = Math.round((progressEvent.loaded * 100) / progressEvent.total)
            }
        })
        // console.log(response.status)
        // console.log(response.data)
        if (response.data.status === 312) {
            formError.value=[];
            const $toast = useToast();
            let instance = $toast.success('محصول ثبت شد',{duration:3000});
            setTimeout(() => {
                window.location.href = `/admin/products/${response.data.product}`;
            }, 3000);
        }
        else{
            const $toast = useToast();
            let instance = $toast.error(response.data.message);

        }
    } catch (error) {
        console.error('خطا در آپلود:', error)
        formError.value.push(error.response.data)
    }
    // }
// قسمت اضافه کردن خصوصیات
    // const result = []
    //
    // // فیلدهای اصلی
    // for (const [key, value] of Object.entries(formValues)) {
    //     result.push({ name: key, value })
    // }
    //
    // // فیلدهای اضافی
    // for (const field of extraFields) {
    //     if (field.name.trim()) {
    //         result.push({ name: field.name, value: field.value })
    //     }
    // }
    //
    // console.log('نتیجه نهایی:', JSON.stringify(result, null, 2))


}
</script>


<style scoped>
/* انیمیشن حذف عکس (اختیاری) */
.fade-leave-active {
    transition: opacity 0.3s;
}

.fade-leave-to {
    opacity: 0;
}
</style>
