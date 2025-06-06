<template>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow p-4 border">
            <div class="mb-4 text-center">
                <button
                    @click="addChild(0,0)"
                    class="bg-green-600 text-white px-4 py-2 rounded-full shadow hover:bg-green-700 transition inline-flex items-center justify-center mx-auto"
                >
                    ➕ افزودن دسته‌بندی اصلی
                </button>
            </div>
            <base-tree
                ref="tree"
                :rtl="true"
                :default-open="false"
                :indent="24"
                v-model="treeData"
                class="overflow-x-auto"
            >
                <template #default="{ node, stat }">
                    <div
                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 p-2 mb-2 border border-gray-300 rounded-md hover:bg-gray-100 transition-all"
                        :style="{ marginRight: `${stat.level * 20}px` }"
                        :class="{
              'bg-gray-300': stat.level === 1,
              'bg-yellow-100': stat.level > 1,
              'bg-yellow-200': stat.level > 2
            }"
                    >
                        <div class="flex flex-wrap sm:flex-nowrap items-center gap-3 flex-grow min-w-0">
              <span
                  class="text-gray-800 font-medium truncate max-w-[200px] sm:max-w-[300px]"
                  :title="node.text"
              >
                {{ node.text }}
              </span>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <button @click="editslug(node)" class="px-2" title="ویرایش اسلاگ">
                  <span v-if="node.slug" class="border bg-green-200 px-2 rounded-md border-black whitespace-nowrap inline-block max-w-[150px] overflow-hidden text-ellipsis" :title="node.slug">
                    <span class="hidden sm:inline">اسلاگ:</span> {{ truncate(node.slug, 20) }}
                  </span>
                                </button>
                                <button @click="editIcon(node)" class="px-2" title="ویرایش آیکون">
                  <span v-if="node.icon" class="border bg-green-200 px-2 rounded-md border-black inline-flex items-center justify-center">
                    <i :class="node.icon"></i>
                  </span>
                                </button>
                            </div>
                            <span class="whitespace-nowrap text-sm text-gray-700 flex-shrink-0">تعداد پست: {{ node.product_count }}</span>
                        </div>
                        <div class="flex gap-2 flex-shrink-0">
                            <button
                                @click="editNode(node)"
                                class="text-blue-600 hover:text-blue-800 text-sm"
                                title="ویرایش"
                            >
                                ✏️
                            </button>
                            <button
                                @click="deleteNode(stat, node)"
                                class="text-red-600 hover:text-red-800 text-sm"
                                title="حذف"
                            >
                                🗑️
                            </button>
                        </div>
                    </div>
                </template>
            </base-tree>

            <div class="text-center mt-6">
                <button
                    class="bg-blue-600 text-white px-6 py-2 rounded-full shadow hover:bg-blue-700 transition w-full sm:w-auto"
                    @click="saveStructure"
                >
                    💾 ذخیره
                </button>
            </div>
        </div>

        <!-- Modal component -->
        <div
            v-if="showModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 px-4"
        >
            <div
                class="bg-white rounded-xl p-6 max-w-md w-full shadow-lg relative"
                @click.stop
            >
                <h2 class="text-xl font-semibold mb-4 text-center">{{ modalTitle }}</h2>
                <input
                    ref="modalInputRef"
                    v-model="modalInput"
                    type="text"
                    class="w-full border rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring focus:border-blue-300"
                    :placeholder="modalPlaceholder"
                    @keyup.enter="confirmModal"
                />
                <div class="flex justify-end gap-2 flex-wrap">
                    <button
                        @click="closeModal"
                        class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 flex-grow sm:flex-grow-0"
                    >
                        لغو
                    </button>
                    <button
                        @click="confirmModal"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 flex-grow sm:flex-grow-0"
                    >
                        تأیید
                    </button>
                </div>
                <button
                    @click="closeModal"
                    class="absolute top-2 left-2 text-gray-600 hover:text-gray-800 text-lg"
                    aria-label="بستن"
                >
                    ✖️
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import {BaseTree, Draggable, OpenIcon} from '@he-tree/vue'
import '@he-tree/vue/style/default.css'
import '@he-tree/vue/style/material-design.css'
import axios from "axios";
import {reactive} from "vue";

export default {
    components: {BaseTree, Draggable, OpenIcon},

    methods: {

        async fetchCategories() {
            const categoriesRes = await axios.get("/api/blog/categories");
            const productsRes = await axios.get("/api/allpostswithoutpaginate");
            console.log(productsRes.data)
            const productCountMap = this.countProductsByCategory(productsRes.data);
            this.treeData = this.transformRecursive(categoriesRes.data, productCountMap);
            this.idCounter = this.findMaxId(this.treeData);
            // console.log(this.treeData)
            // console.log(this.idCounter)

        },
        transformRecursive(data, productCountMap) {

            // اینجا قبل از map مرتب می‌کنیم
            const sortedData = [...data].sort((a, b) => (a.order || 0) - (b.order || 0));

            return sortedData.map(item => {

                // جمع تعداد محصولات خودش + زیرمجموعه‌ها
                const selfCount = productCountMap[item.id] || 0;


                return {
                    ...item,
                    text: item.name,
                    product_count: selfCount ,
                };
            });
        }
        ,
        findMaxId(tree) {
            let maxId = -Infinity;

            function traverse(nodes) {
                for (const node of nodes) {
                    if (node.id > maxId) {
                        maxId = node.id;
                    }

                }
            }

            traverse(tree);
            return maxId;
        }
        ,

        countProductsByCategory(products) {
            const map = {};
            console.log(products)
            products.forEach(p => {
                if (!map[p.post_category_id]) {
                    map[p.post_category_id] = 0;
                }
                map[p.post_category_id]++;
            });
            return map;
        }
        ,
        async addChild(parentNode, stat) {
            this.openModal({
                title: 'نام دسته جدید را وارد کنید:',
                placeholder: 'مثلاً: موبایل',
                callback: async (newName) => {
                    if (!newName) return;

                    let slug = "";
                    try {
                        slug = await axios.post("/slugify", {data: newName});
                        slug = slug.data.slug;
                    } catch (err) {
                        alert(err);
                        console.error(err);
                    }

                    const newNode = reactive({
                        id: this.findMaxId(this.treeData) + 1,
                        name: newName,
                        text: newName,
                        slug: slug,
                        product_count: 0,
                        icon:""
                    });

                    if (stat === 0) {
                        this.$refs.tree.add(newNode, null, this.$refs.tree.rootChildren.length);
                    } else {
                        this.$refs.tree.add(newNode, stat, stat.children.length);
                        stat.open = true;
                    }
                }

            });

        }
        ,
        async deleteNode(stat, node) {
            // console.log(node.children_recursive.length)

            if (node.product_count > 0) {
                alert("این دسته بندی دارای محصول است ");
                return;
            }
            try {
                const res = await axios.post("/api/blogcategories/delete", {data: node.id});
                alert(res.data.message || "با موفقیت حذف شد");
                // console.log( node.id)
                this.$refs.tree.remove(stat)

            } catch (err) {
                alert(err.data);
                console.error(err);
            }


        },

        editIcon(node) {
            this.openModal({
                title: "ایکون جدید: از کلاس های fontAwesome استفاده کنید ",
                placeholder: "ایکون جدید را وارد کنید",
                defaultValue: node.icon,
                callback: (newicon) => {
                    if (newicon) {
                        node.icon = newicon;
                    }
                }
            });
        },
        async editslug(node) {
            this.openModal({
                title: "اسلاگ جدید:",
                placeholder: "مثلاً: mobile-phones",
                defaultValue: node.slug,
                callback: async (newSlug) => {
                    try {
                        const res = await axios.post("/slugify", {data: newSlug});
                        node.slug = res.data.slug;

                    } catch (err) {
                        alert(err);
                        console.error(err);
                    }
                }
            });
        },
        editNode(node) {
            this.openModal({
                title: "عنوان جدید:",
                placeholder: "مثلاً: پزشکی",
                defaultValue: node.name,
                callback: async (newTitle) => {

                        if (newTitle) {
                            node.name = newTitle;
                            node.text = newTitle;
                        }


                }
            });
        },
        async saveStructure() {
            const result = this.flattenTree(this.treeData);

            console.log("🔁 ساختار نهایی:", result);

            try {
                const res = await axios.post("/api/blogcategories/save", {data: result});
                alert(res.data.message || "ساختار با موفقیت ذخیره شد");
            } catch (err) {
                alert("❌ خطا در ذخیره‌سازی");
                console.error(err);
            }

        },
        flattenTree(tree, result = []) {
            tree.forEach((node, index) => {
                result.push({
                    id: node.id,
                    name: node.name,
                    slug: node.slug,
                    icon:node.icon
                });

            });
            return result;
        },
        truncate(str, maxLength) {
            if (!str) return '';
            return str.length > maxLength ? str.substring(0, maxLength) + '...' : str;
        }
        ,
        openModal({title, placeholder, defaultValue = '', callback}) {
            this.modalTitle = title;
            this.modalPlaceholder = placeholder;
            this.modalInput = defaultValue;
            this.modalCallback = callback;
            this.showModal = true;
            this.$nextTick(() => {
                this.$refs.modalInputRef.focus();
            });
        },
        closeModal() {
            this.showModal = false;
            this.modalInput = '';
            this.modalCallback = null;
        },
        confirmModal() {
            if (this.modalCallback) {
                this.modalCallback(this.modalInput);
            }
            this.closeModal();
        },
    }
    ,
    data() {
        return {
            treeData: [],

            idCounter: 0,
            showModal: false,
            modalInput: '',
            modalCallback: null,
            modalTitle: '',
            modalPlaceholder: '',
        };
    }
    ,
    mounted() {
        this.fetchCategories();

        // console.log(this.treeData)
    }
    ,
}
</script>
<style scoped>
.actions {
    margin-top: 10px;
    border-top: 1px solid #ccc;
    padding-top: 10px;
}

button {
    border: 1px solid #ccc;
    padding: 2px 5px;
    border-radius: 5px;
    margin-right: 8px;
    margin-bottom: 5px;
    font-size: small;
}
</style>
