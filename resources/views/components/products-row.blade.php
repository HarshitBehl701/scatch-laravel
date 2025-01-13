@if (count($productData) > 0)
<div class="relative md:block hidden overflow-hidden w-[90%] mx-auto p-4 my-12 carousel-container">
    <!-- Carousel Container -->
    <div class="flex gap-6 overflow-x-auto scrollbar-hide snap-x snap-mandatory scroll-smooth product-carousel">
        <!-- Card Component Iteration -->
        @foreach ($productData as $cardData)
            <div class="cardCont shrink-0 mb-2">
                <x-card :cardData="$cardData" />
            </div>
        @endforeach
    </div>

    <!-- Navigation Buttons -->
    <button class="prev absolute w-12 h-12 bg-white left-0 top-1/2 transform -translate-y-1/2 text-gray-500 px-3 py-2 rounded-full shadow-md border hover:-translate-x-1 hover:border-0 hover:bg-transparent hover:shadow-none hover:text-2xl transition-all duration-400 z-30">
        &#10094;
    </button>
    <button class="next absolute right-0 w-12 h-12 top-1/2 bg-white transform -translate-y-1/2 text-gray-500 px-3 py-2 rounded-full shadow-md border hover:translate-x-1 hover:border-0 hover:bg-transparent hover:shadow-none hover:text-2xl transition-all duration-400 z-30">
        &#10095;
    </button>
</div>

{{-- For smaller Screen --}}
<div class="smallerScreensProductpage  flex  flex-wrap  gap-8 w-[70%] my-4 mx-auto md:hidden">
    @foreach ($productData as $cardData)
            <div class="cardCont shrink-0   h-90 w-full mb-2">
                <x-card :cardData="$cardData" />
            </div>
        @endforeach
</div>

@else
<p class="italic font-light text-sm">No Products to show...</p>
@endif

<style>
    .scrollbar-hide {
      -ms-overflow-style: none; /* IE and Edge */
      scrollbar-width: none; /* Firefox */
    }
    .scrollbar-hide::-webkit-scrollbar {
      display: none; /* Chrome, Safari, Opera */
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const carousels = document.querySelectorAll('.carousel-container'); // Select all carousel containers
        
        carousels.forEach(carousel => {
            const container = carousel.querySelector('.product-carousel');
            const nextButton = carousel.querySelector('.next');
            const prevButton = carousel.querySelector('.prev');
            const slideInterval = 3000; // Slide every 3 seconds
            let autoSlide;

            // Function to slide next
            function slideNext() {
                // Check if the container has reached the end
                if (container.scrollLeft + container.offsetWidth >= container.scrollWidth) {
                    container.scrollLeft = 0; // Reset to the beginning
                } else {
                    container.scrollBy({ left: 300, behavior: 'smooth' });
                }
            }

            // Function to slide previous
            function slidePrev() {
                if (container.scrollLeft === 0) {
                    container.scrollLeft = container.scrollWidth; // Reset to the end
                } else {
                    container.scrollBy({ left: -300, behavior: 'smooth' });
                }
            }

            // Start auto-slide function
            function startAutoSlide() {
                autoSlide = setInterval(slideNext, slideInterval);
            }

            // Stop auto-slide function
            function stopAutoSlide() {
                clearInterval(autoSlide);
            }

            // Button click handlers
            nextButton.addEventListener('click', slideNext);
            prevButton.addEventListener('click', slidePrev);

            // Start auto-sliding on page load
            startAutoSlide();

            // Stop sliding on hover and restart when not hovering
            container.addEventListener('mouseenter', stopAutoSlide);
            container.addEventListener('mouseleave', startAutoSlide);
        });
    });
</script>