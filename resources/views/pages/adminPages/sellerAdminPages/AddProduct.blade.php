@extends('layouts.admin')

@section('adminContent')

<div class="p-6">
    <form class="space-y-4">
    <!-- Product Image Inputs Section -->
    <div class="grid grid-cols-5 gap-1">
      @for ($i = 1; $i <= 5; $i++)
      <div class="w-28 h-28 rounded-full overflow-hidden border border-gray-300 shadow-sm relative group">
        <!-- Hidden File Input -->
        <input type="file" id="product_image_{{ $i }}" name="product_images[]" accept="image/*" class="hidden" />
        
        <!-- Hover Image Display -->
        <label for="product_image_{{ $i }}" 
               class="w-full h-full flex items-center justify-center cursor-pointer group-hover:bg-gray-100 transition">
          <img src="{{ asset('/assets/camera.svg') }}" 
               alt="Upload" 
               class="w-4 opacity-0 group-hover:opacity-100 transition duration-300" />
        </label>
      </div>
        
      @endfor
    </div>
    <p class="italic text-xs font-semibold   text-center  mb-4 mt-3   border-b border-gray-400 pb-3">Product Images  <small>(Maximum  5 uploads are allowed)</small></p>
    <!-- Product Form Section -->
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
        <input type="text" id="name" name="name" 
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" 
               placeholder="Enter product name" />
      </div>
  
      <div>
        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
        <select id="category" name="category" 
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
          <option>Select category</option>
          <option>Electronics</option>
          <option>Clothing</option>
          <option>Home & Kitchen</option>
        </select>
      </div>
  
      <div>
        <label for="subcategory" class="block text-sm font-medium text-gray-700">Subcategory</label>
        <select id="subcategory" name="subcategory" 
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
          <option>Select subcategory</option>
          <option>Mobiles</option>
          <option>Men's Wear</option>
          <option>Furniture</option>
        </select>
      </div>
  
      <div>
        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
        <input type="number" id="price" name="price" 
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" 
               placeholder="Enter price" />
      </div>
  
      <div>
        <label for="discount" class="block text-sm font-medium text-gray-700">Discount (%)</label>
        <input type="number" id="discount" name="discount" 
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" 
               placeholder="Enter discount" />
      </div>
  
      <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea id="description" name="description" rows="3" 
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" 
                  placeholder="Enter product description"></textarea>
      </div>
  
      <!-- Add Product Button -->
      <button type="submit" 
              class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-2 py-1 rounded-md">
        Add Product
      </button>
    </form>
  </div>
  


@endsection