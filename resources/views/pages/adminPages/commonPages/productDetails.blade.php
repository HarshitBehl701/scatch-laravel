@extends('layouts.admin')

@php
    $productDetails  = reset($pageData);
    $currentUser = session('userType');
@endphp

@section('adminContent')
{{-- {{dd($productDetails)}} --}}
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
            <h2 class="text-2xl font-semibold mb-4">{{$productDetails['name']}}</h2>
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
            <a href="{{$currentUser  == 'seller'  ? '/seller/edit-product/'.urlencode($productDetails['name']).'/'.$productDetails['id']  :  '#'}}" class="my-4 text-xs inline-block bg-blue-600 text-white px-2 py-1   font-semibold rounded-md hover:bg-blue-700">{{$currentUser  == 'seller'  ? 'Edit  Product'  :  'Add  To  Cart'}}</a>
            <div class="commentContainer">
                <h4  class="text-xl">Comments</h4>
                <div class="commentCont p-4 rounded-md shadow-sm border mt-3 max-h-400px   overflow-y-auto">
                    @if (count($productDetails['comments']) > 0) 
                    <x-comment />
                    @else
                    <p class="italic font-light  text-sm">No Comments...</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection