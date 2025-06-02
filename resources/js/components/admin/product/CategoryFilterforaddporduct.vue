<template>
    <div class="max-w-4xl">

        <div class="bg-white rounded-2xl shadow p-4 border">
            <div class="mb-4 text-center">
                <input placeholder="جستجو در دسته بندی" v-model="search"/>
            </div>

            <base-tree ref="tree" :rtl="true" :default-open="false" :indent="24" v-model="treeData">
                <template #default="{ node, stat }">

                    <div
                        class="flex justify-between items-center gap-3 p-2 mb-2 border rounded-md hover:bg-gray-100 transition-all"
                        :style="{ marginRight: `${stat.level * 20}px` }"
                        :class="{
  'ring-2 ring-blue-400 ring-offset-2 bg-blue-100 shadow-sm scale-[1.01] transition-all duration-200': node.id === selectedId,
  'border border-gray-300': node.id !== selectedId,
  'bg-gray-300': stat.level === 1,
  'bg-yellow-200': stat.level > 1,
  'bg-yellow-300': stat.level > 2,
  'bg-yellow-500': stat.level > 3
}"
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

                            <span class="cursor-pointer text-gray-800 font-medium" @click="selectNode(node)"
                            >


        {{ node.text }}



      </span>

                        </div>

                    </div>

                </template>
            </base-tree>

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
        filterTreeData(nodes, keyword) {
            const filtered = [];

            for (const node of nodes) {
                const children = node.children ? this.filterTreeData(node.children, keyword) : [];

                const match = node.name?.toLowerCase().includes(keyword.toLowerCase());

                if (match || children.length > 0) {
                    filtered.push({
                        ...node,
                        children: children,
                        open: true // برای نمایش نتیجه
                    });
                }
            }

            return filtered;
        },
        openPathToSelectedNode() {
            // پیدا کردن مسیر از ریشه تا نود با ID مشخص
            const findParentPathById = (id, nodes, path = []) => {
                for (const node of nodes) {
                    const newPath = [...path, node];
                    if (node.id === id) {
                        // وقتی نود پیدا شد، مسیر والدینش تا بالا رو برمی‌گردونه (بدون خودش)
                        return path;
                    }
                    if (node.children) {
                        const result = findParentPathById(id, node.children, newPath);
                        if (result) return result;
                    }
                }
                return null;
            };

            const parentPath = findParentPathById(this.selectedId, this.treeData);

            if (parentPath && this.$refs.tree?.openNodeAndParents) {
                // نود آخر در مسیر والدین، خود والد مستقیم است
                const directParent = parentPath[parentPath.length - 1];
                if (directParent) {
                    this.$refs.tree.openNodeAndParents(directParent);
                }
            }
        },
        async fetchCategories() {
            const categoriesRes = await axios.get("/api/categories");
            // const productsRes = await axios.get("/api/productsAll");

            this.treeData = this.transformRecursive(categoriesRes.data);




            // console.log(this.idCounter)

        },
        transformRecursive(data) {
            // اینجا قبل از map مرتب می‌کنیم
            const sortedData = [...data].sort((a, b) => (a.order || 0) - (b.order || 0));

            return sortedData.map(item => {
                const children = item.children_recursive
                    ? this.transformRecursive(item.children_recursive)
                    : [];

                // جمع تعداد محصولات خودش + زیرمجموعه‌ها


                return {
                    ...item,
                    text: item.name,
                    open: false,
                    children,

                };
            });
        }


        ,
        selectNode(node) {
            this.selectedId = node.id;
            this.$emit('update:selected', node.id);

        }


    }
    ,
    data() {
        return {
            treeData: [],
            search: "",

            idCounter: 0,
            showModal: false,
            modalInput: '',
            modalCallback: null,
            modalTitle: '',
            modalPlaceholder: '',
            selectedId: null,

        };
    },
    props: {
        selected: {
            type: [Number, String],
            default: null
        }
    }
    ,
    mounted() {
        this.fetchCategories().then(() => {
            this.selectedId = this.selected;
            this.openPathToSelectedNode();
        });


    }
    , watch: {
        selected(newVal) {
            this.selectedId = newVal;
            this.openPathToSelectedNode();
        },
        search(newVal) {
            if (!newVal) {
                this.fetchCategories();

                this.$nextTick(()=>{
                    this.openPathToSelectedNode();
                    this.selectedId = this.selected;
                    this.openPathToSelectedNode();
                })
            } else {
                this.treeData = this.filterTreeData(this.treeData, newVal);
                this.$nextTick(() => {
                    this.$refs.tree.openAll();
                });

            }
        }
    }
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
