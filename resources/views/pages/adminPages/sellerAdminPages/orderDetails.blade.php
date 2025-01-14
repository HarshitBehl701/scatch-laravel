@extends('layouts.admin')
@php
    require_once app_path('Helpers/helpers.php');
    $orderDetails  = get_order_details_seller(request('param1'),request('param2'),request('param3'));
    $currentStatus = $orderDetails['status'];

    $oppositeStatusForCurrentStatus = [
        'ordered'  => 'processing',    
        'processing' =>  'out-for-delivery',    
        'out-for-delivery' => 'delivered',    
    ];
    
@endphp
@section('adminContent')

<div class="flex flex-wrap gap-4">
    <!-- Product Image Section (Left Side) -->
    <div class="md:w-[250px]   w-full md:h-[250px]  h-[300px]">
        <div id="default-carousel" class="relative w-full   h-full" data-carousel="slide">
            <!-- Carousel wrapper -->
            <div class="relative h-full overflow-hidden rounded-lg">
                @foreach ($orderDetails['images'] as $image)
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
            <h2 class="text-2xl font-semibold mb-4">{{$orderDetails['name']}}</h2>
            <p class="text-gray-700 mb-2">{{$orderDetails['description']}}</p>
            <p class="text-gray-700 mb-2">Order  Status  : <span class="font-semibold">{{ucfirst($orderDetails['status'])}}</span>
            @php
                $updateDate   = new DateTime($orderDetails['updateDate']);
            @endphp
            <small>({{$updateDate->format('d M Y  H:i:s A')}})</small>
            </p>
            <p class="text-gray-700 mb-2">Order  Date  : <span class="font-semibold">
                @php
                    $orderDate   = new DateTime($orderDetails['orderDate']);
                @endphp
                {{$orderDate->format('d M Y  H:i:s A')}}
            </span></p>
            <p  class="text-gray-700 mb-2">Order  Amount : <span class="text-xl font-semibold text-gray-900">&#8377;{{$orderDetails['order_amount']}}</span></p>
            <p  class="text-gray-700 mb-2">Current Amount : <span class="text-xl font-semibold text-gray-900">&#8377;{{$orderDetails['current_price']}}</span></p>
            <p  class="text-gray-700 mb-2">Current Discount : <span class="text-xl font-semibold text-gray-900">&#8377;{{$orderDetails['current_price'] - ($orderDetails['current_price'] *  $orderDetails['current_discount']/100)}} <small>(%{{$orderDetails['current_discount']}} of  &#8377;{{$orderDetails['current_price']}})</small></span></p>
            <p class="text-xl text-gray-700">Rating :
                @for ($i = 0; $i < 5; $i++)
                <span class="{{$i < $orderDetails['rating']  ? 'text-yellow-400' : ''}}">&#9733;</span>
                @endfor
            </p>

            @if ($currentStatus !==   'cancel' && $currentStatus !==   'delivered')
            <a href="/seller/update_order_status/{{$oppositeStatusForCurrentStatus[$currentStatus]}}/{{$orderDetails['orderId']}}"  class="px-2 py-1 border rounded-md shadow-sm  text-sm font-semibold bg-blue-600 hover:bg-blue-700  text-white  inline-block my-2 ">Marked As {{ucfirst($oppositeStatusForCurrentStatus[$currentStatus])}}</a>
            <a href="/seller/update_order_status/cancel/{{$orderDetails['orderId']}}"  class="px-2 py-1 border rounded-md shadow-sm  text-sm font-semibold bg-red-600 hover:bg-red-700  text-white  inline-block my-2 ">Cancel  This Order</a>
            @endif

            @if ($orderDetails['status'] == 'delivered')
            <div class="commentContainer">
                <h4  class="text-xl">User Comment</h4>
                <div class="commentCont p-4 rounded-md shadow-sm border mt-3 max-h-400px   overflow-y-auto">
                    @if (isset($orderDetails['comment']) && $orderDetails['comment'] != '') 
                    <x-comment :commentData="$orderDetails['comment']"/>
                    @else
                    <p class="italic font-light  text-sm">No Comments...</p>
                    @endif
                </div>
            </div>
            @endif
            
        </div>
    </div>
</div>

@endsection