<template>
    <div class="max-w-4xl mx-auto  ">

        <h1>{{attributeTemplateName.name}}</h1>
        <div class="bg-white rounded-2xl shadow p-4 border">
            <div class="mb-4 text-center">
                <button
                    @click="addChild(0,0)"
                    class="bg-green-600 text-white px-4 py-2 rounded-full shadow hover:bg-green-700 transition"
                >
                    ➕ افزودن خصوصیات
                </button>
            </div>
            <Draggable ref="tree" :rtl="true" :maxLevel="1"  :default-open="false" :indent="24" v-model="treeData">
                <template #default="{ node, stat }">
                    <div
                        class="flex justify-between items-center gap-3 p-2 mb-2 border border-gray-300 rounded-md hover:bg-gray-100 transition-all"
                        :style="{ marginRight: `${stat.level * 20}px` }"
                        :class="{ 'bg-gray-300': stat.level === 1, 'bg-yellow-100': stat.level > 1,'bg-yellow-200': stat.level > 2}">
                        <div class="flex items-center gap-3">
                            <span class="text-gray-800 font-medium">
                             {{ node.text }}
      </span>
                            <div class="text-center w-full flex justify-center" title>
                                <button @click="editUnit(node)" class="px-2">
                                <span><span :title=node.unit
                                            class="border bg-red-200 px-2 rounded-md border-black  ">واحد: <span
                                    v-if="node.unit">{{ node.unit }}</span></span></span>
                                </button>
                                <button @click="editslug(node)" class="">
                                <span><span :title=node.slug
                                            class="border bg-green-200 rounded-md border-black  ">
                                   <span v-if="node.slug"> اسلاگ: </span>{{ truncate(node.slug, 20) }}</span></span>
                                </button>

                                <button v-if="node.input_type==='select'" @click="editOptions(node)" class="px-2">

                                    <span
                                    :title="Object.values(node.options).join(' | ')"
                                    class="border bg-red-200 px-2 rounded-md border-black"
                                >
                                  گزینه‌ها: {{ Object.values(node.options).slice(0, 3).join(' | ') }}
                                  <span v-if="Object.values(node.options).length > 3">...</span>

  </span>

                                </button>
                            </div>

                        </div>
                        <div class="flex gap-2">
                            <button
                                @click="editNode(node)"
                                class="text-blue-600 hover:text-blue-800 text-sm"
                                title="ویرایش"
                            >✏️
                            </button>
                            <button
                                @click="deleteNode(stat, node)"
                                class="text-red-600 hover:text-red-800 text-sm"
                                title="حذف"
                            >🗑️
                            </button>
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
                <div v-if="options">
                    <input type="checkbox" v-model="is_option" id="options"/>
                    <label for="options">حالت انتخاب دار</label>
                </div>

                <div class="flex justify-end gap-2">
                    <button @click="closeModal" class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400">لغو</button>
                    <button @click="confirmModal" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                        تأیید
                    </button>
                </div>
                <button @click="closeModal" class="absolute top-2 left-2 text-gray-600 hover:text-gray-800">✖️</button>
            </div>
        </div>
    </div>
    <!--       Modal edit options-->
    <div v-if="showOptionsModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-lg relative">
            <h2 class="text-xl font-semibold mb-4">{{ modalTitle }}</h2>
            <div v-for="(value, index) in modalInput" :key="index">
                <input type="text" v-model="modalInput[index]" class="my-2"/>
            </div>
            <button @click="modalInput.push('')">➕ افزودن مقدار جدید</button>
            <div class="flex justify-end gap-2">
                <button @click="closeOptionsModal" class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400">لغو
                </button>
                <button @click="confirmOptionsModal"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                    تأیید
                </button>
            </div>
            <button @click="closeOptionsModal" class="absolute top-2 left-2 text-gray-600 hover:text-gray-800">✖️
            </button>
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

            const pathParts = window.location.pathname.split('/');
            const attributetemplateid = pathParts[pathParts.length - 1]; // "1"
            const attributes = await axios.get(`/api/attributes/${attributetemplateid}`);
            const attributestempdata=await axios.get(`/api/attributestemplate/${attributetemplateid}`);
            this.attributeTemplateName=attributestempdata.data


            this.treeData = this.transformRecursive(attributes.data);
            console.log(this.treeData)

        },
        transformRecursive(data) {

            // اینجا قبل از map مرتب می‌کنیم
            const sortedData = [...data].sort((a, b) => (a.order || 0) - (b.order || 0));

            return sortedData.map(item => {
                // جمع تعداد محصولات خودش + زیرمجموعه‌ها

                return {
                    ...item,
                    text: item.name,
                    itemid:item.id


                };
            });
        }
        ,
        findMaxId(tree) {
            let maxId = 0;

            function traverse(nodes) {
                for (const node of nodes) {
                    if (node.itemid > maxId) {
                        maxId = node.itemid;
                    }

                }
            }

            traverse(tree);
            return maxId;
        },
        findmaxOrder(tree) {
            let maxId = 0;

            function traverse(nodes) {
                for (const node of nodes) {
                    if (node.order > maxId) {
                        maxId = node.order;
                    }

                }
            }

            traverse(tree);
            return maxId;
        },
        async addChild(parentNode, stat) {

            this.openModal({
                title: 'نام خصوصیت جدید را وارد کنید:',
                placeholder: 'مثلاً: موبایل',
                options: true,
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
                        order: this.findmaxOrder(this.treeData) + 1,
                        input_type: this.is_option ? "select" : "text",
                        options:Object.values(""),
                        unit:"",
                        attribute_template_id:this.attributeTemplateName.id
                        // description: "توضیحات",
                        // image: null,
                        // parent_id: parentNode.id,
                        // is_active: 1,
                        // children_recursive: [],
                        // children: [],
                        // open: false,/
                        // product_count: 0
                    });

                    if (stat === 0) {
                        this.$refs.tree.add(newNode, null, this.$refs.tree.rootChildren.length);
                       await this.saveStructure("addchild")
                        await this.fetchCategories()
                    } else {
                        this.$refs.tree.add(newNode, stat, stat.children.length);
                        stat.open = true;
                    }
                }

            });


        },
        async deleteNode(stat, node) {



            try {
                const res = await axios.post("/api/attributes/delete", {data: node.id});
                alert(res.data.message || "با موفقیت حذف شد");

                this.$refs.tree.remove(stat)

            } catch (err) {
                alert(err.data.message);
                console.error(err);
            }


        },

        editUnit(node) {
            this.openModal({
                title: "تغییر واحد:",
                placeholder: "واحد جدید را وارد کنید ",
                defaultValue: node.unit,
                callback: (newUnit) => {
                    if (newUnit) {
                        node.unit = newUnit;
                    }
                }
            });
        },
        editOptions(node) {

            this.openOptionsModal({
                title: "تغییر واحد:",
                placeholder: "واحد جدید را وارد کنید ",
                defaultValue: Object.values(node.options),
                callback: (newValues) => {
                    if (Array.isArray(newValues)) {
                        const newOptions = {};
                        newValues.forEach((value, index) => {
                            if (value !== "") {
                                newOptions[index] = value;
                            }
                        });
                        node.options = newOptions;
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
            this.is_option = node.input_type === "select"
            this.openModal({
                title: "عنوان جدید:",
                placeholder: "مثلاً: لوازم خانگی",
                defaultValue: node.name,
                options: true,
                callback: (newTitle) => {
                    if (newTitle) {
                        node.name = newTitle;
                        node.text = newTitle;
                        if (this.is_option) {
                            node.input_type = "select"
                        } else {
                            node.input_type = "text"
                        }
                    }
                }
            });

        },
        async saveStructure(type) {
            const result = this.flattenTree(this.treeData);

            console.log("flast",result)

            try {
                const res = await axios.post("/api/attributes/reorder", {data: result});
              if(type==="addchild"){} else alert(res.data.message || "ساختار با موفقیت ذخیره شد");
            } catch (err) {
                alert("❌ خطا در ذخیره‌سازی");
                console.error(err);
            }

        },
        flattenTree(tree, parentId = null, result = []) {
            tree.forEach((node, index) => {
                result.push({
                    id: node.id,
                    order: index,
                    name: node.name,
                    slug: node.slug,
                    unit:node.unit,
                    input_type:node.input_type,
                    options:node.options,
                    attribute_template_id:node.attribute_template_id


                });

            });
            return result;
        },
        truncate(str, maxLength) {
            if (!str) return '';
            return str.length > maxLength ? str.substring(0, maxLength) + '...' : str;
        }
        ,
        openModal({title, placeholder, defaultValue = '', callback, options = false}) {
            this.modalTitle = title;
            this.modalPlaceholder = placeholder;
            this.modalInput = defaultValue;
            this.modalCallback = callback;
            this.options = options;
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
        openOptionsModal({title, placeholder, defaultValue = '', callback, options = false}) {
            this.modalTitle = title;
            this.modalPlaceholder = placeholder;
            this.modalInput = defaultValue;
            this.modalCallback = callback;
            this.options = options;
            this.showOptionsModal = true;

            // this.$nextTick(() => {
            //     this.$refs.modalInputRef.focus();
            // });
        },
        closeOptionsModal() {
            this.showOptionsModal = false;
            this.modalInput = '';
            this.modalCallback = null;
        },
        confirmOptionsModal() {
            if (this.modalCallback) {
                this.modalCallback(this.modalInput);
            }
            this.closeOptionsModal();
        }

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
            options: false,
            is_option: false,
            showOptionsModal: false,
            attributeTemplateName:'',
        };
    }
    ,
    mounted() {
        this.fetchCategories();

        console.log(this.treeData)
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
