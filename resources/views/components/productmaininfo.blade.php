<div class="flex flex-col w-3/5 ">
        <div class="pt-4 pb-2">
    <h2 class="text-gray-600 text-lg font-bold">خصوصیات کلیدی</h2>
    </div>
    @php
        $attributes = is_string($product->attributes)
            ? json_decode($product->attributes, true)
            : $product->attributes;
    @endphp
        <ul>

            @foreach($attributes as $attribute)
                <li>
                  <span class="text-gray-500">{{ htmlspecialchars($attribute['name']) }}:</span>
                    {{ htmlspecialchars($attribute['value']) }}
                </li>
            @endforeach

        </ul>


</div>
