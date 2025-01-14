@extends('layouts.admin')

@php
    $currentPage = Route::current()->parameter('page') ?? '/';
    $categories  = $pageData['categories'];
    $productDetail = (array_key_exists('product_details',$pageData)) ? $pageData['product_details'] : [];
    $images = (count($productDetail) >  0) ? $productDetail['images'] : [];
@endphp

@section('adminContent')

<div class="p-6">
    <form class="space-y-4" action="{{$currentPage == 'edit-product' ? route('product.update',['productId'  => $productDetail['id']]) : route('product.create')}}" method="POST" enctype="multipart/form-data">
      @csrf
    <!-- Product Image Inputs Section -->
    <div class="grid grid-cols-5 gap-1">
      @for ($i = 0; $i < 5; $i++)
      <div class="w-28 h-28 rounded-full overflow-hidden border border-gray-300 shadow-sm relative group">
        <!-- Hidden File Input -->
        <input type="file" id="product_image_{{ $i }}" name="product_images[]" accept="image/*" class="hidden uploadProductImage" />
        <img src={{(count($images)  >  0  && array_key_exists($i,$images)) ? Storage::url($images[$i]) : "https://placehold.co/400"}} alt="Upload" class="absolute object-cover object-top z-0 w-full h-full" />
        <!-- Hover Image Display -->
        <label for="product_image_{{ $i }}" 
               class="w-full h-full flex items-center justify-center absolute z-2 cursor-pointer group-hover:backdrop-blur-sm transition">
          <img src="{{ asset('/assets/camera.svg') }}" 
               alt="Upload" 
               class="w-4 opacity-0 group-hover:opacity-100 transition duration-300" />
        </label>
      </div>
        
      @endfor
    </div>
    <input type="hidden" name="oldImagesSrc"  value="{{implode(',',$images)}}">
    <p class="italic text-xs font-semibold   text-center  mb-4 mt-3   border-b border-gray-400 pb-3">@error('product_images')
      <small class="text-red-600">{{$message}}</small><br>
  @enderror
      Product Images  <small>(Maximum  5 uploads are allowed)</small><br><small>Allowed  File  Types Are JPEG,JPG,PNG And At Max file Size 2 MB  Are   Allowed</small></p>
    <!-- Product Form Section -->
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
        <input type="text" id="name" name="name" value="{{old('name')  ??  $productDetail['name'] ?? ''}}"
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" 
               placeholder="Enter product name" />
        @error('name')
            <small class="text-red-600">{{$message}}</small>
        @enderror
      </div>
  

      <div>
        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
        <select id="category" name="category" 
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
          <option  value="choose"  selected  hidden>Select category</option>
          @foreach ($categories as $category)
          <option 
          value="{{ $category['name'] }}" 
          id="{{ Str::slug($category['name']) }}" 
          data-subcategories-selected="{{ old('subCategory') ?? $productDetail['subcategory'] ?? '' }}" 
          data-subcategories="{{ json_encode($category['subCategories']) }}" 
          {{ $category['name'] == old('category') || (array_key_exists('category',$productDetail) &&  $category['name'] == $productDetail['category']) ? 'selected' : '' }}>
          {{ ucfirst($category['name']) }}
          </option>

          @endforeach
        </select>
        @error('category')
            <small class="text-red-600">{{$message}}</small>
        @enderror
      </div>
  
      <div>
        <label for="subcategory" class="block text-sm font-medium text-gray-700">Subcategory</label>
        <select id="subcategory" name="subcategory" 
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
          <option value="choose" selected hidden>Select subcategory</option>
        </select>
        @error('subcategory')
            <small class="text-red-600">{{$message}}</small>
        @enderror
      </div>
  
      <div>
        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
        <input type="number" id="price" name="price" value="{{old('price')  ?? $productDetail['price'] ?? ''}}" 
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" 
               placeholder="Enter price" />
               @error('price')
            <small class="text-red-600">{{$message}}</small>
        @enderror
      </div>
  
      <div>
        <label for="discount" class="block text-sm font-medium text-gray-700">Discount (%)</label>
        <input type="number" id="discount" name="discount" value="{{old('discount')??  $productDetail['discount']   ??   ''}}"
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" 
               placeholder="Enter discount" />
               @error('discount')
            <small class="text-red-600">{{$message}}</small>
        @enderror
      </div>
  
      <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea id="description" name="description" rows="3"
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" 
                  placeholder="Enter product description">{{old('name')  ?? $productDetail['description']   ??  ''}}</textarea>
                  @error('description')
            <small class="text-red-600">{{$message}}</small>
        @enderror
      </div>
  
      <!-- Add Product Button -->
      <button type="submit" 
              class="bg-blue-600  text-sm hover:bg-blue-700 text-white font-semibold px-2 py-1 rounded-md">
        {{$currentPage  == 'edit-product' ? 'Update  Product'  :  'Add Product'}}
      </button>
    </form>
  </div>
  


@endsection