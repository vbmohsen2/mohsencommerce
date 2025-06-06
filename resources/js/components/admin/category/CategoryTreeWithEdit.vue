<template>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow p-4 sm:p-6 border">
            <div class="mb-4 text-center">
                <button
                    @click="addChild(0, 0)"
                    class="bg-green-600 text-white px-4 py-2 rounded-full shadow hover:bg-green-700 transition"
                >
                    ➕ افزودن دسته‌بندی اصلی
                </button>
            </div>

            <Draggable
                ref="tree"
                :rtl="true"
                :default-open="false"
                :indent="24"
                v-model="treeData"
            >
                <template #default="{ node, stat }">
                    <div
                        class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 sm:gap-3 p-3 mb-2 border border-gray-300 rounded-md hover:bg-gray-100 transition-all"
                        :style="{ marginRight: `${stat.level * 20}px` }"
                        :class="{
              'bg-gray-300': stat.level === 1,
              'bg-yellow-100': stat.level > 1,
              'bg-yellow-200': stat.level > 2
            }"
                    >
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 w-full">
                            <div class="flex items-center gap-2">
                <span
                    v-if="stat.children.length"
                    @click="stat.open = !stat.open"
                    class="text-gray-700 font-bold text-lg cursor-pointer select-none"
                >
                  {{ stat.open ? "−" : "+" }}
                </span>
                                <span v-else class="w-5"></span>
                            </div>

                            <div class="flex-1">
                                <label class="inline-flex items-center gap-2 text-gray-800 font-medium">
                                    <input
                                        type="checkbox"
                                        v-model="node.is_active"
                                        :true-value="1"
                                        :false-value="0"
                                        class="accent-green-600"
                                    />
                                    {{ node.text }}
                                </label>

                                <div class="flex flex-wrap justify-center gap-2 mt-2 text-sm">
                                    <button @click="editDescription(node)" class="px-2">
                    <span v-if="node.description">
                      <span
                          :title="node.description"
                          class="border bg-red-200 px-2 rounded-md border-black"
                      >
                        توضیحات: {{ truncate(node.description, 20) }}
                      </span>
                    </span>
                                    </button>

                                    <button @click="editslug(node)" class="px-2">
                    <span v-if="node.slug">
                      <span
                          :title="node.slug"
                          class="border bg-green-200 px-2 rounded-md border-black"
                      >
                        اسلاگ: {{ truncate(node.slug, 20) }}
                      </span>
                    </span>
                                    </button>

                                    <span class="text-nowrap">تعداد کالا: {{ node.product_count }}</span>
                                </div>
                            </div>

                            <div class="flex gap-2 mt-2 sm:mt-0">
                                <button
                                    @click="addChild(node, stat)"
                                    class="text-green-600 hover:text-green-800 text-sm"
                                    title="افزودن زیرگروه"
                                >
                                    ➕
                                </button>
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
                    </div>
                </template>
            </Draggable>

            <div class="text-center mt-6">
                <button
                    class="bg-blue-600 text-white px-6 py-2 rounded-full shadow hover:bg-blue-700 transition"
                    @click="saveStructure"
                >
                    💾 ذخیره ترتیب
                </button>
            </div>
        </div>

        <!-- Modal component -->
        <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-lg relative">
                <h2 class="text-xl font-semibold mb-4">{{ modalTitle }}</h2>
                <input
                    ref="modalInputRef"
                    v-model="modalInput"
                    type="text"
                    class="w-full border rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring focus:border-blue-300"
                    :placeholder="modalPlaceholder"
                    @keyup.enter="confirmModal"
                />
                <div class="flex justify-end gap-2">
                    <button
                        @click="closeModal"
                        class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400"
                    >
                        لغو
                    </button>
                    <button
                        @click="confirmModal"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700"
                    >
                        تأیید
                    </button>
                </div>
                <button
                    @click="closeModal"
                    class="absolute top-2 left-2 text-gray-600 hover:text-gray-800"
                >
                    ✖️
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import {Draggable, OpenIcon} from '@he-tree/vue'
import '@he-tree/vue/style/default.css'
import '@he-tree/vue/style/material-design.css'
import axios from "axios";
import {reactive} from "vue";

export default {
    components: {Draggable, OpenIcon},

    methods: {

        async fetchCategories() {
            const categoriesRes = await axios.get("/api/categories");
            const productsRes = await axios.get("/api/productsAll");
            const productCountMap = this.countProductsByCategory(productsRes.data);
            console.group(categoriesRes.data)
            this.treeData = this.transformRecursive(categoriesRes.data, productCountMap);
            this.idCounter = this.findMaxId(this.treeData);
            // console.log(this.treeData)
            // console.log(this.idCounter)

        },
        transformRecursive(data, productCountMap) {
            // اینجا قبل از map مرتب می‌کنیم
            const sortedData = [...data].sort((a, b) => (a.order || 0) - (b.order || 0));

            return sortedData.map(item => {
                const children = item.children_recursive
                    ? this.transformRecursive(item.children_recursive, productCountMap)
                    : [];

                // جمع تعداد محصولات خودش + زیرمجموعه‌ها
                const selfCount = productCountMap[item.id] || 0;
                const childrenCount = children.reduce((sum, child) => sum + (child.product_count || 0), 0);

                return {
                    ...item,
                    text: item.name,
                    open: false,
                    children,
                    description: item.description,
                    product_count: selfCount + childrenCount,
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
                    if (node.children && node.children.length > 0) {
                        traverse(node.children);
                    }
                }
            }

            traverse(tree);
            return maxId;
        }
        ,

        countProductsByCategory(products) {
            const map = {};
            products.forEach(p => {
                if (!map[p.category_id]) {
                    map[p.category_id] = 0;
                }
                map[p.category_id]++;
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
                        description: "توضیحات",
                        image: null,
                        parent_id: parentNode.id,
                        order: parentNode.order + 1,
                        is_active: 1,
                        children_recursive: [],
                        children: [],
                        open: false,
                        product_count: 0
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
            if (node.children_recursive.length > 0) {
                alert("این دسته‌بندی دارای زیر‌دسته است و نمی‌توان آن را حذف کرد.");
                return;
            }
            if (node.product_count > 0) {
                alert("این دسته بندی دارای محصول است ");
                return;
            }

            try {
                const res = await axios.post("/api/categories/delete", {data: node.id});
                alert(res.data.message || "با موفقیت حذف شد");
                // console.log( node.id)
                this.$refs.tree.remove(stat)

            } catch (err) {
                alert(err.data.message);
                console.error(err);
            }


        },

        editDescription(node) {
            this.openModal({
                title: "توضیحات جدید:",
                placeholder: "توضیحات را وارد کنید...",
                defaultValue: node.description,
                callback: (newDescription) => {
                    if (newDescription) {
                        node.description = newDescription;
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
                        const res = await axios.post("/slugify", { data: newSlug });
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
                placeholder: "مثلاً: لوازم خانگی",
                defaultValue: node.name,
                callback: (newTitle) => {
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
                const res = await axios.post("/api/categories/reorder", {data: result});
                alert(res.data.message || "ساختار با موفقیت ذخیره شد");
            } catch (err) {
                alert("❌ خطا در ذخیره‌سازی");
                console.error(err);
            }

        },
        flattenTree(tree, parentId = null, result = []) {
            tree.forEach((node, index) => {
                result.push({
                    id: node.id,
                    parent_id: parentId,
                    sort_order: node.order,
                    name: node.name,
                    slug: node.slug,
                    is_active:node.is_active,
                    description: node.description,

                });
                if (node.children && node.children.length) {
                    this.flattenTree(node.children, node.id, result);
                }
            });
            return result;
        },
        truncate(str, maxLength) {
            if (!str) return '';
            return str.length > maxLength ? str.substring(0, maxLength) + '...' : str;
        }
        ,
        openModal({ title, placeholder, defaultValue = '', callback }) {
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
            // tree: [
            //     {
            //         text: 'Projects',
            //         children: [
            //             {
            //                 text: 'Frontend',
            //                 children: [
            //                     {
            //                         text: 'Vue',
            //                         children: [
            //                             {
            //                                 text: 'Nuxt',
            //                             },
            //                         ],
            //                     },
            //                     {
            //                         text: 'React',
            //                         children: [
            //                             {
            //                                 text: 'Next',
            //                             },
            //                         ],
            //                     },
            //                     {
            //                         text: 'Angular',
            //                     },
            //                 ],
            //             },
            //             {
            //                 text: 'Backend',
            //             },
            //         ],
            //     },
            //     { text: 'Photos' },
            //     { text: 'Videos' },
            // ]
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
