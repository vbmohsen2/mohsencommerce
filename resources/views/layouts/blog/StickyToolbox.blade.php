    <ul id="floating-menu" class="fixed bottom-4 right-4 w-10 z-50 opacity-0 translate-y-5 transition-all duration-500">

        <li class="relative group flex justify-center">
            <a href="" class="flex items-center">
                <!-- آیکون -->
                <i class=" shadow-md fa fa-headset my-1 bg-white rounded-2xl p-3 hover:bg-blue-400"></i>

                <!-- متن کناری با انیمیشن -->
                <span class="absolute right-full top-1/2 -translate-y-1/2 translate-x-[-10px]
                         opacity-0 mr-2 px-3 py-1 bg-gray-800 text-white text-sm rounded
                         transition-all duration-500 group-hover:translate-x-0 group-hover:opacity-100 whitespace-nowrap">
                تماس
            </span>
            </a>
        </li>
    <li class="relative group flex justify-center">
        <a href="" class="flex items-center">
            <!-- آیکون -->
            <i class=" shadow-md fab fa-telegram my-2 bg-white rounded-2xl p-3 hover:bg-blue-400"></i>

            <!-- متن کناری با انیمیشن -->
            <span class="absolute right-full top-1/2 -translate-y-1/2 translate-x-[-10px]
                         opacity-0 mr-2 px-3 py-1 bg-gray-800 text-white text-sm rounded
                         transition-all duration-500 group-hover:translate-x-0 group-hover:opacity-100 whitespace-nowrap">
                تلگرام
            </span>
        </a>
    </li>
    <li  class="relative group flex justify-center scroll-to-top">
        <a href="" class="flex items-center">
            <!-- آیکون -->
            <i class=" shadow-md fa fa-arrow-up my-2 bg-white rounded-2xl p-3 hover:bg-blue-400"></i>

            <!-- متن کناری با انیمیشن -->
            <span  class="absolute right-full top-1/2 -translate-y-1/2 translate-x-[-10px]
                         opacity-0 mr-2 px-3 py-1 bg-gray-800 text-white text-sm rounded
                         transition-all duration-500 group-hover:translate-x-0 group-hover:opacity-100 whitespace-nowrap">
                تلگرام
            </span>
        </a>
    </li>

</ul>
<script>
    window.addEventListener("scroll", function () {
        let menu = document.getElementById("floating-menu");
        if (window.scrollY > 20) {
            menu.classList.add("opacity-100", "translate-y-0");
            menu.classList.remove("opacity-0", "translate-y-5");
        } else {
            menu.classList.add("opacity-0", "translate-y-5");
            menu.classList.remove("opacity-100", "translate-y-0");
        }
    });


    document.querySelector(".scroll-to-top").addEventListener("click", function (e) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
</script>
