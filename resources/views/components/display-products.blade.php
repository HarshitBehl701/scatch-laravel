@php
    $flattenArray = reset($productData);
    $topProducts   =  $flattenArray['top_products'];
    $LatestFashionProducts   =  $flattenArray['latest_fashions'];
    $newlyProducts   =  $flattenArray['newly_products'];
@endphp

<h3 class="text-center text-3xl font-mono font-semibold cursor-pointer mb-6 animate__animated animate__fadeIn animate__delay-2s">
    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 transition-all duration-1000 ease-in-out transform scale-100 cursor-pointer animate__animated animate__fadeIn animate__delay-1s">
        Top
    </span>
    
    <span class="text-transparent bg-clip-text bg-black hover:bg-gradient-to-l hover:from-yellow-400 hover:to-red-500 transition-all duration-500 ease-in-out transform hover:scale-110 cursor-pointer animate__animated animate__fadeIn animate__delay-1s">
      Products
    </span>

  </h3>
<x-products-row :productData="$topProducts" />


<h3 class="text-center text-3xl font-mono font-semibold cursor-pointer mb-6 animate__animated animate__fadeIn animate__delay-2s">
    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 transition-all duration-1000 ease-in-out transform scale-100 cursor-pointer animate__animated animate__fadeIn animate__delay-1s">
        Latest
    </span>
    
    <span class="text-transparent bg-clip-text bg-black hover:bg-gradient-to-l hover:from-yellow-400 hover:to-red-500 transition-all duration-500 ease-in-out transform hover:scale-110 cursor-pointer animate__animated animate__fadeIn animate__delay-1s">
      Fashion
    </span>
    
    <span class="text-transparent bg-clip-text bg-black hover:bg-gradient-to-l hover:from-yellow-400 hover:to-red-500 transition-all duration-500 ease-in-out transform hover:scale-110 cursor-pointer animate__animated animate__fadeIn animate__delay-1s">
      Collection
    </span>

  </h3>

<x-products-row :productData="$LatestFashionProducts" />


<h3 class="text-center text-3xl font-mono font-semibold cursor-pointer mb-6 animate__animated animate__fadeIn animate__delay-2s">
    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 transition-all duration-1000 ease-in-out transform scale-100 cursor-pointer animate__animated animate__fadeIn animate__delay-1s">
        Newly
    </span>
    
    <span class="text-transparent bg-clip-text bg-black hover:bg-gradient-to-l hover:from-yellow-400 hover:to-red-500 transition-all duration-500 ease-in-out transform hover:scale-110 cursor-pointer animate__animated animate__fadeIn animate__delay-1s">
      Added
    </span>
    
    <span class="text-transparent bg-clip-text bg-black hover:bg-gradient-to-l hover:from-yellow-400 hover:to-red-500 transition-all duration-500 ease-in-out transform hover:scale-110 cursor-pointer animate__animated animate__fadeIn animate__delay-1s">
      Products
    </span>

  </h3>

<x-products-row  :productData="$newlyProducts" />