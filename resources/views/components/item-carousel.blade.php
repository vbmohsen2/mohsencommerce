<div class="flex flex-col h-full border border-gray-300 rounded-md overflow-hidden">

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
            // log $error if needed
        }
    @endphp

    {{-- عنوان یا برچسب بالا --}}
    <div class="text-center text-sm text-gray-600">ارسال اکسپرس</div>

    {{-- تصویر محصول با نسبت ثابت --}}
    <a href="/product/{{ $product->slug }}">
        <div class="w-full aspect-[3/4] overflow-hidden">
            <img
                src="/storage/images/products/{{ $mainImage }}"
                alt="{{ $product->name }}"
                class="w-full h-full object-cover rounded object-center"
            >
        </div>
    </a>

    {{-- نام محصول --}}
    <div class="flex flex-col justify-between flex-1 p-2 space-y-2">
        <div class="text-center text-xs text-gray-500">ارسال اکسپرس</div>

        <div class="text-center text-sm font-semibold leading-tight line-clamp-2 h-[3.5em]">
            {{ $product->name }}
        </div>

        @if($product->discount_amount)
            <div class="text-center text-green-600 text-lg font-bold">
                {{ $product->discount_price }}
                <span class="text-sm text-red-500 font-normal">
                ({{ round((($product->price - $product->discount_price) / $product->price) * 100) }}٪ تخفیف)
            </span>
            </div>
            <div class="text-center line-through text-sm text-gray-500">{{ $product->price }}</div>
        @else
            <div class="text-center text-base text-gray-800">{{ $product->price }}</div>
        @endif
    </div>
</div>
