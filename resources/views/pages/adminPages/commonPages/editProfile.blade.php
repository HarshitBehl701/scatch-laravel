@extends('layouts.admin')

@php
    $currentUserType = session('userType');
    $userData  = $pageData['userDetail'];
    $imageSrc = 'user.png';
    if($currentUserType == 'seller'){
        $imageSrc = $userData['brandLogo'] ??  $imageSrc;
    }else  if($currentUserType  ==    'user'){
        $imageSrc = $userData['picture'] ??  $imageSrc;
    }

@endphp

@section('adminContent')
<div class="w-full max-w-4xl bg-white overflow-hidden">
    <!-- Profile Image Upload -->
    <div class="p-6 flex flex-col items-center  justify-center">
        <form action="{{$currentUserType == 'user' ? route('user.uploadProfileImage') : route('seller.uploadProfileImage')}}" id="imageUploadForm" method="post" enctype="multipart/form-data">
            @csrf
            <div class="w-28 h-28 rounded-full overflow-hidden border border-gray-300 shadow-sm relative group">
            <!-- Hidden File Input -->
            <input type="file" id="file" name="file" accept="image/*" class="hidden" onchange="document.querySelector('#imageUploadForm').submit()" />
            <img src="{{ ($imageSrc == 'user.png')  ? asset('/assets/user.png') : Storage::url($imageSrc) }}" alt="Upload" class="absolute object-cover object-top z-0 w-full h-full" />
            <!-- Hover Image Display -->
            <label for="file" 
                   class="w-full h-full flex items-center justify-center absolute z-2 cursor-pointer group-hover:backdrop-blur-sm transition">
              <img src="{{ asset('/assets/camera.svg') }}" 
                   alt="Upload" 
                   class="w-4 opacity-0 group-hover:opacity-100 transition duration-300" />
            </label>
          </div>
        </form>          
        <p  class="font-semibold text-sm italic mt-1">Profile  Picture</p>
    </div>

    <!-- Edit Profile Form -->
    <form action="{{$currentUserType == 'user' ? route('user.updateProfile') : route('seller.updateProfile')}}" method="POST" class="p-6 pt-2">
        @csrf
        
        <!-- Name Field -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') ?? $userData['name'] }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('name')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        @if ($currentUserType   == 'seller')
        <!-- Brand Name Field -->
        <div class="mb-4">
            <label for="brandName" class="block text-gray-700 font-semibold">Brand  Name</label>
            <input type="text" id="brandName" name="brandName" value="{{ old('brandName') ?? $userData['brandName'] }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('brandName')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        @endif

        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold">Email</label>
            <input type="email" id="email" value="{{ $userData['email'] }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" readonly>
            @error('email')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Contact Field -->
        <div class="mb-4">
            <label for="contact" class="block text-gray-700 font-semibold">Contact</label>
            <input type="text" id="contact" name="contact" value="{{ old('contact') ??  $userData['contact'] }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('contact')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Address Field -->
        <div class="mb-4">
            <label for="address" class="block text-gray-700 font-semibold">Address</label>
            <textarea id="address" name="address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address')   ?? $userData['address'] }}</textarea>
            @error('address')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

         @if ($currentUserType ==  'seller')
        <!-- GSTIN  Field -->
         <div class="mb-4">
            <label for="gstin" class="block text-gray-700 font-semibold">GSTIN</label>
            <input type="text" id="gstin" name="gstin" value="{{ old('gstin') ??  $userData['gstin'] }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('gstin')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
         @endif

        <!-- Update Button -->
        <div class="text-right">
            <button type="submit" class="px-3 py-2  text-xs  font-semibold bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Save  Changes
            </button>
        </div>
    </form>
</div>

@endsection