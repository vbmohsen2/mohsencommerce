<!-- resources/views/Layouts/admin-sidebar.blade.php -->
<style>
    .mega-menu {
        display: none;
    }

    .mega-menu.show {
        display: flex;
    }

    .submenu {
        display: none;
    }

    .submenu.show {
        display: block;
    }
</style>

@php
    use App\Models\Category;
    $categories = Category::where('is_active',"1")->get();
       $parents = $categories->whereNull('parent_id')->merge($categories->where('parent_id', 0));
       $children = $categories->whereNotIn('id', $parents->pluck('id'));
@endphp
<nav class="  px-4 relative">
    <div class=" mx-auto  flex items-center justify-between">


        <div class="relative text-lg" id="menu-wrapper">

            <button class="" id="openmobilemenu"><i class="fa fa-bars pl-2 "></i></button>

            <!-- First Mega Menu -->


        {{--        mobile menu--}}


        <div id="overlay" class="fixed inset-0 z-40 bg-green-400 bg-opacity-50 hidden"></div>

        <!-- Off-Canvas Menu -->
        <div id="offCanvas"
             class=" translate-x-full  fixed top-0 w-1/2 sm:w-1/3 md:w-1/4    right-0 z-40  h-full bg-white shadow-lg transform  transition-all duration-300 overflow-scroll ">
            <div class="p-4 bg-blue-600 text-white flex justify-between">
                <span>
                    @auth()
                        {{auth()->user()->name}}
                    @endauth
                </span>
                <button id="closeMenu" class="text-white">&times;</button>
            </div>
            <aside>
                <div class="p-6 text-2xl font-bold border-b border-gray-700 ">
                    پنل ادمین
                </div>
                <nav class="flex-1 p-4 space-y-2">
                    <a href="" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                        🏠 داشبورد
                    </a>
                    <a href="{{route('admin.products')}}" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                        📦 محصولات
                    </a>
                    <a href="{{route('admin.orders')}}" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                        📋 سفارشات
                    </a>
                    <a href="{{route('admin.categories')}}" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                        🗂 دسته بندی ها
                    </a>
                    <a href="{{route('admin.users')}}" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">
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

        </div>


    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", () => {

        // mobile menu

        const openMenu = document.getElementById('openmobilemenu');
        const closeMenu = document.getElementById('closeMenu');
        const offCanvas = document.getElementById('offCanvas');
        const overlay = document.getElementById('overlay');

        // Open menu
        openMenu.addEventListener('click', () => {
            offCanvas.classList.remove('translate-x-full');

            overlay.classList.remove('hidden');
        });

        // Close menu
        const close = () => {
            offCanvas.classList.add('translate-x-full');

            overlay.classList.add('hidden');
        };

        closeMenu.addEventListener('click', close);
        overlay.addEventListener('click', close);


        // lg menu

        const menuButton = document.getElementById("menu-button");
        const megaMenu = document.getElementById("mega-menu");
        const subMenus = document.querySelectorAll(".submenu");
        const submenuWrappers = document.querySelectorAll(".submenu-wrapper");





        submenuWrappers.forEach(wrapper => {
            wrapper.addEventListener("mouseenter", () => {
                subMenus.forEach(sub => sub.classList.remove("show"));
                const submenuId = wrapper.getAttribute("data-submenu");
                document.getElementById(submenuId).classList.add("show");
            });
        });
    });
</script>
{{--<aside>--}}
{{--    <div class="p-6 text-2xl font-bold border-b border-gray-700">--}}
{{--        پنل ادمین--}}
{{--    </div>--}}
{{--    <nav class="flex-1 p-4 space-y-2">--}}
{{--        <a href="" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">--}}
{{--            🏠 داشبورد--}}
{{--        </a>--}}
{{--        <a href="{{route('admin.products')}}" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">--}}
{{--            📦 محصولات--}}
{{--        </a>--}}
{{--        <a href="" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">--}}
{{--            📋 سفارشات--}}
{{--        </a>--}}
{{--        <a href="{{route('admin.categories')}}" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">--}}
{{--            🗂 دسته بندی ها--}}
{{--        </a>--}}
{{--        <a href="" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">--}}
{{--            👥 کاربران--}}
{{--        </a>--}}
{{--        <a href="{{route('admin.attributes.templates')}}" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">--}}
{{--            🧩 قالب مشخصات--}}
{{--        </a>--}}
{{--        <hr>--}}
{{--        بلاگ--}}
{{--        <a href="{{route('admin.blog.categories')}}" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">--}}
{{--            📝 دسته بندی بلاگ--}}
{{--        </a>--}}

{{--        <a href="{{route('admin.blog.posts')}}" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">--}}
{{--            ✉️  پست ها--}}
{{--        </a>--}}

{{--    </nav>--}}
{{--    <div class="p-4 border-t border-gray-700">--}}
{{--        <a href="{{ route('logout') }}" class="block px-4 py-2 rounded-lg hover:bg-red-600 transition text-center">--}}
{{--            🚪 Logout--}}
{{--        </a>--}}
{{--    </div>--}}

{{--</aside>--}}
