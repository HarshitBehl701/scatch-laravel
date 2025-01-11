@extends('layouts.main')

@section('content')

{{-- product details --}}
<div class="twoSectionLayout flex flex-wrap gap-5  justify-center px-8">
    <div class="leftSection  w-full md:w-[300px]  h-[300px]  overflow-hidden rounded-md shadow-sm">
        <img src="https://placehold.co/300" alt=""   class="object-cover  w-full md:w-[300px]  h-[300px]">
    </div>
    <div class="rightSection w-full md:w-[60%]">
        <h1 class="text-3xl">Product   Name</h1>
        <ul  class="mt-2">
            <li  class="flex mb-1 justify-between  items-center flex-wrap  md:w-[90%]"><span>Brand Name</span><span  class="w-1/2   text-right">brandname</span></li>
            <li  class="flex mb-1 justify-between  items-center flex-wrap  md:w-[90%]"><span>Description</span><span  class="w-1/2   text-right">Description</span></li>
            <li  class="flex mb-1 justify-between  items-center flex-wrap  md:w-[90%]"><span>Rating</span><span  class="w-1/2   text-right">Rating(user)</span></li>
            <li  class="flex mb-1 justify-between text-xl items-center flex-wrap  md:w-[90%]"><span>Price</span><span  class="w-1/2   text-right">1000</span></li>
            <li   class="flex mb-1 justify-end  mt-3 md:w-[90%]">
                <a class="bg-blue-600 hover:bg-blue-700 cursor-pointer inline-block  px-2  py-1  rounded-md  shadow-sm text-white font-semibold">Add  To Cart</a>
            </li>
        </ul>
    </div>
</div>

{{-- comment  section --}}
<div class="commentsection md:py-8 md:px-12 px-4 py-4 rounded-lg  shadow-sm   w-[90%]  mx-auto border   mt-12">
    <h2 class="text-xl mb-4">Comments</h2>

    <div class="commentContainer max-h-[250px]  overflow-y-auto">
        <x-comment />
    <x-comment />
    <x-comment />
    <x-comment />
    </div>

</div>

{{-- Other  Products --}}
<div class="otherProductsSection w-[90%]  mx-auto mt-12">
    <h2 class="text-2xl mb-4">View Also</h2>
    <x-products-row  />
</div>

@endsection