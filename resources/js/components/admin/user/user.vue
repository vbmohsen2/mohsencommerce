<template>
    <div class="p-4 max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">لیست کاربران</h1>
        <div class="mb-4 max-w-sm ">
            <input v-model="search" @input="debouncedFetch"
                   placeholder="جستجوی کاربران..."
                   class="w-full border px-3 py-2 rounded shadow-sm focus:outline-none focus:ring text-sm" />
        </div>
        <div v-for="user in users" :key="user.id"
             class="bg-white shadow rounded-lg mb-6 p-4 transition hover:shadow-lg">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div>
                    <p class="text-lg font-semibold text-gray-700">{{ user.name }}</p>
                    <p class="text-gray-500 text-sm">{{ user.email }}</p>
                </div>
                <div class="flex gap-2">
                    <button @click="editUser(user)" class="text-blue-600 hover:underline">✏️ ویرایش</button>
                    <button @click="deleteUser(user.id)" class="text-red-600 hover:underline">🗑️ حذف</button>
                    <button @click="viewOrders(user.id)" class="text-green-600 hover:underline">📦 سفارشات</button>
                    <button @click="changePasswordPrompt(user)" class="text-purple-600 hover:underline">🔒 تغییر رمز</button>

                </div>
            </div>

            <div v-if="user.address?.length" class="mt-3">
                <p class="font-semibold text-sm text-gray-700">آدرس‌ها:</p>
                <ul class="list-decimal ml-6 text-sm text-gray-600 space-y-1">
                    <li v-for="(addr, index) in user.address" :key="index" class="flex items-center justify-between">
                        <span>{{ addr }}</span>
                        <button @click="editAddress(user, index)"
                                class="text-xs text-indigo-600 hover:underline ml-2">✏️ ویرایش</button>
                    </li>
                </ul>
            </div>

            <transition name="fade">
                <div v-if="selectedUserId === user.id && userOrders.length" class="mt-4">
                    <div v-for="order in userOrders" :key="order.id" class="bg-gray-50 border rounded mb-3">
                        <div @click="toggleOrder(order.id)" class="cursor-pointer p-3 flex justify-between items-center">
                            <p class="font-semibold text-gray-800">سفارش #{{ order.id }}</p>
                            <span>{{ expandedOrders.includes(order.id) ? '➖' : '➕' }}</span>
                        </div>
                        <div v-if="expandedOrders.includes(order.id)" class="p-3 border-t text-sm text-gray-700">
                            <ul class="space-y-2">
                                <li v-for="item in order.order_items" :key="item.id" class="border rounded p-2 bg-white">
                                    <p><strong>محصول:</strong> {{ item.product?.name || 'نامشخص' }}</p>
                                    <p><strong>تعداد:</strong> {{ item.quantity }}</p>
                                    <p><strong>قیمت:</strong> {{ item.price.toLocaleString() }} تومان</p>
                                    <p><strong>تخفیف:</strong> {{ item.discount || 0 }}٪</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </transition>

        </div>

        <!-- ویرایش -->
        <div v-if="editingUser" class="bg-yellow-50 border border-yellow-300 p-4 rounded-lg mt-6">
            <h3 class="font-bold text-gray-800 mb-2">ویرایش کاربر</h3>
            <input v-model="editingUser.name"
                   class="w-full mb-2 border rounded p-2 text-sm focus:outline-none focus:ring"
                   placeholder="نام" />
            <input v-model="editingUser.email"
                   class="w-full mb-2 border rounded p-2 text-sm focus:outline-none focus:ring"
                   placeholder="ایمیل" />
            <textarea v-model="editingUser.addressesText"
                      class="w-full border rounded p-2 text-sm focus:outline-none focus:ring"
                      placeholder='آدرس‌ها (آرایه JSON)'></textarea>
            <div class="flex gap-2 mt-3">
                <button @click="saveUser"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">ذخیره</button>
                <button @click="editingUser = null"
                        class="text-gray-600 underline">انصراف</button>
            </div>
        </div>

        <div v-if="changingPasswordUser" class="bg-purple-50 border border-purple-300 p-4 rounded-lg mt-6">
            <h3 class="font-bold text-gray-800 mb-2">تغییر رمز برای {{ changingPasswordUser.name }}</h3>
            <input type="password" v-model="newPassword"
                   class="w-full mb-2 border rounded p-2 text-sm focus:outline-none focus:ring"
                   placeholder="رمز عبور جدید" />
            <div class="flex gap-2 mt-3">
                <button @click="savePassword"
                        class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">ذخیره</button>
                <button @click="changingPasswordUser = null"
                        class="text-gray-600 underline">انصراف</button>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center items-center gap-4 mt-8">
            <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1"
                    class="px-3 py-1 bg-gray-100 rounded hover:bg-gray-200 disabled:opacity-50">
                قبلی
            </button>
            <span class="text-sm text-gray-700">صفحه {{ currentPage }} از {{ lastPage }}</span>
            <button @click="goToPage(currentPage + 1)" :disabled="currentPage === lastPage"
                    class="px-3 py-1 bg-gray-100 rounded hover:bg-gray-200 disabled:opacity-50">
                بعدی
            </button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'UserList',
    data() {
        return {
            users: [],
            userOrders: null,
            selectedUserId: null,
            editingUser: null,
            currentPage: 1,
            lastPage: 1,
            perPage: 5,
            changingPasswordUser: null,
            newPassword: '',
            expandedOrders: [],
            search: '',
            debouncedFetch: null,
        };
    },
    methods: {
        async fetchUsers(page = 1) {
            const res = await axios.get(`/api/users`, {
                params: {
                    page,
                    per_page: this.perPage,
                    search: this.search,
                }
            });

            this.users = res.data.data.map(user => ({
                ...user,
                address: Array.isArray(user.address)
                    ? user.address
                    : typeof user.address === 'string'
                        ? JSON.parse(user.address)
                        : [],
            }));
            this.currentPage = res.data.current_page;
            this.lastPage = res.data.last_page;
        },
        debounce(fn, delay) {
            let timeout;
            return (...args) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => fn.apply(this, args), delay);
            };
        },
        editUser(user) {

            this.editingUser = {
                ...user,
                addressesText: JSON.stringify(user.address, null, 2),
            };
        },
        async deleteUser(id) {
            if (confirm('آیا مطمئن هستید؟')) {
                await axios.delete(`/api/users/${id}`);
                await this.fetchUsers();
            }
        },
        async saveUser() {
            try {
                const updated = {
                    name: this.editingUser.name,
                    email: this.editingUser.email,
                    address: JSON.parse(this.editingUser.addressesText),
                };
                await axios.put(`/api/users/${this.editingUser.id}`, updated);
                this.editingUser = null;
                this.fetchUsers(this.currentPage);
            } catch (e) {
                alert('خطا در ذخیره اطلاعات');
            }
        },
        async viewOrders(userId) {
            this.selectedUserId = userId;
            const res = await axios.get(`/api/users/${userId}`);
            this.userOrders = res.data.orders;
            console.log(this.userOrders)
        },
        goToPage(page) {
            if (page >= 1 && page <= this.lastPage) {
                this.fetchUsers(page);
            }
        },
        changePasswordPrompt(user) {
            this.changingPasswordUser = user;
            this.newPassword = '';
        },
        async savePassword() {
            try {

                await axios.post(`/api/users/${this.changingPasswordUser.id}/change-password`, {
                    password: this.newPassword,
                });
                alert('رمز عبور با موفقیت تغییر کرد');
                this.changingPasswordUser = null;
            } catch (err) {
                console.log(err)
                alert('خطا در تغییر رمز');
            }
        },
        toggleOrder(orderId) {
            const index = this.expandedOrders.indexOf(orderId);
            if (index > -1) {
                this.expandedOrders.splice(index, 1);
            } else {
                this.expandedOrders.push(orderId);
            }
        },
        editAddress(user, index) {
            const newAddress = prompt('آدرس جدید را وارد کنید:', user.address[index]);
            if (newAddress !== null && newAddress.trim() !== '') {
                user.address[index] = newAddress;
                // بروزرسانی سریع در سرور
                axios.put(`/api/users/${user.id}`, {
                    name: user.name,
                    email: user.email,
                    address: user.address,
                }).then(() => {
                    alert('آدرس بروزرسانی شد');
                }).catch(() => {
                    alert('خطا در ذخیره آدرس');
                });
            }
        }

    },
    mounted() {
        this.fetchUsers();
        this.debouncedFetch = this.debounce(() => {
            this.fetchUsers(1);
        }, 500);
    },
};
</script>

<style scoped>
/* Responsive spacing if needed */
</style>
