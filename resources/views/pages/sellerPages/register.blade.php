@extends('layouts.main')

@section('content')

<div class="flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full  border max-w-sm">
        <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Seller  Registeration</h2>
        <form action="#" method="POST">
            <!-- Full Name Input -->
            <div class="mb-4">
                <label for="name" class="block text-gray-600">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <!-- Brand Name Input -->
            <div class="mb-4">
                <label for="brandname" class="block text-gray-600">Brand Name</label>
                <input type="text" id="brandname" name="brandname" placeholder="Enter your Brand name"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Email Input -->
            <div class="mb-4">
                <label for="email" class="block text-gray-600">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Password Input -->
            <div class="mb-4">
                <label for="password" class="block text-gray-600">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Confirm Password Input -->
            <div class="mb-6">
                <label for="confirm_password" class="block text-gray-600">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Register Button -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Register
            </button>
        </form>

        <!-- Login Link -->
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">Already have an account? <a href="/seller-login" class="text-blue-500 hover:underline">Login</a></p>
        </div>
    </div>
</div>


@endsection