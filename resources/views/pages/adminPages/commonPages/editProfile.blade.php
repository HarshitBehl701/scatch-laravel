@extends('layouts.admin')

@section('adminContent')

<div class="w-full max-w-4xl bg-white overflow-hidden">
    <!-- Profile Image Upload -->
    <div class="p-6 text-center">
        <div class="w-32 h-32 bg-gray-200 rounded-full overflow-hidden mx-auto mb-4">
            <img src="{{ asset('images/profile.jpg') }}" alt="User Image" class="object-cover w-full h-full">
        </div>
    </div>

    <!-- Edit Profile Form -->
    <form action="" method="POST" class="p-6">
        @csrf
        @method('PUT')
        
        <!-- Name Field -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', 'John Doe') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('name')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', 'johndoe@example.com') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('email')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Contact Field -->
        <div class="mb-4">
            <label for="contact" class="block text-gray-700 font-semibold">Contact</label>
            <input type="text" id="contact" name="contact" value="{{ old('contact', '+1 (234) 567-8901') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('contact')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Address Field -->
        <div class="mb-4">
            <label for="address" class="block text-gray-700 font-semibold">Address</label>
            <textarea id="address" name="address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address', '1234 Elm Street, Springfield, IL') }}</textarea>
            @error('address')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Update Button -->
        <div class="text-right">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Update Profile
            </button>
        </div>
    </form>
</div>

@endsection