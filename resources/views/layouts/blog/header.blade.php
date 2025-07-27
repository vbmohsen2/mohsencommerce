<header class="flex fixed top-0 z-40 bg-white w-full    px-4 items-center  pt-5 pb-4 h-fit   shadow-xl  ">
    <div class=" container flex  flex-col w-full justify-between mx-auto">
        <div class="flex justify-between    items-center  ">
            {{--        logo--}}
            <div  class="flex-grow-1 sm:order-1 order-2 w-20 md:justify-self-center">
                <img src="{{asset('images/romanologo.jpg')}}"  alt="">
            </div>
                       {{--    search and login--}}
            <div  class="flex    sm-order-3 order-3  px-4 space-x-4 justify-end   " >

                <div id="headerapp">
                <searchposts></searchposts>
                </div>
                <button id="loginbtn"  @auth() title="{{auth()->user()->name}}" onclick="openUserInfoModal()" @endauth onclick="openLoginModal()"  class="pt-2 px-2">
                    <i class="fa fa-sign-in text-[1.3rem]   sm:text-base text-gray-500"></i>
                </button>
                @auth()
                    <div id="userInfoModal"
                         class="hidden sm:absolute sm:left-20 sm:mt-2 sm:w-48 top-16 bg-white border rounded shadow-2xl z-50 p-4 max-sm:hidden">
                        <ul class="space-y-2">
                            <li class="cursor-pointer">
                                <a href="/user/dashboard">  حساب کاربری</a>
                            </li>
                            <li class="cursor-pointer">
                                <a href="/user/orders">سفارشات</a>
                            </li>
                            <li class="cursor-pointer">
                                <a href="/user/addresses">آدرس ها</a>
                            </li>
                            <li class="cursor-pointer" onclick="document.getElementById('logout-form').submit();">
                                خروج
                            </li>

                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="get" class="hidden">
                            @csrf
                        </form>
                    </div>
                    <script>
                        const userInfoModal= document.getElementById("userInfoModal");
                        function openUserInfoModal(){
                            userInfoModal.classList.remove("hidden");
                        }
                        document.addEventListener('click', function (e) {
                            if (!document.getElementById('loginbtn').contains(e.target)) {
                                userInfoModal.classList.add('hidden');

                            }
                        });

                    </script>
                @endauth

                <!-- Modal Overlay -->
                <div id="loginModal"
                     class="hidden fixed inset-0 z-50  items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm transition-opacity duration-300">

                    <!-- Modal Box -->
                    <div class="bg-white w-full max-w-md mx-4 p-6 rounded-2xl shadow-xl border border-gray-200 animate-fadeIn">
                        <span class="text-2xl font-bold text-center text-gray-800 mb-6">ورود به حساب کاربری</span>

                        <!-- پیام -->
                        <div id="loginMessage" class="hidden text-center p-3 mb-4 rounded font-medium"></div>

                        <!-- فرم ورود -->
                        <form method="POST" id="loginForm" action="{{ route('login') }}">
                            @csrf
                            <div class="space-y-4">
                                <input type="email" name="email" id="email"
                                       placeholder="ایمیل"
                                       class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                                <input type="password" name="password" id="password"
                                       placeholder="رمز عبور"
                                       class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            </div>

                            <div class="flex items-center justify-between mt-4">
                                <label class="flex items-center">
                                    <input type="checkbox" id="remember" class="form-checkbox text-blue-600 rounded mr-2">
                                    <span class="text-sm text-gray-700">مرا به خاطر بسپار</span>
                                    <a href="{{ route('register') }}"
                                       class="w-full sm:w-auto text-xs text-blue-600 px-4 py-2 text-center ">
                                        ثبت‌نام
                                    </a>
                                </label>

                                <a href="#" class="text-sm text-blue-600 hover:underline">رمز را فراموش کرده‌اید؟</a>
                            </div>

                            <div class="flex flex-col sm:flex-row justify-between gap-2 mt-6">
                                <button type="button"
                                        onclick="closeModal()"
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
            </div>
            <div class="order-1 sm:order-2 sm:w-full">
                @include('layouts.blog.navbar')
            </div>
        </div>


    </div>

</header>

<script>
    function openLoginModal() {
        document.getElementById("loginModal").classList.remove("hidden");
        document.getElementById('loginModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById("loginModal").classList.add("hidden");
        document.getElementById("loginModal").classList.remove("flex");
    }

    document.getElementById("loginForm").addEventListener("submit", function (event) {
        event.preventDefault();

        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;
        let remember = document.getElementById("remember").checked;
        let messageDiv = document.getElementById("loginMessage");

        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let loginUrl = "{{ route('login') }}"; // این مقدار در Blade باید به آدرس لاگین ترجمه شود

        fetch(loginUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                "Accept": "application/json"
            },
            body: JSON.stringify({
                email: email,
                password: password,
                remember: remember
            })
        })
            .then(response => {
                const status = response.status;
                return response.json().then(data => ({ data, status }));
            })
            .then(({ data, status }) => {
                messageDiv.textContent = data.message || "عملیات انجام شد.";
                messageDiv.className = (status === 200)
                    ? "bg-green-200 text-green-800 p-2 rounded mb-2"
                    : "bg-red-200 text-red-800 p-2 rounded mb-2";
                messageDiv.classList.remove("hidden");

                if (status === 200) {
                    // بستن مودال (اگر وجود دارد)
                    const modal = document.getElementById("loginModal");
                    if (modal) {
                        setTimeout(() => {
                            closeModal()
                            location.reload();
                        }, 2000);
                    } else {
                        setTimeout(() => {
                            // window.location.href = "/";
                        }, 2000);
                    }
                }
                // اگر 401 یا خطای دیگر بود، فقط پیغام می‌ماند
            })
            .catch(error => {
                console.error("خطا در درخواست:", error);
                messageDiv.textContent = "مشکلی در ورود پیش آمد. لطفاً دوباره تلاش کنید.";
                messageDiv.className = "bg-red-200 text-red-800 p-2 rounded mb-2";
                messageDiv.classList.remove("hidden");
            });
    });

    // cart item show

    // document.addEventListener('DOMContentLoaded', function () {
    //     const toggle = document.getElementById('cart-toggle');
    //     const dropdown = document.getElementById('cart-dropdown');
    //
    //     toggle.addEventListener('click', function (e) {
    //         e.stopPropagation();
    //         dropdown.classList.toggle('hidden');
    //     });
    //
    //     document.addEventListener('click', function (e) {
    //         const wrapper = document.getElementById('cart-wrapper');
    //         if (!wrapper.contains(e.target)) {
    //             dropdown.classList.add('hidden');
    //         }
    //     });
    // });


</script>
