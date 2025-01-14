@extends('layouts.admin')

@php
    $productList = reset($pageData);
    $currentUser  =   session('userType');
    $currentPage  =   request('page');
@endphp

@section('adminContent')



<div class="container mx-auto flex  flex-col gap-3">
    @if (is_array($productList) && count($productList)  > 0)
    @foreach ($productList as $product)
    @php
        $link  =  "product-details/".urlencode($product['name'])."/".$product['id'];
        if($currentPage  ==  'orders'){
            $link = "order-details/".urlencode($product['name'])."/".$product['orderDetails']['orderId'];
        }else if($currentPage  ==  'manage-orders'){
            $link = "order_detail/".urlencode($product['name'])."/".$product['id'].'/'.$product['orderId'];
        }
    @endphp

    <a href="{{$link}}">
        <div class="flex items-center bg-white shadow-sm  border rounded-lg p-4 gap-5">
            <div id="default-carousel" class="relative w-32" data-carousel="slide">
                <!-- Carousel wrapper -->
                <div class="relative h-32 overflow-hidden rounded-lg md:h-32">
                    @foreach ($product['images'] as $image)
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <div class="imagecontainer absolute object-cover object-top block w-full" >
                            <img src="{{Storage::url($image)}}" alt="..."   class="object-cover  object-top w-full h-full">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
             <div class="flex-1">
                 <h3 class="text-lg font-semibold">{{$product['name']}}</h3>
                 <p class="text-gray-600 mt-2">{{$product['description']}}</p>
                 <p class="text-gray-800 mt-2">&#8377; {{$product['price']}}</p>
             </div>
         </div>        
    </a>
    @endforeach
    @else
        <p class="italic font-light text-sm text-gray-500">No Products...</p>
    @endif
</div>

@endsection