@extends('layouts.main')

@section('content')

<div class="flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full  border max-w-sm">
        <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Register</h2>
        <form action="{{route('user.register')}}" method="POST">
            @csrf
            <!-- Full Name Input -->
            <div class="mb-4">
                <label for="name" class="block text-gray-600">Full Name</label>
                <input type="text" id="name" name="name"  value="{{old('name')}}" placeholder="Enter your full name"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('name')
                    <small   class="text-red-600">{{$message}}</small>
                @enderror
            </div>

            <!-- Email Input -->
            <div class="mb-4">
                <label for="email" class="block text-gray-600">Email</label>
                <input type="email" id="email" name="email" value="{{old('email')}}" placeholder="Enter your email"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('email')
                    <small   class="text-red-600">{{$message}}</small>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="mb-4">
                <label for="password" class="block text-gray-600">Password</label>
                <div class="relative">
                    <input type="password" id="password" value="{{ old('password') }}" name="password"
                    placeholder="Enter your password"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <!-- Password Toggle Button -->
                    <button type="button" id="togglePassword"
                    class="absolute inset-y-0 right-3 flex items-center text-gray-600">
                    <img src="{{ asset('/assets/eye.svg') }}" alt="eyeSvg" id="eye" class="w-5 h-5">
                    <img src="{{ asset('/assets/eyeSlash.svg') }}" alt="eyeSlashSvg" id="eyeSlash" class="w-5 h-5 hidden">
                    </button>
                </div>
                @error('password')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>            

            <!-- Confirm Password Input -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-600">Confirm Password</label>
                <input type="password" id="password_confirmation" value="{{old('password_confirmation')}}" name="password_confirmation" placeholder="Confirm your password"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('password_confirmation')
                    <small   class="text-red-600">{{$message}}</small>
                @enderror
            </div>

            <!-- Register Button -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Register
            </button>
        </form>

        <!-- Login Link -->
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">Already have an account? <a href="/login" class="text-blue-500 hover:underline">Login</a></p>
        </div>
    </div>
</div>


@endsection