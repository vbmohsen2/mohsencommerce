<template>
    <div style="max-width: 600px; margin: auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.15); font-family: sans-serif;">

        <!-- اطلاعات اصلی -->
        <section>
            <h2 style="font-size: 24px; font-weight: bold; margin-bottom: 16px;">اطلاعات حساب کاربری</h2>
            <p><strong>نام:</strong> {{ user.name }}</p>
            <p><strong>ایمیل:</strong> {{ user.email }}</p>
            <button @click="showEditNameModal = true" style="margin-top: 12px; background:#2563eb; color:white; border:none; padding:8px 16px; border-radius:4px; cursor:pointer;">
                ویرایش نام
            </button>
        </section>

        <hr style="margin: 24px 0;" />

        <!-- شماره موبایل -->
        <section>
            <h2 style="font-size: 24px; font-weight: bold; margin-bottom: 16px;">شماره تلفن</h2>
            <p>{{ user.phone || '-' }}</p>
            <button @click="showEditPhoneModal = true" style="margin-top: 12px; background:#2563eb; color:white; border:none; padding:8px 16px; border-radius:4px; cursor:pointer;">
                ویرایش شماره تلفن
            </button>
        </section>

        <hr style="margin: 24px 0;" />

        <!-- تعداد سفارشات -->
        <section>
            <h2 style="font-size: 24px; font-weight: bold; margin-bottom: 16px;">سفارشات شما</h2>
            <p>تعداد سفارش‌ها: <strong>{{ ordersCount }}</strong></p>
        </section>

        <hr style="margin: 24px 0;" />

        <!-- دکمه تغییر رمز -->
        <section>
            <button @click="showChangePasswordModal = true" style="background:#dc2626; color:white; border:none; padding:10px 20px; border-radius:4px; cursor:pointer; font-weight:bold;">
                تغییر رمز عبور
            </button>
        </section>

        <!-- مودال ویرایش نام -->
        <div v-if="showEditNameModal" class="modal-overlay" @click.self="closeModals">
            <div class="modal-content">
                <h3>ویرایش نام</h3>
                <form @submit.prevent="submitEditName" style="margin-top: 12px;">
                    <input
                        v-model="form.name"
                        type="text"
                        placeholder="نام"
                        required
                        style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                    />
                    <div style="margin-top: 16px; text-align: right;">
                        <button type="button" @click="closeModals" style="margin-right: 8px; padding: 8px 14px; border: none; border-radius: 4px; background: #ccc; cursor: pointer;">
                            انصراف
                        </button>
                        <button type="submit" style="padding: 8px 14px; border: none; border-radius: 4px; background: #22c55e; color: white; cursor: pointer;">
                            ذخیره
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- مودال ویرایش شماره موبایل -->
        <div v-if="showEditPhoneModal" class="modal-overlay" @click.self="closeModals">
            <div class="modal-content">
                <h3>ویرایش شماره تلفن</h3>
                <form @submit.prevent="submitEditPhone" style="margin-top: 12px;">
                    <input
                        v-model="form.phone"
                        type="text"
                        placeholder="شماره تلفن"
                        style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                    />
                    <div style="margin-top: 16px; text-align: right;">
                        <button type="button" @click="closeModals" style="margin-right: 8px; padding: 8px 14px; border: none; border-radius: 4px; background: #ccc; cursor: pointer;">
                            انصراف
                        </button>
                        <button type="submit" style="padding: 8px 14px; border: none; border-radius: 4px; background: #22c55e; color: white; cursor: pointer;">
                            ذخیره
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- مودال تغییر رمز عبور -->
        <div v-if="showChangePasswordModal" class="modal-overlay" @click.self="closeModals">
            <div class="modal-content">
                <h3>تغییر رمز عبور</h3>
                <form @submit.prevent="submitChangePassword" style="margin-top: 12px;">
                    <input
                        v-model="password.old"
                        type="password"
                        placeholder="رمز فعلی"
                        required
                        style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 8px;"
                    />
                    <input
                        v-model="password.new"
                        type="password"
                        placeholder="رمز جدید"
                        required
                        style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 8px;"
                    />
                    <input
                        v-model="password.confirm"
                        type="password"
                        placeholder="تکرار رمز جدید"
                        required
                        style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                    />
                    <div style="margin-top: 16px; text-align: right;">
                        <button type="button" @click="closeModals" style="margin-right: 8px; padding: 8px 14px; border: none; border-radius: 4px; background: #ccc; cursor: pointer;">
                            انصراف
                        </button>
                        <button type="submit" style="padding: 8px 14px; border: none; border-radius: 4px; background: #dc2626; color: white; cursor: pointer;">
                            ذخیره رمز جدید
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- پیام موفقیت یا خطا -->
        <p v-if="message" :style="{ color: messageColor, marginTop: '24px', fontWeight: 'bold', textAlign: 'center' }">
            {{ message }}
        </p>

    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const user = ref({
    name: '',
    email: '',
    phone: '',
})

const ordersCount = ref(0)

const form = ref({
    name: '',
    phone: '',
})

const password = ref({
    old: '',
    new: '',
    confirm: '',
})

const showEditNameModal = ref(false)
const showEditPhoneModal = ref(false)
const showChangePasswordModal = ref(false)

const message = ref('')
const messageColor = ref('green')

onMounted(async () => {
    try {
        const res = await axios.get('/api/user')
        user.value = {
            name: res.data.name,
            email: res.data.email,
            phone: res.data.phone || '',
        }
        form.value.name = user.value.name
        form.value.phone = user.value.phone

        // مقدار موقت سفارشات
        ordersCount.value = 0
    } catch (error) {
        message.value = 'خطا در دریافت اطلاعات کاربر.'
        messageColor.value = 'red'
    }
})

const closeModals = () => {
    showEditNameModal.value = false
    showEditPhoneModal.value = false
    showChangePasswordModal.value = false
    message.value = ''
    messageColor.value = 'green'
}

const submitEditName = async () => {
    try {
        const res = await axios.post('/user/update', { name: form.value.name })
        user.value.name = form.value.name
        message.value = res.data.message || 'نام با موفقیت به‌روزرسانی شد.'
        messageColor.value = 'green'
        closeModals()
    } catch (error) {
        message.value = 'خطا در به‌روزرسانی نام.'
        messageColor.value = 'red'
    }
}

const submitEditPhone = async () => {
    try {
        const res = await axios.post('/user/updatephone', { phone: form.value.phone })
        console.log(res)
        user.value.phone = form.value.phone
        message.value = res.data.message || 'شماره تلفن با موفقیت به‌روزرسانی شد.'
        messageColor.value = 'green'

        closeModals()
    } catch (error) {
        if (error.response && error.response.status === 422) {
            console.log('Validation errors:', error.response.data.errors);
            message.value = 'خطا در اعتبارسنجی: ' + Object.values(error.response.data.errors).flat().join('، ');
        } else {
            message.value = 'خطا در به‌روزرسانی شماره تلفن.';
        }
        messageClass.value = 'text-red-600';
    }
}

const submitChangePassword = async () => {
    if (password.value.new !== password.value.confirm) {
        message.value = 'رمز جدید با تکرار آن یکسان نیست.'
        messageColor.value = 'red'
        return
    }

    try {
        const res = await axios.post('/user/change-password', {
            old_password: password.value.old,
            new_password: password.value.new,
            new_password_confirmation: password.value.confirm,
        })
        message.value = res.data.message || 'رمز عبور با موفقیت تغییر یافت.'
        messageColor.value = 'green'
        closeModals()
        password.value = { old: '', new: '', confirm: '' }
    } catch (error) {
        message.value = 'خطا در تغییر رمز عبور.'
        messageColor.value = 'red'
    }
}
</script>

<style>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}
.modal-content {
    background: white;
    padding: 24px;
    border-radius: 8px;
    width: 90%;
    max-width: 400px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
}
</style>
