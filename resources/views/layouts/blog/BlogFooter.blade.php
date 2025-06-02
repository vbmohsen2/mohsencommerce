<footer class=" flex flex-col min-h-20  mt-10 container mx-auto  ">
    <ul class="flex w-full -ml-2 -mr-2  ">
        <li class="flex items-center justify-center lg:justify-start w-1/5 text-white bg-gradient-to-l from-red-700 to-red-400 py-2">
            <i class="fab fa-instagram text-2xl p-3 w-full mx-2 lg:w-1/5 text-center bg-red-600 bg-opacity-30 shadow-inner shadow-red-900 rounded-md"></i>

            <!-- متن فقط در صفحه‌های بزرگ نمایش داده شود -->
            <div class="flex-col hidden lg:flex mr-3">
                <p>اینستاگرام</p>
                <div class="text-nowrap">ما را دنبال کنید</div>
            </div>
        </li>
        <li class="flex items-center justify-center lg:justify-start w-1/5 text-white bg-gradient-to-l from-red-700 to-red-400 py-2">
            <i class="fab fa-telegram text-2xl p-3 w-full mx-2 lg:w-1/5 text-center bg-red-600 bg-opacity-30 shadow-inner shadow-red-900 rounded-md"></i>

            <!-- متن فقط در صفحه‌های بزرگ نمایش داده شود -->
            <div class="flex-col hidden lg:flex mr-3">
                <p>اینستاگرام</p>
                <div class="text-nowrap">ما را دنبال کنید</div>
            </div>
        </li>
        <li class="flex items-center justify-center lg:justify-start w-1/5 text-white bg-gradient-to-l from-red-700 to-red-400 py-2">
            <i class="fab fa-whatsapp text-2xl p-3 w-full mx-2 lg:w-1/5 text-center bg-red-600 bg-opacity-30 shadow-inner shadow-red-900 rounded-md"></i>

            <!-- متن فقط در صفحه‌های بزرگ نمایش داده شود -->
            <div class="flex-col hidden lg:flex mr-3">
                <p>اینستاگرام</p>
                <div class="text-nowrap">ما را دنبال کنید</div>
            </div>
        </li>
        <li class="flex items-center justify-center lg:justify-start w-1/5 text-white bg-gradient-to-l from-red-700 to-red-400 py-2">
            <i class="fab fa-whatsapp text-2xl p-3 w-full mx-2 lg:w-1/5 text-center bg-red-600 bg-opacity-30 shadow-inner shadow-red-900 rounded-md"></i>

            <!-- متن فقط در صفحه‌های بزرگ نمایش داده شود -->
            <div class="flex-col hidden lg:flex mr-3">
                <p>اینستاگرام</p>
                <div class="text-nowrap">ما را دنبال کنید</div>
            </div>
        </li>
        <li class="flex items-center justify-center lg:justify-start w-1/5 text-white bg-gradient-to-l from-red-700 to-red-400 py-2">
            <i class="fab fa-whatsapp text-2xl p-3 w-full mx-2 lg:w-1/5 text-center bg-red-600 bg-opacity-30 shadow-inner shadow-red-900 rounded-md"></i>

            <!-- متن فقط در صفحه‌های بزرگ نمایش داده شود -->
            <div class="flex-col hidden lg:flex mr-3">
                <p>اینستاگرام</p>
                <div class="text-nowrap">ما را دنبال کنید</div>
            </div>
        </li>
    </ul>

    <div class="flex mt-10 mx-auto container text-sm">
        <div class="w-1/4 mx-2">
          <p><strong>آخرین دیدگاه ها</strong></p>
            <ul class="flex flex-col">
                <li>
                        دیدگاه
                </li>
                <li>
                    دیدگاه
                </li>
            </ul>
        </div>
        <div class="w-1/4 mx-2">
            <p><strong>آخرین دیدگاه ها</strong></p>
            <ul class="flex flex-col">
                @php
                    $latestPosts = \App\Models\Posts::latest()->take(3)->get();
                @endphp
                @foreach($latestPosts as $p)
                <li class="pb-2">
                    <a href="./blog/{{$p->slug}}">
                    <p> {{$p->title}}</p>
                    </a>
                </li>
                @endforeach

            </ul>
        </div>
    </div>

    <hr class="border border-gray-300">

    <div class="flex justify-center">
        <a class="px-4" href="">تبلیغات</a>

        <a href="">درباره ما</a>
    </div>
</footer>
