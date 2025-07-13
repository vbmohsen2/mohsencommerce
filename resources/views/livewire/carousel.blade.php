<div class="relative h-full overflow-hidden w-full rounded-xl">
    <!-- Carousel Container -->
    <div id="carousel" class="flex transition-transform duration-500 ease-in-out">
        @foreach ($images as $index => $image)
            <div class="slide w-full flex-shrink-0 flex items-center justify-center">
                <a href="#">
                    <img src="{{ asset($image) }}"
                         loading="lazy"
                         class="w-full h-[16vh] object-cover object-center sm:h-full sm:max-h-screen"
                         alt="Slide {{ $index }}">
                </a>
            </div>
        @endforeach
    </div>

    <!-- Left Arrow -->
{{--    <button id="prev" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-700 text-white p-2 rounded-full shadow-lg">--}}
{{--        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">--}}
{{--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>--}}
{{--        </svg>--}}
{{--    </button>--}}

{{--    <!-- Right Arrow -->--}}
{{--    <button id="next" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-700 text-white p-2 rounded-full shadow-lg">--}}
{{--        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">--}}
{{--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>--}}
{{--        </svg>--}}
{{--    </button>--}}

    <!-- Indicators (Optional) -->
    <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 flex space-x-2">
        @foreach ($images as $index => $image)
            <button class="dot w-3 h-2 px-3 mx-2 bg-gray-400 rounded-full cursor-pointer transition-all"
                    onclick="moveToSlide({{ $index }})"></button>
        @endforeach
    </div>

</div>

<!-- JavaScript for Auto-Slide Reset -->

<script>
    const carousel = document.getElementById("carousel");
    const slides = document.querySelectorAll("#carousel img");
    const dots = document.querySelectorAll(".dot");
    const totalSlides = slides.length;
    let currentIndex = 0;
    let startX = 0;
    let isDragging = false;
    let moveX = 0;
    let isDraggingEnough = false;
    let threshold = 50; // حداقل کشیدن برای تغییر اسلاید
    let autoSlideTimer;


    // ✅ جابجایی اسلاید به موقعیت مشخص‌شده
    const moveToSlide = (index) => {
        currentIndex = index;
        carousel.style.transition = "transform 0.3s ease-out";
        carousel.style.transform = `translateX(+${currentIndex * 100}%)`;
        updateDots();
        resetAutoSlide();
    };

    const updateDots = () => {
        dots.forEach((dot, index) => {
            dot.classList.toggle("bg-gray-800", index === currentIndex);
            dot.classList.toggle("bg-gray-400", index !== currentIndex);
        });
    };

    const nextSlide = () => {
        moveToSlide((currentIndex + 1) % totalSlides);
    };

    const prevSlide = () => {
        moveToSlide((currentIndex - 1 + totalSlides) % totalSlides);
    };

    // document.getElementById("next").addEventListener("click", nextSlide);
    // document.getElementById("prev").addEventListener("click", prevSlide);

    // Dot Indicator Click
    dots.forEach((dot, index) => {
        dot.addEventListener("click", () => moveToSlide(index));
    });

    // Drag & Touch Events
    const startDrag = (x) => {
        isDragging = true;
        isDraggingEnough = false;
        startX = x;
        moveX = 0;
        carousel.style.transition = "none";
        stopAutoSlide();
    };

    const moveDrag = (x) => {
        if (!isDragging) return;
        moveX = x - startX;
        if (Math.abs(moveX) > 5) isDraggingEnough = true; // اگر حرکت حداقل 5px بود، یعنی درگ واقعی است
        carousel.style.transform = `translateX(calc(+${currentIndex * 100}% + ${moveX}px))`;
    };

    const endDrag = (event) => {
        if (!isDragging) return;
        isDragging = false;

        if (Math.abs(moveX) > threshold) {
            moveX > 0 ? nextSlide() :prevSlide() ;
        } else {
            moveToSlide(currentIndex);
        }

        if (isDraggingEnough) event.preventDefault(); // جلوگیری از کلیک ناخواسته
    };

    // Mouse Events
    carousel.addEventListener("mousedown", (e) => startDrag(e.clientX));
    carousel.addEventListener("mousemove", (e) => moveDrag(e.clientX));
    carousel.addEventListener("mouseup", endDrag);
    carousel.addEventListener("mouseleave", endDrag);
    carousel.addEventListener("click", (e) => {
        if (isDraggingEnough) {
            e.preventDefault(); // جلوگیری از کلیک ناخواسته هنگام درگ
        } else {
            const target = e.target.closest("a"); // پیدا کردن لینک درون اسلاید
            if (target) {
                window.location.href = target.href; // هدایت به لینک
            }
        }
    });

    // Touch Events for Mobile
    carousel.addEventListener("touchstart", (e) => startDrag(e.touches[0].clientX));
    carousel.addEventListener("touchmove", (e) => moveDrag(e.touches[0].clientX));
    carousel.addEventListener("touchend", endDrag);

    // Auto-slide Functionality
    const startAutoSlide = () => {
        autoSlideTimer = setInterval(nextSlide, 5000);
    };

    const stopAutoSlide = () => {
        clearInterval(autoSlideTimer);
    };

    const resetAutoSlide = () => {
        stopAutoSlide();
        startAutoSlide();
    };

    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll("#carousel img").forEach((img) => {
            img.addEventListener("dragstart", (event) => event.preventDefault());
        });

    });

    startAutoSlide();
    updateDots(); // نمایش دایره فعال در ابتدای لود
</script>

