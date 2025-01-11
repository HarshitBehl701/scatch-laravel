@extends('layouts.main')

@section('content')

<div class="flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm border">
        <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Seller  Login</h2>
        <form action="#" method="POST">
            <!-- Email Input -->
            <div class="mb-4">
                <label for="email" class="block text-gray-600">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Password Input -->
            <div class="mb-6">
                <label for="password" class="block text-gray-600">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Login Button -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Login
            </button>
        </form>

        <!-- Forgot Password Link -->
        <div class="mt-4 text-center">
            <a href="#" class="text-blue-600 text-sm hover:underline">Forgot your password?</a>
        </div>

        <!-- Register Link -->
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">Don't have an account? <a href="/seller-register" class="text-blue-600 hover:underline">Register</a></p>
        </div>
    </div>
</div>


@endsection