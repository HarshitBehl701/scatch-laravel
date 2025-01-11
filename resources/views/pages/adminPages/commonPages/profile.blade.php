@extends('layouts.admin')

@section('adminContent')

<div class="w-full max-w-4xl bg-white overflow-hidden">
    <div class="flex items-center">
        <!-- Profile Image -->
        <div class="w-32 h-32 bg-gray-200 rounded-full overflow-hidden">
            <img src="https://placehold.co/400" alt="User Image" class="object-cover w-full h-full">
        </div>

        <!-- User Info -->
        <div class="ml-6">
            <h2 class="text-2xl font-semibold text-gray-800">John Doe</h2>
            <p class="text-gray-600 mt-1">johndoe@example.com</p>
            <p class="text-gray-600 mt-1">+1 (234) 567-8901</p>
            <p class="text-gray-600 mt-1">1234 Elm Street, Springfield, IL</p>
            <a href="/user/edit-profile"  class="px-2 py-1 mt-3  inline-block  shadow-sm text-white text-xs  bg-blue-600  hover:bg-blue-700 font-semibold  rounded-md">Edit  Profile</a>
        </div>
    </div>
</div>

@endsection