<div class="flex items-center bg-white shadow-sm  border rounded-lg p-4 gap-5">
    <div id="default-carousel" class="relative w-32" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-32 overflow-hidden rounded-lg md:h-32">
            @foreach ($images as $image)
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <div class="imagecontainer absolute object-cover object-top block w-full" >
                    <img src="{{Storage::url($image)}}" alt="..."   class="object-cover  object-top w-full h-full">
                </div>
            </div>
            @endforeach
        </div>
    </div>
     <div class="flex-1">
         <h3 class="text-lg font-semibold">{{$name}}</h3>
         <p class="text-gray-600 mt-2">{{$description}}</p>
         <p class="text-gray-800 mt-2">&#8377; {{$price}}</p>
     </div>
 </div>