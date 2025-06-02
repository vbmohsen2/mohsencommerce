@extends('layouts.admin.adminlayout')
@section('content')
<div class="flex flex-col w-full  pt-4 px-4">
    <h1>محصولات</h1>

    <div class="my-2">
        <a href={{route("admin.addProduct")}} class="bg-blue-600 rounded px-2 py-1"> اضافه کردن محصول </a>
    </div>


{{--    --}}

    <div id="app">

        <category-filter></category-filter>
    </div>



{{--    --}}
</div>
@endsection
