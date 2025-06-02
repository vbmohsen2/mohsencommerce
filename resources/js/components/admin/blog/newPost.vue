<script setup>
import { useRoute } from 'vue-router'
import {onMounted, ref, watch} from "vue";
import axios from "axios";
import { QuillEditor} from "@vueup/vue-quill";
import '@vueup/vue-quill/dist/vue-quill.snow.css'
import {useToast} from "vue-toast-notification";
import router from "@/router.js";


const route = useRoute()
let slug = route.params.slug
const post=ref({})
const categories=ref([])
const selectedCategory=ref('')
const content=ref()
const postId=ref();
const title=ref()
const isPublished=ref('false')
const mainImage = ref(null)
const mainImagePreview = ref(null)
const thumbnail = ref(null)
const isImage=ref()



const quillModules = {
    toolbar: [
        [{ 'header': [1, 2, false] }],
        ['bold', 'italic', 'underline'],
        [{ 'align': [] }],
        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
        ['image', 'link'],
        ['clean']
    ]
};
const fetchPost = async () => {
    const res = await axios.post('/api/blog/postsvue/edit', {
            slug
    })
    post.value = res.data
    content.value=post.value.content

    postId.value=post.value.id


    selectedCategory.value=post.value.post_category_id
    isPublished.value = !!post.value.is_published
    console.log(isPublished)
    title.value=post.value.title
    console.log("selected category",selectedCategory.value)
    // console.log(res.data)
}
const fetchCategories = async () => {
    const res = await axios.get('/api/blog/categories')
    categories.value = res.data

}
    const fetchImages=async ()=>{

        const res = await axios.post('/api/blog/postimages', {
            'postid':postId.value
        })
        let bannerObj = res.data.find(item => item.type === 'banner');
        if (bannerObj) {
            const path = `/storage/images/blog/${slug}/${bannerObj.file_path}`;
            mainImagePreview.value = path;
            isImage.value=true
        }


    }
const handleCategory=(id)=>{
    selectedCategory.value=id
}




onMounted(async () => {
        await fetchCategories()
    console.log(isPublished)
})
const handleMainImageUpload = async (e) => {


    const file = e.target.files[0]

    const compressedFile = await compressImage(file, "main");
    mainImage.value = compressedFile
    mainImagePreview.value = URL.createObjectURL(compressedFile)

    const thumbFile = e.target.files[0]
    thumbnail.value = await compressImage(thumbFile, "thumb");
}
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

function goToPost (slug) {
    // اگر روتری داری که پست را بر اساس اسلاگ نشان دهد، نامش را جایگزین کن
    router.push({ name: 'posts.edit', params: { slug } })
}

const submitForm = async () => {

    const formData = new FormData()
    const attributes = []






    formData.append('id', post.value.id)
    formData.append('title', title.value)
    formData.append('slug',slug)
    formData.append('contentt', content.value)
    formData.append('categoryid', selectedCategory.value)
    formData.append('ispublished', isPublished.value ? 1 : 0)
    console.log(mainImage.value)
    if(mainImage.value!=null){
    formData.append('mainimage', mainImage.value)
    formData.append('thumbimage', thumbnail.value)
    }


    //
    try {
        const response = await axios.post('/api/blog/savepost', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },

        })
        console.log(response.status)
        console.log(response.data)
        if (response.data.status === 312) {

            const $toast = useToast();
            let instance = $toast.success('محصول ثبت شد');
            goToPost(slug)
            // یا هر کار دیگه‌ای مثل نمایش toast موفقیت
        }
        else{
            const $toast = useToast();
            let instance = $toast.error(response.data.message);

        }
    } catch (error) {
        console.error('خطا در آپلود:', error)

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

<template>
    <div class="flex flex-col w-full pt-4 px-4">
              <div>
                  <h2>ویرایش پست</h2>

              </div>
        <div class="w-full py-4 inline-flex flex-wrap lg:flex-nowrap space-y-2 justify-between space-x-8 ">
            <input type="text" placeholder="عنوان" class="w-full  mx-2   border rounded-md focus:outline-none focus:ring focus:border-blue-300" v-model="title" >
            <input type="text" placeholder="اسلاگ" class="w-full  mx-2   border rounded-md focus:outline-none focus:ring focus:border-blue-300" v-model="slug">
            <span class="text-nowrap">
            منتشر شده:
            <input type="checkbox" v-model="isPublished">
                </span>

        </div>
        <select v-model="selectedCategory"
                class="border p-2 rounded-md w-full  appearance-none bg-white focus:outline-none focus:ring focus:border-blue-300">
            <option value="">  دسته‌بندی ها  </option>
            <option v-for="category in categories" :key="category.id" @change="handleCategory(category.id)"  :value="category.id">
                {{ category.name }}
            </option>
        </select>

        <div>
            <div class="border border-gray-300 rounded-md my-4 p-4">
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

            <div class="w-full">
                <QuillEditor
                    theme="snow" toolbar="full"
                    v-model:content="content"
                    content-type="html"
                    class="w-full min-h-[300px] max-h-[500px] overflow-auto"

                />

            </div>

        </div>
        <button @click="submitForm">ذخیره</button>
    </div>
</template>

<style scoped>

</style>
