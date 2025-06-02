<div class="flex flex-col h-full border-2 space-y-4 rounded-md justify-evenly py-2">
    @php
        $mainImage = "";
        $galleryImages = [];

        try {
            $images = json_decode($product->images, true);

            if (is_array($images)) {
                $mainImage = $images['main'] ?? "";
                $galleryImages = $images['gallery'] ?? [];
            }
        } catch (\Exception $error) {
            // optionally log $error
        }
    @endphp

    <div class="text-center">ارسال اکسپرس</div>

    <a href="/product/{{$product->slug}}" class="w-full">
        <div class="w-full aspect-[3/4] overflow-hidden">
            <img
                src="/storage/images/products/{{$mainImage}}"
                alt="{{$product->name}}"
                class="w-full h-full object-cover"
            >
        </div>
    </a>

    <div class="text-center text-md font-semibold  mt-2">{{$product->name}}</div>

    @if($product->discount_amount)
        <div class="text-center text-xl text-green-600 font-bold mt-1">
            {{$product->discount_price}}
            <span class="text-sm text-red-500 font-normal">
        ({{ round((($product->price - $product->discount_price) / $product->price) * 100) }}٪ تخفیف)
    </span>
        </div>
        <div class="text-center line-through text-lg text-gray-500">{{$product->price}}</div>

    @else
        <div class="text-center text-lg text-gray-800 mt-1 leading-[1.3]">{{$product->price}}</div>
    @endif
</div>
