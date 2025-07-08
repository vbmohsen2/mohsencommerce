@extends('layouts.master')
{{--بعدا حل شود--}}
{{--@section('title',$product->name)--}}
{{--@section('description',$product->description)--}}
{{--بعدا حل شود--}}
@section('content')

    <div id="app" class=" container mx-auto mt-2 px-16 ">
        <router-view></router-view>
    </div>
@endsection
