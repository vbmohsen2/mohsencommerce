<template>
    <div class="relative">
        <!-- دکمه کاربر -->
        <button @click="toggleMenuOrLogin" id="loginbtn" class="pt-2 px-2" :title="user?.name || ''">
            <!-- جایگزین <img src="/public/images/user-01.svg" ...> -->
            <svg
                class="w-8 h-8 sm:w-10 sm:h-10 min-w-[2rem] min-h-[1rem] text-gray-400"
                viewBox="0 0 64 64"
                xmlns="http://www.w3.org/2000/svg"
                role="img"
                aria-label="User"
                width="100%"
                height="100%"
            >
                <title>User</title>
                <circle
                    cx="32"
                    cy="20"
                    r="12"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                />
                <path
                    d="M12 54c0-8 6.5-14.5 14.5-14.5h11c8 0 14.5 6.5 14.5 14.5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>

        </button>

        <!-- منوی کاربری -->
        <div
            v-if="isLoggedIn && showUserInfo"
            class="absolute left-8 mt-2 w-48 bg-white border rounded shadow-2xl z-50 p-4"
        >
            <ul class="space-y-2">
                <li><Link href="/user/dashboard">حساب کاربری</Link></li>
                <li><Link href="/user/orders">سفارشات</Link></li>
                <li><Link href="/user/addresses">آدرس‌ها</Link></li>
                <li class="cursor-pointer" @click="logout">خروج</li>
            </ul>
        </div>

        <!-- مودال ورود -->
        <transition name="fade">
            <div
                v-if="!isLoggedIn && showLoginModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm transition-opacity duration-300"
            >
                <div class="bg-white w-full max-w-md mx-4 p-6 rounded-2xl shadow-xl border border-gray-200 animate-fadeIn">
          <span class="text-2xl font-bold text-center text-gray-800 mb-6 block">
            ورود به حساب کاربری
          </span>

                    <div v-if="loginMessage" :class="loginMessageClass" class="text-center p-3 mb-4 rounded font-medium">
                        {{ loginMessage }}
                    </div>

                    <form @submit.prevent="login">
                        <div class="space-y-4">
                            <input v-model="email" type="email" placeholder="ایمیل"
                                   class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition" />
                            <input v-model="password" type="password" placeholder="رمز عبور"
                                   class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition" />
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <label class="flex items-center">
                                <input v-model="remember" type="checkbox"
                                       class="form-checkbox text-blue-600 rounded mr-2" />
                                <span class="text-sm text-gray-700">مرا به خاطر بسپار</span>
                                <Link href="/register" class="w-full sm:w-auto text-xs text-blue-600 px-4 py-2 text-center">
                                    ثبت‌نام
                                </Link>
                            </label>

                            <a href="#" class="text-sm text-blue-600 hover:underline">رمز را فراموش کرده‌اید؟</a>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between gap-2 mt-6">
                            <button type="button" @click="closeLoginModal"
                                    class="w-full sm:w-auto px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md transition">
                                بستن
                            </button>
                            <button type="submit"
                                    class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">
                                ورود
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage() // برای گرفتن props و CSRF

const props = defineProps({
    user: { type: Object, default: null }
})

const showUserInfo = ref(false)
const showLoginModal = ref(false)
const email = ref('')
const password = ref('')
const remember = ref(false)
const loginMessage = ref('')
const loginMessageClass = ref('')

// CSRF امن: از meta یا از props
const csrfToken = computed(() => {
    const meta = document.querySelector('meta[name="csrf-token"]')
    if (meta) return meta.content
    if (page.props.csrf_token) return page.props.csrf_token
    return ''
})

const isLoggedIn = computed(() => !!props.user)

function toggleMenuOrLogin() {
    if (isLoggedIn.value) {
        showUserInfo.value = !showUserInfo.value
    } else {
        showLoginModal.value = true
    }
}

function closeLoginModal() {
    showLoginModal.value = false
}

async function login() {
    try {
        const response = await fetch('/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.value,
                Accept: 'application/json'
            },
            body: JSON.stringify({
                email: email.value,
                password: password.value,
                remember: remember.value
            })
        })

        const data = await response.json()
        if (response.status === 200) {
            loginMessage.value = data.message || 'ورود موفقیت‌آمیز بود'
            loginMessageClass.value = 'bg-green-200 text-green-800'
            setTimeout(() => location.reload(), 1500)
        } else {
            loginMessage.value = data.message || 'خطا در ورود'
            loginMessageClass.value = 'bg-red-200 text-red-800'
        }
    } catch (err) {
        loginMessage.value = 'مشکلی در ورود پیش آمد'
        loginMessageClass.value = 'bg-red-200 text-red-800'
    }
}

function logout() {
    fetch('/logout', { method: 'GET' }).then(() => location.reload())
}

// بستن منو با کلیک بیرون
onMounted(() => {
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.relative')) {
            showUserInfo.value = false
        }
    })
})
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
.fade-enter-to, .fade-leave-from {
    opacity: 1;
}
.animate-fadeIn {
    animation: fadeIn 0.2s ease forwards;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
