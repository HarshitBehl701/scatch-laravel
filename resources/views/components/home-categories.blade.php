@php
    $categories = $categoriesData['categoriesData'];
@endphp

<h3 class="text-center text-3xl font-mono font-semibold cursor-pointer mb-6 animate__animated animate__fadeIn animate__delay-2s">
    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 transition-all duration-1000 ease-in-out transform scale-100 cursor-pointer animate__animated animate__fadeIn animate__delay-1s">
        Shop
    </span>
    
    <span class="text-transparent bg-clip-text bg-black hover:bg-gradient-to-l hover:from-yellow-400 hover:to-red-500 transition-all duration-500 ease-in-out transform hover:scale-110 cursor-pointer animate__animated animate__fadeIn animate__delay-1s">
      By
    </span>
    
    <span class="text-transparent bg-clip-text bg-black hover:bg-gradient-to-l hover:from-yellow-400 hover:to-red-500 transition-all duration-500 ease-in-out transform hover:scale-110 cursor-pointer animate__animated animate__fadeIn animate__delay-2s">
      Categories
    </span>
  </h3>

<div class="categoriesContainer flex items-center w-[90%] mx-auto mt-8  mb-14  flex-wrap justify-center gap-8">
    @foreach ($categories as $data)
    <a href="/products/search?category={{$data['name']}}">
        <div class="category  hover:scale-105  transition-all duration-300">
            <div class="imageCont w-24 h-24 rounded-full overflow-hidden shadow-sm border flex flex-col items-center justify-center">
                <img src={{asset('/assets/'.$data['image'])}} alt="image" class="object-cover w-full h-full">
            </div>
            <p class="text-center font-semibold mt-2 text-sm">{{ucfirst($data['name'])}}</p>
        </div>
    </a>
    @endforeach
</div>
