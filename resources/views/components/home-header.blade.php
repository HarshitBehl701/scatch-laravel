<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<header  class="relative">
        <h1 class="text-center md:text-3xl   text-2xl font-mono font-semibold cursor-pointer mb-6 animate__animated animate__fadeIn animate__delay-1s">
  <!-- "Scatch" with gradient on load -->
  <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 transition-all duration-1000 ease-in-out transform scale-100 cursor-pointer animate__animated animate__fadeIn animate__delay-1s">
    Scatch
  </span>
  
  <!-- "Your Shopping" will initially have black bg (no gradient), but will have hover effect -->
  <span class="text-transparent bg-clip-text bg-black hover:bg-gradient-to-l hover:from-yellow-400 hover:to-red-500 transition-all duration-500 ease-in-out transform hover:scale-110 cursor-pointer animate__animated animate__fadeIn animate__delay-1s">
    Your
  </span>
  
  <span class="text-transparent bg-clip-text bg-black hover:bg-gradient-to-l hover:from-yellow-400 hover:to-red-500 transition-all duration-500 ease-in-out transform hover:scale-110 cursor-pointer animate__animated animate__fadeIn animate__delay-2s">
    Shopping
  </span>
  
  <!-- "Partner" with gradient on load and hover effect -->
  <span class="text-transparent bg-clip-text bg-black hover:bg-gradient-to-l hover:from-yellow-400 hover:to-red-500 transition-all duration-500 ease-in-out transform hover:scale-110 cursor-pointer animate__animated animate__fadeIn animate__delay-3s">
    Partner
  </span>
</h1>

      
    <div class="twoSectionLayout md:px-20  px-8 py-10 flex  md:flex-nowrap flex-wrap gap-8 bg-gradient-to-r from-blue-50 via-white to-blue-50">
        <div class="leftSection   md:w-1/2  w-full">
            

<div id="default-carousel" class="relative w-full" data-carousel="slide">
    <!-- Carousel wrapper -->
    <div class="relative h-64 shadow-md cursor-pointer overflow-hidden rounded-lg">
         <!-- Item 1 -->
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="{{asset('/assets/image1.jpg')}}" class="absolute block w-full  hover:scale-105  transition-all duration-300  h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
        </div>
        <!-- Item 2 -->
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="{{asset('/assets/image2.jpg')}}" class="absolute block w-full h-full hover:scale-105  transition-all duration-300 -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
        </div>
        <!-- Item 3 -->
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="{{asset('/assets/slider1.jpg')}}" class="absolute block w-full h-full hover:scale-105  transition-all duration-300 -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
        </div>
    </div>
</div>

        </div>
        <div class="rightSection md:w-1/2   w-full md:px-8 flex flex-col justify-center">
            <!-- Heading -->
            <h2 class="text-xl font-bold text-gray-800 mb-2">
                Welcome to Your Perfect Shopping Destination
            </h2>
        
            <!-- Subheading / Description -->
            <p class="text-gray-600 mb-6 leading-relaxed text-sm">
                Discover a wide range of products that meet all your shopping needs. From the latest fashion trends to must-have gadgets, we bring you everything at the best prices. Browse our collection and find the best deals on your favorite items today!
            </p>
        
            <!-- Call-to-Action Button -->
            <a href="/products" class="bg-blue-600 text-white px-3 py-2 w-fit rounded-full font-semibold shadow-md hover:bg-blue-700 hover:scale-105 transition-all duration-300 ease-in-out">
                Start Shopping Now
            </a>
        </div>        
    </div>

</header>