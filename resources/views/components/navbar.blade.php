@php
    $currentPage = Route::current()->parameter('page') ?? '/';
    $menuPages  = ['home','about','products','login','register'];
    if(session()->has('userType')){
      $menuPages   = ['home','about','products'];  
    }
@endphp

<nav class="bg-white border-gray-200 dark:bg-gray-900   md:px-8 shadow-sm  mb-12">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="/" class="flex items-center space-x-3 w-1/3 rtl:space-x-reverse">
            <img src="{{ asset('assets/logo.jpg') }}" class="h-8" alt="Flowbite Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap text-blue-600 hover:text-blue-700">Scatch</span>
        </a>
        <div class="flex items-center">
          <x-search mdScreen="block" elemIndex="1" />
          @if (session()->has('userType'))
            <div  class="mx-3 md:hidden block">
              <x-user-profile-btn-drop-down :componentId="2"  />
            </div>
            @endif
          <button data-collapse-toggle="navbar-search" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-search" aria-expanded="false">
              <span class="sr-only">Open main menu</span>
              <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
              </svg>
          </button>
        </div>
        @if (session()->has('userType'))
        <div  class="ml-3 md:order-2 md:block hidden">
          <x-user-profile-btn-drop-down :componentId="1"  />
        </div>
        @endif
        <div class="items-center justify-between hidden w-full md:flex md:w-auto  md:order-1" id="navbar-search">
          <div class="relative mt-3 md:hidden">
            <x-search mdScreen="hidden" elemIndex="2" />
            </div>
            <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
              @foreach ($menuPages as $page)
              <li>
                <a href="/{{ $page }}"
                class="block py-2 px-3 rounded md:p-0 
                {{ $currentPage === $page  || ($currentPage == '/' &&  $page  == 'home') ? 'text-blue-700 font-semibold' : 'text-gray-900 hover:text-blue-700 dark:text-white dark:hover:text-blue-500' }}">
                {{ ucfirst($page) }}
              </a>
            </li>
            @endforeach
            </ul>
          </div>
    </div>
  </nav>  