@extends('layouts.admin')
@php
    $productDetails  = reset($pageData);
    $currentUser = session('userType');
    $from_request_page  = explode('/',url()->previous())[4]; //from where this request  comes  from

    if($currentUser   == 'user'){
        $in_cart =   false;
        $in_whislist =   false;
        $buttonText = 'Add to Cart';

        $cartBtnLink = '/user/manage_cart/add/'.urlencode($productDetails['name']).'/'.$productDetails['id'];
        $whislistBtnLink = '/user/manage_whislist/add/'.urlencode($productDetails['name']).'/'.$productDetails['id'];
        $in_cart = $productDetails['in_cart'];
        $in_whislist = $productDetails['in_whislist'];

        if($in_cart){
            $buttonText =   'Remove  From Cart';
            $cartBtnLink = '/user/manage_cart/remove/'.urlencode($productDetails['name']).'/'.$productDetails['id'];
        }

        if($in_whislist){
            $whislistBtnLink = '/user/manage_whislist/remove/'.urlencode($productDetails['name']).'/'.$productDetails['id'];
        }
    }

@endphp
@section('adminContent')

<div class="flex flex-wrap gap-4">
    <!-- Product Image Section (Left Side) -->
    <div class="md:w-[250px]   w-full md:h-[250px]  h-[300px]">
        <div id="default-carousel" class="relative w-full   h-full" data-carousel="slide">
            <!-- Carousel wrapper -->
            <div class="relative h-full overflow-hidden rounded-lg">
                @foreach ($productDetails['images'] as $image)
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <div class="imagecontainer absolute object-cover object-top block w-full" >
                        <img src="{{Storage::url($image)}}" alt="..."   class="object-cover  object-top w-full h-full">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Product Details Section (Right Side) -->
    <div class="md:w-full lg:w-2/3">
        <div class="bg-white md:px-6">
            <div class="header flex   justify-between">
                <h2 class="text-2xl font-semibold mb-4">{{$productDetails['name']}}</h2>
            @if (isset($whislistBtnLink))
            <a   href="{{$whislistBtnLink}}" class="bg-white p-2 rounded-full shadow-smbg-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="{{$in_whislist ? 'red' :  'black'}}">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                  </svg>              
                </a>
            @endif
            </div>
            <p class="text-gray-700 mb-2">{{$productDetails['description']}}</p>
            <p class="text-xl font-semibold text-gray-900">&#8377; {{$productDetails['price'] -  (($productDetails['discount']/100)*$productDetails['price'])}} <small class="line-through text-gray-500">({{$productDetails['price']}})</small></p>
            <p class="text-xl">
                @for ($i = 0; $i < 5; $i++)
                <span class="{{$i < $productDetails['rating']  ? 'text-yellow-400' : ''}}">&#9733;</span>
                @endfor
                <small class="text-gray-500">({{$productDetails['number_of_customer_rate']}})</small>
            </p>
            @if ($currentUser  == 'seller')
                <p>Status : <a href="/product/status-update/{{$productDetails['id']}}" class="text-blue-600  text-sm italic">{{$productDetails['status'] ==  '1' ? 'Active' :  'Not Active'}}</a></p>
            @endif
            <a href="{{ $currentUser == 'seller' 
            ? '/seller/edit-product/' . urlencode($productDetails['name']) . '/' . $productDetails['id'] 
            : $cartBtnLink }}" 
                class="my-4 text-xs inline-block 
                        {{ $currentUser == 'seller' 
                            ? 'bg-blue-600 hover:bg-blue-700' 
                            : ($in_cart ? 'bg-red-600 hover:bg-red-700' : 'bg-blue-600 hover:bg-blue-700') }} 
                        text-white px-2 py-1 font-semibold rounded-md">
                    {{ $currentUser == 'seller' ? 'Edit Product' : $buttonText }}
            </a>

            @if ($currentUser == 'user'  && isset($in_cart) &&  $in_cart == true)
                <a href="/user/manage_order/add/{{urlencode($productDetails['name'])}}/{{$productDetails['id']}}" class="ml-4  shadow-sm  text-xs  bg-blue-600  hover:bg-blue-700 rounded-md  px-2  py-1 text-white  font-semibold">Place Order</a>
            @endif

            <div class="commentContainer">
                <h4  class="text-xl">Comments</h4>
                <div class="commentCont p-4 rounded-md shadow-sm border mt-3 max-h-400px   overflow-y-auto">
                    @if (count($productDetails['comments']) > 0) 
                        @foreach ($productDetails['comments'] as $commentData)
                            <x-comment :commentData="$commentData" />
                        @endforeach
                    @else
                    <p class="italic font-light  text-sm">No Comments...</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection