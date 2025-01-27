@extends('layouts.main')

@php
    $productDetail = $pageData['main_page_product_details'];
    $topProducts = $pageData['top_products'];
    $newlyAddedProducts = $pageData['newly_products'];
    
    $cartBtnLink =  '/login';
    $whislistBtnLink =  '/login';
    $in_cart =   false;
    $in_whislist =   false;
    
    if(session()->has('userType')  && session()->has('email')){
        $buttonText =  'Add To Cart';
        $cartBtnLink = '/user/manage_cart/add/'.urlencode($productDetail['name']).'/'.$productDetail['id'];
        $whislistBtnLink = '/user/manage_whislist/add/'.urlencode($productDetail['name']).'/'.$productDetail['id'];
        $in_cart = $productDetail['in_cart'];
        $in_whislist = $productDetail['in_whislist'];

        if($in_cart){
            $buttonText =   'Remove  From Cart';
            $cartBtnLink = '/user/manage_cart/remove/'.urlencode($productDetail['name']).'/'.$productDetail['id'];
        }
        
        if($in_whislist){
            $whislistBtnLink = '/user/manage_whislist/remove/'.urlencode($productDetail['name']).'/'.$productDetail['id'];
        }
        
    }else{
        $buttonText =  'Login First To Add To Cart';
    }

@endphp

@section('content')

{{-- product details --}}
<div class="twoSectionLayout flex flex-wrap gap-5  justify-center px-8">
    <div class="leftSection  w-full md:w-[300px]  h-[300px]  overflow-hidden rounded-md shadow-sm">
        

<div id="default-carousel" class="relative w-full" data-carousel="slide">
    <!-- Carousel wrapper -->
    <div class="relative h-[300px] overflow-hidden rounded-lg">
        @foreach($productDetail['images'] as $image)
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <div class="block w-full">
                <img src="{{Storage::url($image)}}" class="w-full h-full  object-cover  object-top " alt="...">
            </div>
        </div>
        @endforeach
    </div>
    <!-- Slider indicators -->
    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
        <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5" data-carousel-slide-to="4"></button>
    </div>
    <!-- Slider controls -->
    <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
            </svg>
            <span class="sr-only">Previous</span>
        </span>
    </button>
    <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg>
            <span class="sr-only">Next</span>
        </span>
    </button>
</div>

    </div>
    <div class="rightSection w-full md:w-[60%]">
        <div class="header flex items-center justify-between gap-3">
            <h1 class="text-3xl">{{$productDetail['name']}}</h1>
        @if (session()->has('userType')  && session()->has('email')  &&  session('userType') == 'user')
        <a   href="{{$whislistBtnLink}}" class="inline-block   bg-white p-2 rounded-full shadow-smbg-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="{{$in_whislist ? 'red' :  'black'}}">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>              
            </a>
        @endif
        </div>
        <ul  class="mt-2 ">
            <li  class="flex mb-1 justify-between items-center flex-wrap "><span>Brand Name</span><span  class="w-1/2   text-right">{{$productDetail['brandDetails']['brandName']}}</span></li>
            <li  class="flex mb-1 justify-between  items-center flex-wrap "><span>Description</span><span  class="text-justify w-1/2 ">{{$productDetail['description']}}</span></li>
            <li  class="flex mb-1 justify-between  items-center flex-wrap "><span>Rating</span><span  class="text-right">
                    @for ($i = 0; $i < 5; $i++)
                    <span class="{{$i < $productDetail['rating']  ? 'text-yellow-400' : ''}}">&#9733;</span>
                    @endfor
                    <small class="text-gray-500">({{$productDetail['number_of_customer_rate']}})</small>
                </span></li>
            <li  class="flex mb-1 justify-between text-xl items-center flex-wrap "><span>Price</span><span  class="w-1/2   text-right">{{$productDetail['price'] - ($productDetail['discount']/100)*$productDetail['price'] - $productDetail['platformFee']}}  <small  class="line-through">({{$productDetail['price']}})</small></span></li>
            @if (session()->has('userType')  && session()->has('email')  &&  session('userType') == 'user')
            <li   class="flex mb-1 justify-end  mt-3">
                <a href="{{$cartBtnLink}}" class="{{$in_cart ? "bg-red-600 hover:bg-red-700"  : "bg-blue-600 hover:bg-blue-700"}} cursor-pointer inline-block  px-2  py-1  rounded-md  shadow-sm text-white font-semibold">{{$buttonText}}</a>
            </li>
            @endif
        </ul>
    </div>
</div>

{{-- comment  section --}}
<div class="commentsection md:py-8 md:px-12 px-4 py-4 rounded-lg  shadow-sm   w-[90%]  mx-auto border   mt-12">
    <h2 class="text-xl mb-4">Comments</h2>

    <div class="commentContainer max-h-[250px]  overflow-y-auto">
        @if (count($productDetail['comments'])  >  0)
            @foreach($productDetail['comments'] as  $commentData)
            <x-comment :commentData="$commentData" />
            @endforeach
        @else
            <p class="italic font-light text-sm">No    Comments  Yet...</p>
        @endif
    </div>

</div>

{{-- Other  Products --}}
<div class="otherProductsSection w-[90%]  mx-auto mt-12">
    <h2 class="text-2xl mb-4">View Also</h2>
    <x-products-row :productData="$topProducts" />
    <x-products-row :productData="$newlyAddedProducts" />
</div>

@endsection