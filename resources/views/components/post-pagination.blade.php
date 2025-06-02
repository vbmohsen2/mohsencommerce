@if ($paginator->hasPages())
    <nav class="flex justify-center mt-6">
        <ul class="inline-flex space-x-2">
            {{-- دکمه قبلی --}}
            @if ($paginator->onFirstPage())
{{--                <li class="px-3 py-1 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed">قبلی</li>--}}
            @else
                <li class="p-4">
                    <a href="{{ $paginator->previousPageUrl() }}" class="text-black rounded-lg ">
                       <i class="fa fa-chevron-right"></i>
                    </a>
                </li>
            @endif

            {{-- شماره صفحات --}}
            @foreach ($paginator->links()->elements[0] as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="p-4  bg-blue-600 text-white rounded-lg">{{ $page }}</li>
                @else
                    <li class="p-4">
                        <a href="{{ $url }}" class=" bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-400">
                            {{ $page }}
                        </a>
                    </li>
                @endif
            @endforeach

            {{-- دکمه بعدی --}}
            @if ($paginator->hasMorePages())
                <li class="p-4">
                    <a href="{{ $paginator->nextPageUrl() }}" class="  text-gray-700 rounded-lg ">
                        <i class="fa fa-chevron-left"></i>
                    </a>
                </li>
            @else
{{--                <li class="px-3 py-1 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed">بعدی</li>--}}
            @endif
        </ul>
    </nav>
@endif
