<template>
    <div class="">
        <h1 class="text-2xl font-bold mb-4">ایجاد محصول جدید</h1>

        <form @submit.prevent="submitForm" class="flex flex-wrap">

            <!-- اینجا از CategorySelector.vue استفاده میکنی -->
            <CategorySelector
                :categories="categories"
                :show-search-input="true"
                :selected="selectedCategory"
                @update:selected="selectedCategory = $event"
            />
            <div class="flex w-1/2">
            <!--            images-->
            <div class="space-y-6 space-x-2 flex flex-wrap w-full p-2 pt-4 ">

                <!-- Thumbnail -->
                <div class="border mt-6 border-gray-400 rounded-md mx-2 w-1/3 h-fit">
                    <label class="block text-gray-700 font-semibold mb-2">عکس شاخص (Thumbnail)</label>
                    <div class="flex items-center gap-4">
                        <input
                            type="file"
                            class="block w-full text-sm text-gray-500
          file:mr-4 file:py-2 file:px-4
          file:rounded-full file:border-0
          file:text-sm file:font-semibold
          file:bg-blue-50 file:text-blue-700
          hover:file:bg-blue-100
        "
                            @change="handleThumbnailUpload"
                            accept="image/*"
                        />
                        <div v-if="thumbnailPreview" class="w-20 h-20 rounded overflow-hidden border ">
                            <img :src="thumbnailPreview" alt="پیش‌نمایش" class="w-full h-full object-cover"/>
                        </div>
                    </div>
                </div>

                <!-- Main Image -->
                <div class="border border-gray-400 rounded-md mx-2 w-1/3 h-fit">
                    <label class="block text-gray-700 font-semibold mb-2">عکس اصلی (Main Image)</label>
                    <div class="flex items-center gap-4">
                        <input
                            type="file"
                            class="block w-full text-sm text-gray-500
          file:mr-4 file:py-2 file:px-4
          file:rounded-full file:border-0
          file:text-sm file:font-semibold
          file:bg-green-50 file:text-green-700
          hover:file:bg-green-100
        "
                            @change="handleMainImageUpload"
                            accept="image/*"
                        />
                        <div v-if="mainImagePreview" class="w-20 h-20 rounded overflow-hidden border">
                            <img :src="mainImagePreview" alt="پیش‌نمایش" class="w-full h-full object-cover"/>
                        </div>
                    </div>
                </div>

                <!-- Gallery Images -->
                <!-- سایر عکس‌ها -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">سایر عکس‌ها:</label>

                    <div class="flex flex-wrap gap-3 mb-3">
                        <div
                            v-for="(img, index) in galleryPreviews"
                            :key="index"
                            class="relative w-24 h-24 rounded-lg overflow-hidden border border-gray-300 shadow-md"
                        >
                            <img :src="img" class="w-full h-full object-cover transition"/>

                            <button
                                type="button"
                                @click="removeGalleryImage(index)"
                                class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-700  "
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

            </div>

            <div class="mt-6 ">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                    ذخیره محصول
                </button>
            </div>
        </form>

        <div v-if="selectedCategory" class="mt-4 p-2 bg-green-100 border rounded">
            <strong>دسته‌بندی انتخاب شده:</strong> {{ selectedCategory }}
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from 'vue'
import CategorySelector from './CategoryFilterforaddporduct.vue'
import axios from "axios";
import {v4 as uuidv4} from 'uuid'
import draggable from 'vuedraggable'

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


// محدودیت تعداد و فرمت مجاز
const MAX_IMAGES = 20
const ALLOWED_FORMATS = ['image/jpeg', 'image/png', 'image/webp']


const handleThumbnailUpload = (e) => {
    const file = e.target.files[0]
    thumbnail.value = file
    thumbnailPreview.value = URL.createObjectURL(file)
}

const handleMainImageUpload = (e) => {
    const file = e.target.files[0]
    mainImage.value = file
    mainImagePreview.value = URL.createObjectURL(file)
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

        const compressedFile = await compressImage(file,"a");

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
const compressImage = (file,type) => {
    const MAX_WIDTH=800;
    if(type==="thumb"){
        const MAX_WIDTH=200
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

    galleryImages.value.forEach((file, index) => {
        formData.append(`gallery[${index}]`, file)
    })

    try {
        const response = await axios.post('/your-upload-route', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
            onUploadProgress: (progressEvent) => {
                uploadProgress.value = Math.round((progressEvent.loaded * 100) / progressEvent.total)
            }
        })

        console.log('آپلود موفق:', response.data)
    } catch (error) {
        console.error('خطا در آپلود:', error)
    }
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
