<div class="flex flex-col md:flex-row pt-5 flex-nowrap">

    @include('components.productimageview')

{{--    info--}}
    <div class=" flex justify-between md:w-3/5 md:order-2  ">


        <div class="w-full ">
    @php
        $category = \App\Models\Category::find($product->category_id);
        $categories = [];

        while ($category && $category->parent_id != $category->id) {
            $categories[] = $category; // ذخیره دسته فعلی
            $category = \App\Models\Category::find($category->parent_id); // دریافت دسته بالاتر
        }

        // اضافه کردن بالاترین دسته (که parent_id == id دارد)
        if ($category) {
            $categories[] = $category;
        }
    @endphp

    <span>فروشگاه اینترنتی</span>
    @foreach (array_reverse($categories) as $cat)
        /
        <span>{{ $cat->name }}</span>
    @endforeach

        <div class="my-4 w-full justify-between "><h2 class="text-4xl">{{$product->name}}</h2></div>


<div class="flex w-full md:justify-between   ">
    @include('components.productmaininfo')

            {{--    buy and price sector--}}


        <div class="fixed  bottom-2 right-0  z-10 md:flex md:flex-col md:relative  w-full px-2">
            @if($product->discount_price!=0)
                <div class="hidden  justify-between md:block text-sm md:py-2  mx-auto "><span class="line-through mx-4">{{number_format($product->price)}}</span>
                    <span class="rounded-lg bg-red-500 px-1">
                        {{  number_format((($product->price - $product->discount_price) / $product->price) * 100) }} %
                    </span>
                </div>
                <div class="hidden md:block text-2xl md:py-2 mx-auto "><h1>{{number_format($product->discount_price)}} </h1></div>
            @else
            <div class="hidden md:block text-2xl md:py-2 mx-auto"><h1>{{number_format($product->price)}}  <span class="text-sm ">تومان</span>  </h1> </div>
            @endif
{{--            <div class="flex justify-center py-2 items-center w-1/2 mx-auto">--}}
{{--                <label class="hidden md:block">تعداد</label>--}}
{{--                <div class="md:flex hidden justify-between flex-grow items-center border rounded-md">--}}
{{--                    <span class="px-2">+</span>--}}
{{--                    <input class="w-auto  border-none text-center p-2" value="1" size="2"  type="text">--}}
{{--                    <span>-</span>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div>

                <a id="addToCartBtn" href="#" class=" flex justify-between items-center text-center my-2 py-2 border rounded-lg lg:w-1/2  lg:mx-auto  w-full bg-green-600">
                    @if($product->discount_price!=0)
                        <div class="md:hidden mx-auto flex-col">
                            <div>
                                 <span class="rounded-lg text-sm bg-red-500 px-1">
                        {{  number_format((($product->price - $product->discount_price) / $product->price) * 100) }} %
                         </span>
                        <span class=" line-through text-sm md:py-2 mx-auto">{{number_format($product->price)}}  تومان </span>
                            </div>
                        <span class=" text-xl md:py-2 text-center  mx-auto">{{number_format($product->discount_price)}}  تومان </span>
                        </div>
                    @else
                    <span class="md:hidden text-xl md:py-2 mx-auto">{{number_format($product->price)}}  تومان </span>
                    @endif
                    <svg width="30" height="30" class="md:hidden mx-2" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="15" cy="15" r="14.5" stroke="white"></circle>
                    <line style="stroke: rgb(255, 255, 255);stroke-width: 2px;" x1="15" y1="7.1" x2="15" y2="22.9"></line>
                    <line style="stroke: rgb(255, 255, 255);stroke-width: 2px;" x1="7.132" y1="14.966" x2="22.868" y2="15.034"></line>
                  </svg>
                   <span class="hidden md:block mx-auto">افزودن سبد خرید</span>
                </a>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
<script>
        document.getElementById('addToCartBtn').addEventListener('click', function (e) {
        e.preventDefault(); // از رفتن مستقیم جلوگیری کن
        const code = document.getElementById('code').value;
        const productId = {{ $product->id }};
        const url = `/addtocart/${productId}?code=${encodeURIComponent(code)}`;
        window.location.href = url;
    });
</script>





