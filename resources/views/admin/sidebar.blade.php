<!-- resources/views/layouts/admin-sidebar.blade.php -->
<aside class="h-screen sticky top-0 w-64 bg-gray-900 text-white flex flex-col shadow-xl">
    <div class="p-6 text-2xl font-bold border-b border-gray-700">
        پنل ادمین
    </div>
    <nav class="flex-1 p-4 space-y-2">
        <a href="" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            🏠 داشبورد
        </a>
        <a href="{{route('admin.products')}}" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            📦 محصولات
        </a>
        <a href="" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            📋 سفارشات
        </a>
        <a href="{{route('admin.categories')}}" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            🗂 دسته بندی ها
        </a>
        <a href="" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            👥 کاربران
        </a>
        <a href="{{route('admin.attributes.templates')}}" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            🧩 قالب مشخصات
        </a>
        <hr>
        بلاگ
        <a href="{{route('admin.blog.categories')}}" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            📝 دسته بندی بلاگ
        </a>

        <a href="{{route('admin.blog.posts')}}" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            ✉️  پست ها
        </a>

    </nav>
    <div class="p-4 border-t border-gray-700">
        <a href="{{ route('logout') }}" class="block px-4 py-2 rounded-lg hover:bg-red-600 transition text-center">
            🚪 Logout
        </a>
    </div>

</aside>
