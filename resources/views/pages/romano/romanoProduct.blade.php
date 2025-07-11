@extends('layouts.master')
{{--بعدا حل شود--}}
@section('title',$product->name)
@section('description',$product->seo_description)
{{--بعدا حل شود--}}
@section('content')

    <div id="app" class=" container mx-auto mt-2 px-4 ">


       <romano-product-page :product='@json($product)'>
       </romano-product-page>
    </div>
@endsection
