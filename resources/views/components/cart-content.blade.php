@if($cartItems && count($cartItems) > 0)
    @php $total = 0; @endphp
    @foreach($cartItems as $item)
        @php

            $price = $item['price'] ?? 0;
            $quantity = $item['quantity'];
            $total += $price * $quantity;


//             thumb image finding
               $thumbImage = "";
                $productimage = App\Models\Products::find($item['id']);
                $images = json_decode($productimage->images, true);

                // چک کردن اینکه کلید 'thumb' وجود داشته باشد
                if (isset($images['thumb']) && $images['thumb']) {
               $thumbImage = $images['thumb'];
                }

        @endphp

        <div class="flex justify-between gap-3 mb-4 border-b pb-2 ">
            <img src="{{ $item['image'] ?? asset('/storage/images/products/thumb/'.$thumbImage) }}"
                 class="w-16 h-16 rounded object-cover"
                 alt="{{ $item['name'] }}">
            <div class="flex-grow justify-between">
                <h4 class="font-semibold">{{ $item['name'] }}</h4>

                <p>طرح:{{$item['code']}}</p>
                <p class="text-sm text-gray-600">{{ number_format($price) }} تومان</p>

            </div>
            <div class="flex items-center mt-2 gap-2">
                <form action="{{ route('cart.decrease', $item['id']) }}" method="POST">@csrf
                    <button class="px-2 border">−</button>
                </form>
                <span class="text-sm">{{ $quantity }}</span>
                <form action="{{ route('cart.increase', $item['id']) }}" method="POST">@csrf
                    <button class="px-2 border">+</button>
                </form>
                <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                    @csrf @method('DELETE')
                    <input type="hidden" name="code" value="{{ $item['code'] }}">
                    <button class="text-red-500 text-lg hover:text-red-700 ml-2" title="حذف">🗑</button>
                </form>
            </div>
        </div>

    @endforeach

    <div class="flex justify-between items-center mt-4 font-bold">
        <span>جمع کل:</span>
        <span>{{ number_format($total) }} تومان</span>
    </div>
    <div class="flex justify-between mt-4">
    <form action="{{ route('cart.clear') }}" method="POST"  >
        @csrf
        <button class=" bg-red-500 px-2  text-center text-white py-2 rounded hover:bg-red-600"> پاکسازی سبد خرید
        </button>
    </form>
    <a href="{{route('cart')}}" class="px-2 bg-green-400  text-center text-white py-2 rounded hover:bg-green-600">ثبت سفارش
    </a>
    </div>
@else
    <p class="text-center text-gray-500 mt-4">سبد خرید خالی است</p>
@endif

