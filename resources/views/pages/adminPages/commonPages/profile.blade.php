@extends('layouts.admin')
@php
    $userDetail = $pageData['userDetail'];
    $currentUserType = session('userType');
    $imageSrc = "user.png";

    if($currentUserType ==  'user'){
        $imageSrc  =  $userDetail['picture'] ??  $imageSrc;
    }else if($currentUserType == 'seller'){
        $imageSrc  =   $userDetail['brandLogo']  ?? $imageSrc;
    }
@endphp
@section('adminContent')
<div class="w-full max-w-4xl bg-white overflow-hidden">
    <div class="flex items-center">
        <!-- Profile Image Upload -->
        <div class="p-6 flex flex-col items-center  justify-center">
            <form action="{{$currentUserType == 'user' ? route('user.uploadProfileImage') : route('seller.uploadProfileImage')}}" id="imageUploadForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="w-44 h-44 rounded-md overflow-hidden border border-gray-300 shadow-sm relative group">
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

        <!-- User Info -->
        <div class="ml-6 pt-4">
            <h2 class="text-2xl font-semibold text-gray-800">{{ucfirst($userDetail['name'])}}</h2>
            <p class="text-gray-600 mt-1">{{$userDetail['email']}}</p>
            @if ($currentUserType  ==  'seller')
            <p class="text-gray-600 mt-1">{{$userDetail['brandName']}}</p>
            <p class="text-gray-600 mt-1">
                @if ($userDetail['gstin'])
                {{$userDetail['gstin']}}
                @else
                <a href="/{{$currentUserType}}/edit-profile" class="font-light text-blue-600  italic text-sm">Add GSTIN</a>
                @endif
            </p>
            @endif
            <p class="text-gray-600 mt-1">
                @if ($userDetail['contact'])
                {{$userDetail['contact']}}
                @else
                <a href="/{{$currentUserType}}/edit-profile" class="font-light text-blue-600  italic text-sm">Add Contact</a>
                @endif
            </p>
            <p class="text-gray-600 mt-1">
                @if ($userDetail['address'])
                {{$userDetail['address']}}
                @else
                <a href="/{{$currentUserType}}/edit-profile" class="font-light text-blue-600  italic text-sm">Add Address</a>
                @endif
            </p>
            <a href="/{{$currentUserType}}/edit-profile"  class="px-2 py-1 mt-3  inline-block  shadow-sm text-white text-xs  bg-blue-600  hover:bg-blue-700 font-semibold  rounded-md">Edit  Profile</a>
        </div>
    </div>
</div>

@endsection