<!-- src/views/user/UserPanel.vue -->
<template>
    <div class="flex flex-col pt-8 md:flex-row min-h-screen">
        <!-- Sidebar -->
        <aside class="bg-gray-800 text-white w-full h-fit md:w-64 p-4">
            <h2 class="text-xl font-bold mb-6">پنل کاربری</h2>
            <nav class="space-y-2">
                <RouterLink to="/user/dashboard" class="block px-3 py-2 rounded hover:bg-gray-700" active-class="bg-gray-700">داشبورد</RouterLink>
                <RouterLink to="/user/addresses" class="block px-3 py-2 rounded hover:bg-gray-700" active-class="bg-gray-700">آدرس‌ها</RouterLink>
                <RouterLink to="/user/orders" class="block px-3 py-2 rounded hover:bg-gray-700" active-class="bg-gray-700">سفارش‌ها</RouterLink>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 bg-gray-50 p-4">
            <RouterView />
        </main>
    </div>
</template>

