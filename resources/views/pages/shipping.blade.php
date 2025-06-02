@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layouts.master')
@section('content')
    <div class="w-full container mx-auto my-16 ">
    <div class="w-full  shadow-lg rounded-md py-16 px-8  text-gray-500  sm:text-lg lg:text-2xl bg-green-400 my-4 flex items-center justify-between bg-opacity-10">
      <div class="text-center text-opacity-100 !opacity-100  ">
            <i class="fa fa-shopping-cart"></i>
            <p>سبد خرید</p>
        </div>
        <hr class="border flex-grow border-gray-700 mx-2 ">
        <div class="text-center text-opacity-100 !opacity-100 !text-green-400 ">
            <i class="fas fa-shipping-fast"></i>
            <p>جزئیات ارسال</p>
        </div>
        <hr class="border flex-grow border-gray-700 mx-2 ">
        <div class="text-center text-opacity-100 !opacity-100  ">
            <i class="fas fa-credit-card"></i>
            <p>پرداخت</p>
        </div>

    </div>



        <div class=" py-4 max-w-3xl mx-auto">
            <h2 class="text-2xl font-bold mb-4">انتخاب آدرس</h2>

            @php
                $addresses = json_decode(Auth::user()->address ?? '[]', true);
            @endphp

            <form action="{{ route('address.select') }}" method="POST" id="addressForm">
                @csrf
                <div id="address-list" class="grid gap-4 md:grid-cols-2">
                    @foreach ($addresses as $index => $address)
                        <label class="block border rounded-lg p-4 shadow hover:shadow-lg transition-all cursor-pointer">
                            <input type="radio" name="selected_address" value="{{ $index }}" class="mr-2">
                            <div class="text-sm text-gray-800">
                                <p><strong>استان:</strong> {{ $address['province'] }}</p>
                                <p><strong>شهر:</strong> {{ $address['city'] }}</p>
                                <p><strong>آدرس:</strong> {{ $address['address'] }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">تأیید آدرس</button>
                </div>
            </form>

            <hr class="my-8">

            <h3 class="text-xl font-semibold mb-4">افزودن آدرس جدید</h3>
            <form id="newAddressForm" class="grid gap-4 md:grid-cols-2">
                @csrf
                <input type="text" name="province" placeholder="استان" class="border p-2 rounded" required>
                <input type="text" name="city" placeholder="شهر" class="border p-2 rounded" required>
                <textarea name="address" placeholder="آدرس دقیق" class="border p-2 rounded md:col-span-2" required></textarea>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition md:col-span-2">ذخیره آدرس جدید</button>
            </form>
        </div>

        <script>
            document.getElementById('newAddressForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = e.target;
                const formData = new FormData(form);

                fetch('{{ route("address.add") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form._token.value
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // افزودن آدرس به لیست
                            const index = data.index;
                            const addr = data.address;

                            const container = document.getElementById('address-list');
                            const label = document.createElement('label');
                            label.className = "block border rounded-lg p-4 shadow hover:shadow-lg transition-all cursor-pointer mt-2";

                            label.innerHTML = `
                <input type="radio" name="selected_address" value="${index}" class="mr-2">
                <div class="text-sm text-gray-800">
                    <p><strong>استان:</strong> ${addr.province}</p>
                    <p><strong>شهر:</strong> ${addr.city}</p>
                    <p><strong>آدرس:</strong> ${addr.address}</p>
                </div>
            `;

                            container.appendChild(label);
                            form.reset();
                        } else {
                            alert("خطا در افزودن آدرس.");
                        }
                    })
                    .catch(() => alert("خطا در ارتباط با سرور."));
            });
        </script>
    </div>


@endsection
