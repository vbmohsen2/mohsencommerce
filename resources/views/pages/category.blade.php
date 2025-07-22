@extends('layouts.master')
@section('title',$category->name)
@section('description',$category->description)
@section('content')

    <div id="app" class="w-full container mx-auto my-16  ">

{{--        for future should send category object into the component--}}
        <category-products
{{--            :category-id="{{ $category->id}}"--}}
            category-slug="{{ $category->slug }}"
        ></category-products>

    </div>
@endsection
