@extends('layouts.admin.adminlayout')
@section('content')
    <div class="container mx-auto p-4">

        <h1 class="text-2xl font-bold mb-6">قالب ویژگی‌ها</h1>

        {{-- دکمه باز کردن مودال --}}
        <button onclick="document.getElementById('modal').classList.remove('hidden')"
                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition mb-4">
            + افزودن قالب جدید
        </button>

        {{-- Modal --}}
        <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div onclick="event.stopPropagation()" class="bg-white w-full max-w-md mx-4 rounded-xl p-6 shadow-lg">
                <h2 class="text-xl font-semibold mb-4">ایجاد قالب ویژگی جدید</h2>

                {{-- فرم ارسال قالب جدید --}}
                <form  action="{{ route('admin.attributes.storeTemplate') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">نام قالب</label>
                        <input type="text" name="name" id="name" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-400">
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="document.getElementById('modal').classList.add('hidden')"
                                class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-100">
                            لغو
                        </button>
                        <button type="submit"
                                class="px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700">
                            ذخیره
                        </button>
                    </div>
                </form>

            </div>
        </div>

        {{-- لیست قالب‌ها --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($attributesTemplate as $template)
                <div class="bg-white rounded-xl shadow hover:shadow-md transition border hover:border-blue-500 p-4 flex flex-col justify-between">
                    <div>
                        <a href="{{ route('admin.attributes.showAttribute', $template->id) }}" class="block">
                            <div class="text-xl font-semibold mb-2 text-gray-800">
                                {{ $template->name }}
                            </div>
                            <div class="text-gray-600 mb-2">
                                تعداد مشخصات: {{ $template->attributes->count() }}
                            </div>
                        </a>
                    </div>
                    <div class="flex justify-end">
                        <form method="POST" action="{{ route('admin.attributes.deleteTemplate') }}"
                              onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید حذف کنید؟');">
                            @csrf
                            <input type="hidden" name="id" value="{{ $template->id }}">
                            <button type="submit"
                                    class="text-red-600 hover:text-white bg-gray-300 w-full hover:bg-red-600 hover:scale-105 hover:shadow-md transition-all duration-200 text-sm flex items-center gap-1 px-3 py-1 rounded-md">
                                🗑️ <span>حذف</span>
                            </button>
                        </form>
                    </div>
                </div>


            @endforeach
        </div>

        <div class="mt-6">
            {{ $attributesTemplate->links() }}
        </div>
    </div>
    @if (session('success'))
        <div id="toast-message" class="border fixed top-20 left-32 transform -translate-x-1/2 -translate-y-1/2 bg-green-500 text-white p-4 rounded-lg shadow-lg z-50">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(function() {
                // مخفی کردن پیام پس از 3 ثانیه
                document.getElementById('toast-message').style.display = 'none';
            }, 3000); // مدت زمان نمایش پیام (3000 میلی‌ثانیه = 3 ثانیه)
        </script>
    @endif
    <script>
        // وقتی مودال کلیک میشه خارج از مودال (یعنی روی بک‌گراند)، مخفی بشه
        document.getElementById('modal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    </script>
@endsection
