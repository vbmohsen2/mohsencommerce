@extends('layouts.master')
{{--بعدا حل شود--}}
{{--@section('title',$product->name)--}}
{{--@section('description',$product->description)--}}
{{--بعدا حل شود--}}
@section('content')

    <div class=" container mx-auto mt-2 px-16 ">
       @php

        @endphp
        @include('components.productinfo')

        @include('components.productdescription')
    </div>
@endsection
