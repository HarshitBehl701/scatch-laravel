@extends('layouts.admin')
@php
    $productDetails  = reset($pageData);
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
            <h2 class="text-2xl font-semibold mb-4">{{$productDetails['name']}}</h2>
            <p class="text-gray-700 mb-2">{{$productDetails['description']}}</p>
            <p class="text-gray-700 mb-2">Order  Status  : <span class="font-semibold">{{ucfirst($productDetails['orderDetails']['status'])}}</span>
            @php
                $updateDate   = new DateTime($productDetails['orderDetails']['update_date']);
            @endphp
            <small>({{$updateDate->format('d M Y  H:i:s A')}})</small>
            </p>
            <p class="text-gray-700 mb-2">Order  Date  : <span class="font-semibold">
                @php
                    $orderDate   = new DateTime($productDetails['orderDetails']['order_date']);
                @endphp
                {{$orderDate->format('d M Y  H:i:s A')}}
            </span></p>
            <p class="text-xl font-semibold text-gray-900">&#8377; 
                @if ($productDetails['orderDetails']['purchase_amount'] == ($productDetails['price'] -  (($productDetails['discount']/100)*$productDetails['price'])))
                    {{$productDetails['orderDetails']['purchase_amount']}}
                @else
                <small class="line-through text-gray-500">({{$productDetails['price'] -  (($productDetails['discount']/100)*$productDetails['price'])}})</small>
                @endif
            </p>
            <p class="text-xl">
                @for ($i = 0; $i < 5; $i++)
                <a href="/user/update_rating/{{$i+1}}/{{$productDetails['orderDetails']['orderId']}}" class="{{$i < $productDetails['orderDetails']['rating']  ? 'text-yellow-400' : ''}}">&#9733;</a>
                @endfor
                <small class="text-gray-500">({{$productDetails['number_of_customer_rate']}})</small>
            </p>
            @if (!in_array($productDetails['orderDetails']['status'],['delivered','cancel']))
            <a href="/user/manage_order/cancel/{{urlencode($productDetails['name'])}}/{{$productDetails['id']}}/{{$productDetails['orderDetails']['orderId']}}" class="shadow-sm  text-xs  bg-red-600  hover:bg-red-700 rounded-md  px-2  py-1 text-white  font-semibold">Cancel Order</a>
            @endif

            @if ($productDetails['orderDetails']['status'] == 'delivered')
            <div class="commentContainer">
                <h4 class="text-xl">Your Comments</h4>
                <div class="commentCont p-4 rounded-md shadow-sm border mt-3 max-h-400px overflow-y-auto">
                    @if (count($productDetails['orderDetails']['comments']) > 0) 
                        @foreach ($productDetails['orderDetails']['comments'] as $commentData)
                            <x-comment :commentData="$commentData" />
                        @endforeach
                        @else
                        <p class="italic font-light  text-sm">No Comments...</p>
                        @endif
                </div>
            
                <!-- Add Comment Form -->
                <form  method="POST" action="{{route('user.addComment',['orderId' => $productDetails['orderDetails']['orderId']])}}" class="mt-4">
                    @csrf
                    <label for="comment" class="block text-sm font-medium text-gray-700">Add a comment:</label>
                    <textarea id="comment" name="comment" rows="3" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Write your comment here..." required></textarea>
                    @error('comment')
                        <small class="text-red-600">{{$message}}</small>
                    @enderror
                    <button type="submit" class="mt-3   text-sm font-semibold bg-blue-600 hover:bg-blue-700 text-white py-1 px-2 rounded-md">Submit Comment</button>
                </form>
            </div>
            @endif
            
        </div>
    </div>
</div>
@endsection