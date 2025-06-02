<header class="flex fixed top-0 z-50 bg-white w-full    px-4 items-center  pt-5 pb-4 h-fit   shadow-xl  ">
    <div class=" container flex  flex-col w-full justify-between mx-auto">
        <div class="flex justify-between    items-center  ">
            {{--        logo--}}
            <div  class="flex-grow-1 sm:order-1 order-2 w-20 md:justify-self-center">
                <img src="{{asset('images/logo.svg')}}"  alt="">
            </div>

            {{--    search and login--}}
            <div class="flex  w-1/5  pb-3 sm-order-3 order-3  px-4 space-x-2 justify-end   " >
                <div class="pt-2 px-2">
                   <i class="fa fa-search text-[1.8rem] sm:text-base text-gray-500"></i>
                </div>
                <div class="pt-2 px-2">
                    <i class="fa fa-sign-in text-[1.8rem]  sm:text-base text-gray-500"></i>
                </div>


            </div>
            <div class="order-1 sm:order-2 sm:w-full">
                @include('layouts.blog.navbar')
            </div>
        </div>


    </div>

</header>

