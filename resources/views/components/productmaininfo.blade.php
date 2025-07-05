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
    <div class="w-full py-4">
        <label for="code">انتخاب طرح:</label>
        <select id="code" name="code" class="border rounded p-2 my-2 w-full">
            @foreach(json_decode($product->code) as $codeItem)
                <option value="{{ $codeItem->label }}" style="background-color: {{ $codeItem->color }}; color: white;">
                    {{ $codeItem->label }}
                </option>
            @endforeach
        </select>
    </div>


</div>
