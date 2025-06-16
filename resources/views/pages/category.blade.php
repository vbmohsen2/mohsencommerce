@extends('layouts.master')
@section('content')

    <div id="app" class="w-full container mx-auto my-16 ">

        <category-products
            :category-id="{{ $category->id }}"
            category-slug="{{ $category->slug }}"
        ></category-products>

    </div>
@endsection
