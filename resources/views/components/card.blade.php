@php
    $cartBtnLink =  '/'.'product_detail/'.urlencode($cardData['name']).'/'.$cardData['id'];
    $whislistBtnLink =  '/login';
    $buttonText =  'Add To Cart';
    $in_cart =   false;
    $in_whislist =   false;

    if(session()->has('userType')  && session()->has('email')){
        $cartBtnLink = '/user/manage_cart/add/'.urlencode($cardData['name']).'/'.$cardData['id'];
        $whislistBtnLink = '/user/manage_whislist/add/'.urlencode($cardData['name']).'/'.$cardData['id'];
        $in_cart = $cardData['in_cart'];
        $in_whislist = $cardData['in_whislist'];

        if($in_cart){
            $buttonText =   'Remove  From Cart';
            $cartBtnLink = '/user/manage_cart/remove/'.urlencode($cardData['name']).'/'.$cardData['id'];
        }
        if($in_whislist){
            $whislistBtnLink = '/user/manage_whislist/remove/'.urlencode($cardData['name']).'/'.$cardData['id'];
        }
    }

@endphp
<div class="w-full  h-full relative md:w-[260px] bg-white rounded-lg shadow dark:bg-gray-800">
    <div class="whislist absolute top-1 right-1 z-40 flex items-center justify-center">
        @if (session()->has('userType')  && session()->has('email'))
        <a   href="{{$whislistBtnLink}}" class="inline-block w-full h-full bg-white p-2 rounded-full shadow-smbg-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="{{$in_whislist ? 'red' :  'black'}}">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>              
            </a>
        @endif
    </div>
    <a href="/product_detail/{{urlencode($cardData['name'])}}/{{$cardData['id']}}" >
    <div id="default-carousel" class="relative w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-52 overflow-hidden border rounded-lg">
            @foreach ($cardData['images'] as $image)
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <div class="imagecontainer absolute object-cover object-top block w-full" >
                    <img src="{{Storage::url($image)}}" alt="..."   class="object-cover  object-top w-full h-full">
                </div>
            </div>
            @endforeach
        </div>
    </div>
</a>
    <div class="px-5 pb-5  mt-2 flex flex-col justify-between">
        <a href="/product_detail/{{urlencode($cardData['name'])}}/{{$cardData['id']}}">
            <h5 class="text-sm font-semibold tracking-tight text-gray-900 dark:text-white">{{$cardData['name']}}</h5>
        <div class="flex items-center mt-2.5 mb-3">
            <div class="flex items-center space-x-1 rtl:space-x-reverse">
                @for ($i = 1; $i <= 5; $i++)
                <svg class="w-4 h-4 {{$i <= $cardData['rating'] ? 'text-yellow-300' :   'text-gray-300'}}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                </svg>
                @endfor
            </div>
            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ms-3">{{$cardData['rating']}}.0 <small  class="text-gray-500">({{$cardData['number_of_customer_rate']}})</small></span>
        </div>
    </a>
        <div class="flex items-center justify-between">
            <span class="text-xl font-bold text-gray-900 dark:text-white">&#8377; {{$cardData['price'] -  (($cardData['discount']/100)*$cardData['price'])}} <small class="line-through text-gray-500">({{$cardData['price']}})</small></span>
            @if (session()->has('userType')  &&  session()->has('email'))
            <a href="{{$cartBtnLink}}" class="text-white {{$in_cart ? 'bg-red-700 hover:bg-red-800 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800' : 'bg-blue-700  hover:bg-blue-800 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800'}}  focus:ring-4 focus:outline-none  font-medium rounded-lg text-xs px-2 py-1 text-center ">{{$buttonText}}</a>
            @else
                <a href="{{$cartBtnLink}}"  class="px-2 py-1  border  rounded-md shadow-sm text-white font-semibold text-xs  bg-blue-600 hover:bg-blue-700">See Product</a>
            @endif
        </div>
    </div>
</div>