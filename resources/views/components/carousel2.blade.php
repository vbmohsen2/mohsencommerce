
<div  class="swiper Itemcarousel">
    <div class="swiper-wrapper">
       @foreach($products as $product  )
        <div class="swiper-slide">
       <x-item-carousel :product="$product"></x-item-carousel>
        </div>
        @endforeach

    </div>
    <div class="swiper-pagination "></div>
</div>
<style>
    .swiper-slide {
        height: auto !important;
        display: flex;
    }
    .swiper-pagination{

    }
</style>
<script>




</script>
