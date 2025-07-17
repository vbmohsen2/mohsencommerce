@extends('layouts.master')
@section('content')
    <div  class="container px-6 sm:px-0  mx-auto mt-4">
        <div class="flex flex-col md:flex-row w-full md:h-72">

        @livewire('carousel')


        @include('components.row')

        </div>
        <div class="mb-4 mt-8 text-xl">
            بیشترین تخفیف ها
        </div>
        <x-carousel2 :products="$topDiscountedProducts"></x-carousel2>

        <div class="mb-4 mt-8 text-xl">
            بیشترین بازدیدها
        </div>
        <x-carousel2 :products="$topseller"></x-carousel2>

    </div>
@endsection
