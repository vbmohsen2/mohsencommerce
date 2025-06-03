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
            <button class="max-md:hidden mx-2  hover:text-green-600 py-2" id="menu-button">
                <i class="fa fa-bars pl-2 "></i><span class="px-2 font-thin"> دسته بندی </span>
            </button>
            <button class="max-md:hidden mx-2 py-2 hover:text-green-600" id="menu-button">
                <i class="far fa-file-code pl-4"><span class="px-2 font-thin"> اسمبل هوشمند</span> </i>
            </button>
            <button class="max-md:hidden mx-2 py-2 hover:text-green-600" id="menu-button">
                <i class="fa-solid  fa-file-lines pl-4"><span class="px-2 font-thin"><a href="/blog">بلاگ</a></span></i>
            </button>
            <button class="md:hidden" id="openmobilemenu"><i class="fa fa-bars pl-2 "></i></button>

            <!-- First Mega Menu -->
            <div
                class="absolute right-0 z-10  top-10 6 h-fit md:w-[200%] lg:w-[300%]  shadow-lg rounded-md bg-gray-300 text-black mega-menu p-4"
                id="mega-menu">
                <div class="flex">
                    <!-- Main Categories Column -->
                    <ul class="flex flex-col w-full text-nowrap ">

                        @foreach($parents as $parent)
                            <li class="relative submenu-wrapper" data-submenu="submenu-{{ $parent->id }}">
                                <a href="#" class="block px-4 py-2 hover:bg-gray-200">{{ $parent->name }}</a>
                            </li>
                        @endforeach


                    </ul>

                    <!-- Subcategories Column -->
                    <div class="absolute flex justify-between top-0 right-40   p-4">

                        <div id="electronics" class="submenu w-full">
                            <div class="flex justify-between w-fit">
                                <div class="flex w-1/3  flex-col">
                                    <div><a href="#" class="block px-4 py-2   hover:bg-gray-200">Phones</a></div>
                                    <div><a href="#" class="block px-4 py-2   hover:bg-gray-200">Laptops</a></div>
                                    <div><a href="#" class="block px-4 py-2   hover:bg-gray-200">Cameras</a></div>
                                </div>
                                <div class="flex w-1/2  mx-auto justify-center items-center">
                                    <img src="images/slides/Accessories pc v1 copy-1600x400.jpg" alt="">
                                </div>
                            </div>
                        </div>


                        <ul id="submenu" class="submenu">

                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-200"></a>
                            </li>

                        </ul>
                        @foreach($parents as $parent)
                            <div id="submenu-{{$parent->id}}" class="submenu w-full">
                                <div class="flex justify-between w-fit">
                                    <div class="flex w-1/3  flex-col">
                                        @foreach($children->where('parent_id', $parent->id) as $child)
                                            <div><a href="#"
                                                    class="block px-4 py-2   hover:bg-gray-200">{{$child->name}}</a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="flex w-1/2  mx-auto justify-center items-center">
                                        <img src="images/slides/Accessories pc v1 copy-1600x400.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{--                        <ul id="home-kitchen" class="submenu">--}}
                        {{--                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Furniture</a></li>--}}
                        {{--                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Appliances</a></li>--}}
                        {{--                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Decor</a></li>--}}
                        {{--                        </ul>--}}


                    </div>
                </div>
            </div>
        </div>

        {{--        mobile menu--}}


        <div id="overlay" class="fixed inset-0 z-40 bg-green-400 bg-opacity-50 hidden"></div>

        <!-- Off-Canvas Menu -->
        <div id="offCanvas"
             class=" translate-x-full  fixed top-0 w-1/2 right-0 z-40  h-full bg-white shadow-lg transform  transition-all duration-300 ">
            <div class="p-4 bg-blue-600 text-white flex justify-between">
                <span>Menu</span>
                <button id="closeMenu" class="text-white">&times;</button>
            </div>
            <ul class="p-4">
                <li><a href="#" class="block p-2 hover:bg-gray-200">خانه</a></li>

                @foreach ($categories->where('parent_id', null) as $parent)
                    @php
                        $children = $categories->where('parent_id', $parent->id);
                    @endphp

                    @if ($children->isNotEmpty())
                        <!-- دسته‌بندی با زیرمجموعه -->
                        <li class="group">
                            <button class="w-full text-right p-2 bg-gray-100">
                                {{ $parent->name }}
                            </button>
                            <ul class="max-h-0 overflow-hidden transition-all duration-500 group-hover:max-h-[200px] pr-4">
                                @foreach ($children as $child)
                                    <li><a href="#" class="block p-2 hover:bg-gray-200">{{ $child->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <!-- دسته‌بندی بدون زیرمجموعه -->
                        <li><a href="#" class="block p-2 hover:bg-gray-200">{{ $parent->name }}</a></li>
                    @endif
                @endforeach

                <li><a href="#" class="block p-2 hover:bg-gray-200">درباره ما</a></li>
                <li><a href="#" class="block p-2 hover:bg-gray-200">تماس با ما</a></li>
            </ul>
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


        menuButton.addEventListener("mouseenter", () => {
            megaMenu.classList.add("show");
        });
        megaMenu.addEventListener("mouseleave", () => {
            megaMenu.classList.remove("show");
            subMenus.forEach(sub => sub.classList.remove("show"));
        });

        submenuWrappers.forEach(wrapper => {
            wrapper.addEventListener("mouseenter", () => {
                subMenus.forEach(sub => sub.classList.remove("show"));
                const submenuId = wrapper.getAttribute("data-submenu");
                document.getElementById(submenuId).classList.add("show");
            });
        });
    });
</script>
