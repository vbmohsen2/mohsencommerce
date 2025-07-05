<div class="flex flex-col lg:flex-row w-full md:w-2/5  md:order-1 pb-6">
    <div class="flex lg:flex-col align-top text-2xl lg:w-1/12   ">
        <ul class="float-left">
            <li class="inline-block" >
        <i class="fa-regular fa-heart text-gray-500"></i>
            </li >
{{--        <i class="fa-solid fa-heart"></i>  قلب تو پر  --}}
            <li class="inline-block">
        <i class="fa fa-link text-gray-500"></i>
                </li>
            <li class="inline-block">
        <i class="fa fa-code-compare text-gray-500  "></i>
            </li>
        </ul>
    </div>

    <div class="flex flex-col w-full justify-center ">

{{--        main image--}}
        <div class=" mx-4 rounded-md hidden md:block    relative overflow-hidden" id="main-image-container">
            @php
                $images = json_decode($product->images, true);
                $mainImage = $images['main'];
                $galleryImages = $images['gallery'];
            @endphp

            <img id="main-image" src="{{ asset('storage/images/products/' . $mainImage) }}"
                 class="w-full  transition-transform duration-300 ease-in-out object-scale-down  rounded-2xl"
                 alt="Main Image {{$product->name}}">
        </div>

        <div class="md:flex hidden w-full justify-start md:h-1/6 my-4 gap-2" id="gallery">
            <div class="cursor-pointer border border-gray-50 hover:border-green-300">
                <img src="{{ asset('storage/images/products/' . $mainImage) }}"
                     class="w-full md:h-20 lg:h-20 thumbnail"
                     alt="Thumbnail {{$mainImage}}"
                     data-image="{{ $mainImage }}">
            </div>
            @foreach (array_slice($galleryImages, 0, 5) as $galleryImg)
                <div class="cursor-pointer border border-gray-50 aspect-[3/4] hover:border-green-300">
                    <img src="{{ asset('storage/images/products/gallery/' . $galleryImg) }}"
                         class="w-full md:h-20 lg:h-20 thumbnail"
                         alt="Thumbnail {{$galleryImg}}"
                         data-image="{{ $galleryImg }}">
                </div>
            @endforeach


                <div class="flex justify-center items-center px-2 cursor-pointer" id="show-modal-btn">
                    <span class="text-4xl text-gray-500">...</span>
                </div>

        </div>

        {{-- Modal --}}
        <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
            <div class="bg-white p-6 rounded-md max-w-4xl w-full relative">
                <button id="close-modal" class="absolute top-2 right-2 text-2xl text-gray-700">&times;</button>
                <div class="grid grid-cols-3 gap-4">
                    <div class="cursor-pointer border border-gray-50 hover:border-green-300">
                        <img src="{{ asset('storage/images/products/' . $mainImage) }}"
                             class="w-full md:h-20 lg:h-20 thumbnail"
                             alt="Thumbnail {{$mainImage}}"
                             data-image="{{ $mainImage }}">
                    </div>
                    @foreach ($galleryImages as $galleryImg)
                        <img src="{{ asset('storage/images/products/gallery/' . $galleryImg) }}"
                             class="cursor-pointer hover:scale-105 transition-transform duration-200 modal-thumbnail"
                             data-image="{{ $galleryImg }}"
                             alt="Gallery Image">
                    @endforeach
                </div>
            </div>
        </div>
        <div class="md:hidden w-full">

            <div  class="swiper  mobilepimage w-full">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/images/products/' . $mainImage) }}"  class=" w-full max-h-96 object-contain " alt="">
                    </div>
                    @foreach ($images['gallery'] as $galleryImg)
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/images/products/gallery/' . $galleryImg) }}"  class=" w-full max-h-96 object-contain " alt="">
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>

            </div>



        </div>
    </div>
</div>
<script>
    // Hover Zoom
    const mainImageContainer = document.getElementById('main-image-container');
    const mainImage = document.getElementById('main-image');

    mainImageContainer.addEventListener('mousemove', (e) => {
        const { left, top, width, height } = mainImage.getBoundingClientRect();
        const x = ((e.clientX - left) / width) * 100;
        const y = ((e.clientY - top) / height) * 100;
        mainImage.style.transformOrigin = `${x}% ${y}%`;
        mainImage.style.transform = 'scale(2)';
    });

    mainImageContainer.addEventListener('mouseleave', () => {
        mainImage.style.transform = 'scale(1)';
    });

    // Change main image on thumbnail click
    document.querySelectorAll('.thumbnail').forEach((img,index) => {
        if (index === 0) {

            img.addEventListener('click', () => {
                const imageName = img.dataset.image;
                mainImage.src = `/storage/images/products/${imageName}`;

            })
        }
        else {
            img.addEventListener('click', () => {
                const imageName = img.dataset.image;
                mainImage.src = `/storage/images/products/gallery/${imageName}`;
            });
        }
    });

    // Modal logic
    const modal = document.getElementById('modal');
    const showModalBtn = document.getElementById('show-modal-btn');
    const closeModalBtn = document.getElementById('close-modal');

    if (showModalBtn) {
        showModalBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    }

    closeModalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    // Change main image from modal thumbnails
    document.querySelectorAll('.modal-thumbnail').forEach(img => {
        img.addEventListener('click', () => {
            const imageName = img.dataset.image;
            mainImage.src = `/storage/images/products/gallery/${imageName}`;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });
    });
</script>
