@extends('layouts.main')

@php
    $currentUser =  session('userType');
    $currentPage = Route::current()->parameter('page');
    $menuNames = [
        'user' =>  ['orders','cart','whislist'],
        'seller'  =>  ['add-product','all-products','live-products','manage-orders'],
    ]
@endphp

@section('content')
<div class="flex w-[90%] gap-5 mx-auto  flex-wrap">
    <!-- Sidebar -->
    <div class="w-64 shadow-sm border rounded-md p-4 hidden md:flex  flex-col justify-between">
        <div class="topSection">
        <h2 class="text-xl font-semibold mb-6">{{ucfirst($currentUser)}} Dashboard</h2>
        <ul class="text-sm font-semibold">
            <a href="/{{$currentUser}}/profile" class="hover:text-white">
            <li class="mb-4 border-b  {{$currentPage == 'profile'  ? 'bg-blue-600 text-white   rounded-md': ''}} hover:bg-blue-600 hover:rounded-md border-gray-200  py-1  px-2">
                Profile
            </li>
            </a>
            <a href="/{{$currentUser}}/edit-profile" class="hover:text-white">
            <li class="mb-4 border-b {{$currentPage == 'edit-profile'  ? 'bg-blue-600 text-white   rounded-md': ''}} hover:bg-blue-600 hover:rounded-md border-gray-200  py-1  px-2">
                Edit Profile
            </li>
            </a>
            @foreach ($menuNames[$currentUser] as $name)
            <a href="/{{$currentUser}}/{{$name}}" class="hover:text-white">
            <li class="mb-4 border-b  {{$currentPage == $name  ? 'bg-blue-600 text-white   rounded-md': ''}} hover:bg-blue-600 hover:rounded-md border-gray-200  py-1  px-2">
                {{ucfirst($name)}}
            </li>
            </a>
            @endforeach
        </ul>
        </div>
        <ul>
            <li>
                <a href="/logout"  class="px-2 py-1  bg-red-600  font-semibold  hover:bg-red-700 text-white rounded-md  shadow-sm text-xs">Logout</a>
            </li>
        </ul>
    </div>

    {{-- top  Navbar --}}
    <x-user-admin-nav />

    <!-- Main Content -->
    <div class="flex-1 border  rounded-md">
        <div class="bg-white p-6 h-full rounded-lg">
            @yield('adminContent')
        </div>
    </div>
</div>

@endsection