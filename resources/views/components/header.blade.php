<header class=" w-full bg-white fixed top-0 left-0 z-50 box-border mx-auto  px-4 items-center  pt-5 pb-4 h-fit   shadow-xl  ">
    <div class="flex flex-col">
        <div class="flex justify-between flex-wrap  items-center  ">
            {{--        logo--}}
            <div class="flex-grow-1 sm:order-1 order-2 w-20 md:justify-self-center">
                <img src="{{asset('images/logo.svg')}}" alt="">
            </div>

            {{--search--}}
            <div class="flex grow sm:order-2 order-4 max-sm:w-full justify-center  ">
                <div id="app" class="w-3/4 max-sm:w-full ml-5 mb-4 m-2  flex rounded-lg bg-gray-300">
                    <img src="{{asset('images/search icon.svg')}}" class="w-6 h-6 m-2 items-center" alt="">
                    {{--                    <input--}}
                    {{--                        class=" bg-gray-300 w-full  rounded-lg focus:outline-none   shadow-x"--}}
                    {{--                        placeholder="جستجو..." type="text" name="" id="" >--}}
                    <productsearch></productsearch>

                </div>
            </div>
            {{--    login and cart--}}
            <div class="flex  w-1/5  pb-3 sm-order-3 order-3  px-4 space-x-2 justify-end   ">
                <button @auth() title="{{auth()->user()->name}}" @endauth onclick="openLoginModal()" class="pt-2 px-2">
                    <img src="{{asset('images/user-01.svg')}} " class="max-w-8  sm:max-w-10" alt="">
                </button>

                {{--                بعدا وقتی خواستم دراپ داون برای کاربر درست کنم اینو درست میکنم--}}
                {{--                <button onclick="openLoginModal()" class="pt-2 px-2 group relative">--}}
                {{--                    <img src="{{ asset('images/user-01.svg') }}" class="max-w-8 sm:max-w-10" alt="User Icon">--}}

                {{--                    @auth--}}
                {{--                        <!-- نام کاربری که به طور پیش‌فرض مخفی است -->--}}
                {{--                        <div class="absolute left-0 right-0 text-center bg-white shadow-md p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 mt-2">--}}
                {{--                            {{ Auth::user()->name }}--}}
                {{--                        </div>--}}
                {{--                    @endauth--}}
                {{--                </button>--}}
                {{--                --}}


                <div class="relative" id="cart-wrapper">
                    {{-- آیکن سبد خرید --}}
                    <button id="cart-toggle" class="flex justify-center items-center focus:outline-none">
                        <div class="relative py-2">
                            <div class="t-0 absolute max-sm:left-4 left-6">
                                @if($cartCount)
                                    <p class="flex h-2 w-1 items-center justify-center rounded-full p-3 bg-red-300 text-white">
                                        {{ $cartCount }}
                                    </p>
                                @endif
                            </div>
                            <img src="{{ asset('images/shoppingcart.svg') }}" class="max-w-8 sm:max-w-10" alt="">
                        </div>
                    </button>

                    {{-- DROPDOWN (فقط در صفحات بزرگ) --}}
                    <div id="cart-dropdown"
                         class="hidden sm:absolute sm:-left-2 sm:mt-2 sm:w-96 bg-white border rounded shadow-2xl z-50 p-4 max-sm:hidden">
                        @include('components.cart-content')
                    </div>

                    {{-- OFFCANVAS (فقط در صفحات کوچک) --}}
                    <div id="cart-offcanvas"
                         class="hidden fixed top-0 left-0 w-80 h-full bg-white z-50 shadow-lg overflow-y-auto sm:hidden transition-transform +translate-x-full p-2"
                         style="transition: all 0.3s ease;">
                        <div class="p-4 flex justify-between items-center border-b">
                            <h2 class="text-xl font-bold">سبد خرید</h2>
                            <button id="cart-close" class="text-xl">✖️</button>
                        </div>
                        @include('components.cart-content')
                    </div>
                </div>


            </div>
            <div class="order-1 sm:order-4 md:mx-auto container w-1/5 sm:w-full ">
                <x-navbar></x-navbar>
            </div>
        </div>


    </div>
    <div id="loginModal" class="hidden fixed inset-0  items-center justify-center z-50 bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-semibold mb-4 text-center">ورود به حساب</h2>

            <!-- پیام خطا -->
            <div id="loginMessage" class="hidden text-center p-2 mb-3 rounded"></div>

            <!-- فرم ورود -->
            <form method="POST" id="loginForm" action="{{ route('login') }}">
                @csrf
                <input type="email" name="email" id="email" placeholder="ایمیل" class="w-full border p-2 rounded mb-2">
                <input type="password" name="password" id="password" placeholder="رمز عبور"
                       class="w-full border p-2 rounded mb-4">
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="remember" class="mr-2">
                    <label for="remember">مرا به خاطر بسپار</label>
                </div>
                <div class="flex justify-between">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-400 text-white rounded-md">
                        بستن
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                        ورود
                    </button>
                </div>
            </form>
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

        // دریافت CSRF Token از متا تگ
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // آدرس صحیح مسیر ورود
        let loginUrl = "{{ route('login') }}";

        fetch(loginUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                "Accept": "application/json" // اطمینان از دریافت پاسخ JSON
            },
            body: JSON.stringify({
                email: email,
                password: password,
                remember: remember
            })
        })
            .then(response => response.json().catch(() => {
                throw new Error("پاسخ JSON نامعتبر است")
            }))
            .then(data => {
                messageDiv.textContent = data.message;
                messageDiv.className = data.success ? "bg-green-200 text-green-800 p-2 rounded mb-2" : "bg-red-200 text-red-800 p-2 rounded mb-2";
                messageDiv.classList.remove("hidden");

                if (data.success) {
                    window.location.href = "/"; // هدایت به صفحه اصلی پس از موفقیت
                }
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('cart-toggle');
        const dropdown = document.getElementById('cart-dropdown');
        const offcanvas = document.getElementById('cart-offcanvas');
        const closeBtn = document.getElementById('cart-close');

        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            if (window.innerWidth >= 640) {
                dropdown.classList.toggle('hidden');
            } else {
                offcanvas.classList.remove('hidden');
                offcanvas.classList.remove('-translate-x-full');
            }
        });

        document.addEventListener('click', function (e) {
            if (!document.getElementById('cart-wrapper').contains(e.target)) {
                dropdown?.classList.add('hidden');
                offcanvas?.classList.add('-translate-x-full');
                setTimeout(() => {
                    offcanvas?.classList.add('hidden');
                }, 300);
            }
        });

        closeBtn?.addEventListener('click', function () {
            offcanvas.classList.add('-translate-x-full');
            setTimeout(() => {
                offcanvas.classList.add('hidden');
            }, 300);
        });
    });
</script>
