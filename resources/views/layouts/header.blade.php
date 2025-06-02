<header class=" w-full box-border mx-50  px-4 items-center  mt-5 pb-4 h-fit   shadow-xl ">
    <div class="flex flex-col">
        <div class="flex justify-between flex-wrap   items-center  ">
            {{--        logo--}}
            <div class="flex-grow-1 sm:order-1 order-2 w-20 md:justify-self-center">
                <img src="{{asset('images/logo.svg')}}" alt="">
            </div>
            {{--search--}}
            <div class="flex grow sm:order-2 order-4 max-sm:w-full justify-center  ">
                <div class="w-3/4 max-sm:w-full ml-5 mb-4 m-2  flex rounded-lg bg-gray-300">
                    <img src="{{asset('images/search icon.svg')}}" class="w-6 h-6 m-2 items-center" alt="">
                    <input
                        class="border-0 bg-gray-300 w-full  rounded-lg focus:border-none focus:outline-none   shadow-x"
                        placeholder="جستجو..." type="text" name="" id="">

                </div>
            </div>
            {{--    login and cart--}}
            <div class="flex  w-1/5  pb-3 sm-order-3 order-3  px-4 space-x-2 justify-end   ">
                <button onclick="openLoginModal()" class="pt-2 px-2">
                    <img src="{{asset('images/user-01.svg')}} " class="max-w-8  sm:max-w-10" alt="">
                </button>

                <button class="flex justify-center items-center">
                    <div class="relative py-2">
                        <div class="t-0 absolute max-sm:left-4 left-6">


                                <p class="flex h-2  w-1   items-center justify-center rounded-full  p-3 bg-red-300  text-white">
                                {{$carts->count()}}
                                </p>
                        </div>
                        <img src="{{ asset('images/shoppingcart.svg') }}" class="max-w-8  sm:max-w-10" alt="">
                    </div>

                </button>

            </div>
            <div class="order-1 sm:order-4 sm:w-full">
                @include('components.navbar')
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
                    setTimeout(() => window.location.href = "/", 1000); // هدایت به صفحه اصلی پس از موفقیت
                }
            })
            .catch(error => {
                console.error("خطا در درخواست:", error);
                messageDiv.textContent = "مشکلی در ورود پیش آمد. لطفاً دوباره تلاش کنید.";
                messageDiv.className = "bg-red-200 text-red-800 p-2 rounded mb-2";
                messageDiv.classList.remove("hidden");
            });
    });
</script>
