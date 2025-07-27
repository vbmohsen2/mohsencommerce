<style>
    .mega-menu { display: none;}
    .mega-menu.show { display: flex; }
    .submenu { display: none; }
    .submenu.show { display: block; }
</style>
<nav class="  px-4 relative">
    <div class=" mx-auto  flex items-center justify-between">


        <div class="relative "  id="menu-wrapper">
            <button class="max-md:hidden mx-2  hover:text-green-600 py-2" id="menu-button">
                <i class="fa fa-bars  "></i><span class="px-1 font-thin"> دسته بندی </span>
            </button>
            <button class="max-md:hidden mx-2 py-2 hover:text-green-600" id="menu-button">
                <i class="far fa-file-code pl-4"><span class="px-2 font-thin"> اسمبل هوشمند</span> </i>
            </button>
            <button class="max-md:hidden mx-2 py-2 hover:text-green-600" id="menu-button">
                <i class="fa-solid  fa-file-lines pl-4"><span class="px-2 font-thin"><a href="/blog">بلاگ</a></span></i>
            </button>
            <button class="md:hidden" id="openmobilemenu" ><i class="fa  fa-bars pl-2 text-[2rem] text-gray-500 "  ></i></button>

            <!-- First Mega Menu -->
            <div class="absolute right-0 z-10  top-10 6 h-fit md:w-[200%] lg:w-[300%]  shadow-lg rounded-md bg-gray-300 text-black mega-menu p-4" id="mega-menu">
                <div class="flex">
                    <!-- Main Categories Column -->
                    <ul class="flex flex-col w-full text-nowrap ">
                        <li class="relative submenu-wrapper" data-submenu="electronics">
                            <a href="#" class="block px-4 py-2 hover:bg-gray-200">Electronics</a>
                        </li>
                        <li class="relative submenu-wrapper" data-submenu="clothing">
                            <a href="#" class="block px-4 py-2 hover:bg-gray-200">Clothing</a>
                        </li>
                        <li class="relative submenu-wrapper" data-submenu="home-kitchen">
                            <a href="#" class="block px-4 py-2 hover:bg-gray-200">Home & Kitchen</a>
                        </li>
                        <li class="relative submenu-wrapper" data-submenu="sports">
                            <a href="#" class="block px-4 py-2 hover:bg-gray-200">Sports</a>
                        </li>

                    </ul>

                    <!-- Subcategories Column -->
                    <div class="absolute flex justify-between top-0 right-40   p-4">

                        <div id="electronics"  class="submenu w-full">
                            <div class="flex justify-between w-fit">
                                <div class="flex w-1/3  flex-col">
                                    <div><a href="#" class="block px-4 py-2   hover:bg-gray-200">Phones</a></div>
                                    <div><a href="#" class="block px-4 py-2   hover:bg-gray-200">Laptops</a></div>
                                    <div><a href="#" class="block px-4 py-2   hover:bg-gray-200">Cameras</a></div>
                                </div>
                                <div class="flex w-1/2  mx-auto justify-center items-center">
                                </div>
                            </div>
                        </div>


                        <ul id="clothing" class="submenu">
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Men</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Women</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Kids</a></li>
                        </ul>

                        <ul id="home-kitchen" class="submenu">
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Furniture</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Appliances</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Decor</a></li>
                        </ul>
                        <ul id="sports" class="submenu">
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Fitness</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Outdoor</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Cycling</a></li>
                        </ul>


                    </div>
                </div>
            </div>
        </div>

        {{--        mobile menu--}}


        <div id="overlay" class="fixed inset-0 bg-green-400 bg-opacity-50 hidden"></div>

        <!-- Off-Canvas Menu -->
        <div id="offCanvas"  class=" translate-x-full  fixed top-0 w-4/6 right-0 z-40  h-full bg-white shadow-lg transform  transition-all duration-300 ">
            <div class="p-4 bg-blue-600 text-white flex justify-center">
                <div>
                    <button id="closeMenu" class="text-white hidden"></button>
                    <br>
                    <p class="text-white text-center  mx-auto">وارد شوید یا حساب کاربری ایجاد کنید</p>
                    <br>
                    <button class="w-full border-none p-4">
                        <i class="fa fa-user px-2"></i>
                        |
                        <i class="fa fa-user-plus px-2"></i>
                    </button>
                </div>
            </div>
            <ul class="p-4">
                <li><a href="#" class="block p-2 hover:bg-gray-200 ">Home</a></li>

                <!-- Expandable Item -->
                <li class="group">
                    <button class="w-full text-left p-2 bg-gray-100">
                        محصولات
                    </button>
                    <ul class="max-h-0 overflow-hidden transition-all duration-500 group-hover:max-h-[100px] pl-4">
                        <li><a href="#" class="block p-2 hover:bg-gray-200">محصول ۱</a></li>
                        <li><a href="#" class="block p-2 hover:bg-gray-200">محصول ۲</a></li>
                    </ul>
                </li>

                <li><a href="#" class="block p-2 hover:bg-gray-200">About</a></li>
                <li><a href="#" class="block p-2 hover:bg-gray-200">Contact</a></li>
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
