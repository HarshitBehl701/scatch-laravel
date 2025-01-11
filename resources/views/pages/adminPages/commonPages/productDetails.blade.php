@extends('layouts.admin')

@section('adminContent')

<div class="flex flex-wrap gap-4">
    <!-- Product Image Section (Left Side) -->
    <div class="w-full md:w-[250px] md:h-[250px]">
        <div class="bg-gray-200 rounded-md overflow-hidden">
            <img src="https://placehold.co/250" alt="Product Image" class="object-cover w-full h-full">
        </div>
    </div>

    <!-- Product Details Section (Right Side) -->
    <div class="md:w-full lg:w-2/3">
        <div class="bg-white md:px-6">
            <h2 class="text-2xl font-semibold mb-4">Product Name</h2>
            <p class="text-gray-700 mb-4">This is a brief description of the product. It gives an overview of the product's key features and qualities.</p>
            <p class="text-xl font-semibold text-gray-900 mb-4">$99.99</p>


            <button class="mt-6 text-xs bg-blue-600 text-white px-2 py-1   font-semibold rounded-md hover:bg-blue-700">Add to Cart</button>
        </div>
    </div>
</div>

@endsection