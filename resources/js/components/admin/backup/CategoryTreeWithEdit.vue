<template>
    <div class="max-w-4xl mx-auto  " >
        <h2 class="text-xl font-bold mb-4 text-center">مدیریت دسته‌بندی‌ها</h2>

        <div class="bg-white rounded-2xl shadow p-4 border">
            <div class="mb-4 text-center">
                <button
                    @click="addRootCategory"
                    class="bg-green-600 text-white px-4 py-2 rounded-full shadow hover:bg-green-700 transition"
                >
                    ➕ افزودن دسته‌بندی اصلی
                </button>
            </div>
            <Draggable ref="treeref" v-model="treeData" :default-open="false"  :indent="24" :clone="cloneNode"  virtualization>
                <template #default="{ node, stat }">

                    <div
                        class="flex justify-between items-center gap-3 p-2 mb-2 border border-gray-300 rounded-md hover:bg-gray-100 transition-all"
                        :style="{ marginRight: `${stat.level * 20}px` }"
                        :class="{ 'bg-gray-300': stat.level === 1, 'bg-yellow-100': stat.level > 1,'bg-yellow-200': stat.level > 2}"
                    >
                        <div class="flex items-center gap-3">
      <span

          v-if="stat.children.length"
          @click="stat.open = !stat.open"
          class="text-gray-700 font-bold text-lg cursor-pointer select-none"
      >
        {{ stat.open ? "−" : "+" }}
      </span>
                            <span v-else class="w-5"></span>

                            <span class="text-gray-800 font-medium">

        {{ node.name }}



      </span>
                            <div class="text-center w-full flex justify-center" title>
                                <button @click="editDescription(node)" class="px-2">
                              <span v-if="node.description" ><span class="border bg-red-200 px-2 rounded-md border-black  ">توضیحات: {{   truncate(node.description,20)   }}</span></span>
                                </button>
                                <button @click="editslug(node)" class="px-2">
                                    <span v-if="node.slug" ><span class="border bg-green-200 px-2 rounded-md border-black  ">اسلاگ: {{   truncate(node.slug,20)   }}</span></span>
                                </button>
                            </div>
                        <span class="text-nowrap">تعداد کالا:{{node.product_count}}</span>
                        </div>
                        <div class="flex gap-2">
                            <button
                                @click="addChild(node,stat)"
                                class="text-green-600 hover:text-green-800 text-sm"
                                title="افزودن زیرگروه"
                            >➕</button>
                            <button
                                @click="editNode(node)"
                                class="text-blue-600 hover:text-blue-800 text-sm"
                                title="ویرایش"
                            >✏️</button>
                            <button
                                @click="deleteNode(stat, node)"
                                class="text-red-600 hover:text-red-800 text-sm"
                                title="حذف"
                            >🗑️</button>
                        </div>
                    </div>

                </template>

            </Draggable>

        </div>

        <div class="text-center mt-6">
            <button
                class="bg-blue-600 text-white px-6 py-2 rounded-full shadow hover:bg-blue-700 transition"
                @click="saveStructure"
            >
                💾 ذخیره ترتیب
            </button>
        </div>
    </div>
</template>

<script setup>
import {ref, onMounted, render, proxyRefs, reactive} from "vue";
import { Draggable } from "@he-tree/vue";
import "@he-tree/vue/style/default.css";
import axios from "axios";


const treeData = ref([]);
let idCounter  ;
let products;
// const treeRef = ref()
// const temptree=ref([])
function cloneNode(node) {
    return { ...node };
}

// function buildTree(list, parentId = null) {
//     return list
//         .filter((item) => item.parent_id === parentId)
//         .map((item) => ({
//             ...item,
//             text: item.name,
//             children: buildTree(list, item.id),
//         }));
// }


function flattenTree(tree, parentId = null, result = []) {
    tree.forEach((node, index) => {
        result.push({
            id: node.id,
            parent_id: parentId,
            sort_order: index,
            name: node.name,
            slug:node.slug,
            description:node.description,

        });
        if (node.children_recursive && node.children_recursive.length) {
            flattenTree(node.children_recursive, node.id, result);
        }
    });
    return result;
}
function editNode(node) {
    const newTitle = prompt("عنوان جدید:", node.name);
    if (newTitle) {
        node.name = newTitle;
    }

}
function editDescription(node){
    const NewDescription = prompt("عنوان جدید:", node.description);
    if (NewDescription) {
        node.description = NewDescription;
    }
}
function editslug(node){
    const Newslug = prompt("عنوان جدید:", node.slug);
    if (Newslug) {
        node.slug = Newslug;
    }
    //should api this
}

function countProductsByCategory(products) {
    const map = {};
    products.forEach(p => {
        if (!map[p.category_id]) {
            map[p.category_id] = 0;
        }
        map[p.category_id]++;
    });
    return map;
}

// مرحله 2: تابع بازگشتی برای افزودن تعداد محصولات
function transformRecursive(data, productCountMap) {
    return data.map(item => {
        const children = item.children_recursive
            ? transformRecursive(item.children_recursive, productCountMap)
            : [];

        // جمع تعداد محصولات خودش + زیرمجموعه‌ها
        const selfCount = productCountMap[item.id] || 0;
        const childrenCount = children.reduce((sum, child) => sum + (child.product_count || 0), 0);

        return {
            ...item,
            text: item.name,
            open: false,
            children,
            product_count: selfCount + childrenCount,
        };
    });
}

async function fetchCategories() {
    const [categoriesRes, productsRes] = await Promise.all([
        axios.get("/api/categories"),
        axios.get("/api/productsAll")
    ]);

    const productCountMap = countProductsByCategory(productsRes.data);
    treeData.value = transformRecursive(categoriesRes.data, productCountMap);
    idCounter = findMaxId(treeData.value);
}

function findMaxId(tree) {
    let maxId = -Infinity;

    function traverse(nodes) {
        for (const node of nodes) {
            if (node.id > maxId) {
                maxId = node.id;
            }
            if (node.children && node.children.length > 0) {
                traverse(node.children);
            }
        }
    }

    traverse(tree);
    return maxId;
}


onMounted(()=> {
    fetchCategories();
    // const a=treeRef.value.stats
    // console.log(a )

})
function addAppendToFirstNode() {
    this.$refs.treeRef.add(
        {text: 'new node'},
        this.$refs.treeRef.rootChildren[0],
        this.$refs.treeRef.rootChildren[0].children.length
    )
}
 async  function addChild(parentNode,stat) {

    // console.log("node",parentNode)
    // console.log("stat",stat)
    const newName = prompt('نام دسته جدید را وارد کنید:')
    if (!newName) return // کاربر لغو کرد یا چیزی وارد نکرد
    let slug =""
     try {
         slug= await axios.post("/slugify", { data: newName  });
         // console.log()
        slug=slug.data.slug
     } catch (err) {
         alert(err);
         console.error(err);
     }
    const newNode =reactive( {
        id: findMaxId(treeData.value)+1,
        name:newName,
        slug:slug,
        description: "توضیحات",
        image: null,
        parent_id: parentNode.id,
        order: parentNode.order+1,
        is_active: 1,
        children_recursive: [],
        children:[],
        open:false
    })
    // console.log(newNode.slug)

    // // اگر children وجود نداره، ایجاد کن
    // if (!parentNode.children_recursive) {
    //     parentNode.children_recursive =reactive( [])
    // }
    // if (!parentNode.children) {
    //     parentNode.children = reactive([])
    // }

        console.log(this.$treeref.value)
     this.$refs.tree.add(
         newNode,
         stat,
         stat.children.length
     )
    // parentNode.children_recursive.push(newNode)
    // parentNode.children.push(newNode)
    // console.log("parentnode",parentNode)
    // console.log("newnode",newNode)
    parentNode.open = true // در صورت بسته بودن، بازش کن
    // console.log(parentNode)
    // console.log("treedata",flattenTree(treeData.value))
    // saveStructure();
    // console.log(flattenTree(treeData.value))
        parentNode.slug="88"
     // temptree.value=treeData.value
     // treeData.value = [...treeData.value]
     console.log(parentNode.id)
     // parentNode.addChild()
     console.log(treeData.value[parentNode])
     parentNode.open=true
}

async  function addRootCategory() {
    const name = prompt('نام دسته اصلی جدید:')
    if (!name) return

    let slug =""
    try {
        slug= await axios.post("/slugify", { data: name  });
        // console.log()
        slug=slug.data.slug
    } catch (err) {
        alert(err);
        console.error(err);
    }
    const newNode =reactive( {
        id: findMaxId(treeData.value)+1,
        name:name,
        slug:slug,
        description: "توضیحات",
        image: null,
        parent_id: null,
        order: findMaxId(treeData.value)+1,
        is_active: 1,
        children_recursive: [],
        children:[],
        open:false
    })
    treeData.value.push(newNode)
    treeData.value = [...treeData.value]
    // console.log(treeData)
}
async function getSlugFromServer(text) {

}
 async  function deleteNode(stat, node) {
    // console.log(node.children_recursive.length)
    if (node.children_recursive.length > 0) {
        alert("این دسته‌بندی دارای زیر‌دسته است و نمی‌توان آن را حذف کرد.");
        return;
    }
    if(node.product_count>0)
    {
        alert("این دسته بندی دارای محصول است ");
        return;
    }

     try {
         const res = await axios.post("/api/categories/delete", { data: node.id  });
         alert(res.data.message || "با موفقیت حذف شد");
         // console.log( node.id)
         treeData.value= removeItemById(treeData.value,node.id)
         treeData.value = [...treeData.value]
     } catch (err) {
         alert(err.data.message);
         console.error(err);
     }


}

function removeItemById(items, idToRemove) {
    return items
        .filter(item => item.id !== idToRemove) // حذف در همین سطح
        .map(item => ({
            ...item,
            children: item.children
                ? removeItemById(item.children, idToRemove) // بازگشتی روی children
                : []
        }));
}
function truncate(str, maxLength) {
    if (!str) return '';
    return str.length > maxLength ? str.substring(0, maxLength) + '...' : str;
}

async function saveStructure() {
    const result = flattenTree(treeData.value);
    // console.log("🔁 ساختار نهایی:", result);

    try {
        const res = await axios.post("/api/categories/reorder", { data: result });
        alert(res.data.message || "ساختار با موفقیت ذخیره شد");
    } catch (err) {
        alert("❌ خطا در ذخیره‌سازی");
        console.error(err);
    }
    fetchCategories();
}



</script>

<style scoped>
/* اضافه کردن فاصله برای مشخص شدن زیردسته‌ها */
.he-tree-indent {
    margin-inline-start: 24px;
    background-color: #4a5568;
}
</style>
