@extends('layouts.master')
@section('content')

    <div class="w-full container mx-auto my-16 ">

        @foreach ($products as $product)
           
        @endforeach

        <!-- لینک‌های صفحه‌بندی -->
        {{ $products->links() }}
    </div>
@endsection
