@extends('layouts.main')

@section('content')

<div class="min-h-screen px-8">
    <div class="container mx-auto">
        <!-- Page Header -->
        <h1 class="text-3xl font-semibold italic  hover:text-blue-600  cursor-pointer mb-8 text-center text-gray-800">Shop Our Collection</h1>

        <!-- Two Section Layout -->
        <div class="flex flex-col md:flex-row gap-8">
            
            <!-- Sidebar Section -->
            <aside class="w-full md:w-1/4 p-6 bg-white rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold mb-4 text-gray-700">Categories</h2>
                <ul class="space-y-3 text-gray-600  font-semibold">
                    <li><a href="#" class="hover:text-blue-600">Electronics</a></li>
                    <li><a href="#" class="hover:text-blue-600">Fashion</a></li>
                    <li><a href="#" class="hover:text-blue-600">Home & Living</a></li>
                    <li><a href="#" class="hover:text-blue-600">Books & Stationery</a></li>
                </ul>
            </aside>

            <!-- Products Grid Section -->
            <section class="w-full md:w-3/4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <x-card  />
                <x-card  />
                <x-card  />
                <x-card  />
                <x-card  />
                <x-card  />
                <x-card  />
                <x-card  />
                <x-card  />
            </section>
        </div>
    </div>
</div>


@endsection