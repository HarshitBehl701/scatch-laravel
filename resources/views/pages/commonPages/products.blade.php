@extends('layouts.main')
@php
    $productsData   = $pageData['all_products'];
    $categories   = $pageData['categories'];
    if(request()->route('param1')){
        require_once app_path('Helpers/helpers.php');
        $filterProductData  = getFilteredProductsData(request()->query());
        $productsData = (count($filterProductData) > 0)  ?  $filterProductData :  $productsData;
    }
@endphp

@section('content')
<div class="min-h-screen px-8">
    <div class="container mx-auto">
        <!-- Page Header -->
        <h1 class="text-3xl font-semibold italic  hover:text-blue-600 cursor-pointer mb-8 text-center text-gray-800">Shop Our Collection</h1>

        <!-- Two Section Layout -->
        <div class="flex flex-col md:flex-row gap-8">
            
            <!-- Sidebar Section (Navbar on small screens) -->
            <aside class="w-full md:w-1/4">
                <div class="toggleButtonCont  flex  justify-end">
                    <!-- Mobile Navbar Toggle Button -->
                    <button id="navbar-toggle" class="block md:hidden p-2 mb-4 bg-gray-200 rounded-md text-gray-700">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <div id="navbar" class="md:block hidden  p-6 bg-white rounded-lg border shadow-md">
                    <h2 class="text-2xl font-semibold mb-4 text-gray-700">Categories</h2>
                    <ul class="space-y-3 text-gray-600 font-semibold">
                        @foreach ($categories as $category)
                        @if (count($category['subCategories']) > 0)
                        <li>
                            <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown{{$loop->index}}" data-collapse-toggle="dropdown{{$loop->index}}">
                                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ucfirst($category['name'])}}</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                   <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                            <ul id="dropdown{{$loop->index}}" class="hidden py-2 space-y-2">
                                @foreach ($category['subCategories'] as $subCategory)
                                <a href="/products/search?category={{$category['name']}}&sub_category={{$subCategory}}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <li>
                                        {{ucfirst($subCategory)}}
                                    </li>
                                </a>
                                @endforeach
                            </ul>
                        </li>
                        @else
                        <a class="block" href="/products/search?category={{$category['name']}}"><li>{{ucfirst($category['name'])}}</li></a>
                        @endif
                        @endforeach
                    </ul>

                    <h3 class="text-gray-700 text-xl mt-4 border-t-2 pt-2">Filter By</h3>
                    <a class="block  my-2 px-2 py-1 rounded-full shadow-sm border w-fit text-sm" href="/products/search?sort=top_products">Top Products</a>
                    <a class="block  my-2 px-2 py-1 rounded-full shadow-sm border w-fit text-sm" href="/products/search?sort=price_desc">Price High to Low</a>
                    <a class="block  my-2 px-2 py-1 rounded-full shadow-sm border w-fit text-sm" href="/products/search?sort=price_asc">Price Low to High</a>
                    <a class="block  my-2 px-2 py-1 rounded-full shadow-sm border w-fit text-sm" href="/products/search?sort=rating">Top Rated Products</a>
                    
                    <!-- Price Range Filter -->
                    <div class="relative mb-6">
                        <p>Price range</p>
                        <label for="price-range-input" class="sr-only">Price range</label>
                        <input id="price-range-input" type="range" min="100" max="150000" value="1000" step="50" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                        
                        <div class="flex justify-between mt-2">
                            <span class="text-sm text-gray-500 dark:text-gray-400">₹100</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">₹500</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">₹1000</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">₹1500</span>
                        </div>
                        <!-- Hidden Input Fields to Hold Min & Max Prices -->
                        <input type="hidden" id="min_price" name="min_price" value="100">
                        <input type="hidden" id="max_price" name="max_price" value="1000">
                    </div>
                </div>
            </aside>

            <!-- Products Grid Section -->
            <section class="w-full md:w-3/4 flex flex-wrap gap-6">
                @foreach ($productsData as $productData)
                <div class="shrink-0 grow-0 h-fit w-full md:w-fit">
                    <x-card :cardData="$productData" />                    
                </div>
                @endforeach
            </section>
        </div>
    </div>
</div>

<script>
    const priceSlider = document.getElementById("price-range-input");
    const minPriceInput = document.getElementById("min_price");
    const maxPriceInput = document.getElementById("max_price");

    let initialMinPrice = minPriceInput.value;
    let initialMaxPrice = maxPriceInput.value;

    priceSlider.addEventListener("change", function() {
        const value = priceSlider.value;
        minPriceInput.value = value <= 1000 ? 100 : value;
        maxPriceInput.value = value;
        location.href = `/products/search?min_price=${minPriceInput.value}&max_price=${maxPriceInput.value}&category=${getQueryParam('category')}&sub_category=${getQueryParam('sub_category')}`;
    });

    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    priceSlider.value = initialMaxPrice;

    // Toggle the sidebar on mobile
    document.getElementById('navbar-toggle').addEventListener('click', function() {
        const navbar = document.getElementById('navbar');
        navbar.classList.toggle('hidden');
    });
</script>

@endsection