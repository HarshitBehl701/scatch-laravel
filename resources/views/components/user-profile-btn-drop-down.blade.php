@php
    $userType =  session('userType');
    if($userType == 'user'){
      $dropDownOptions = ['profile','orders','cart','whislist'];
    }else{
      $dropDownOptions = ['profile','all-products','add-product'];
    }
@endphp

<button type="button" class="flex text-sm rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-{{$componentId}}" aria-expanded="false" data-dropdown-toggle="user-dropdown-{{$componentId}}" data-dropdown-placement="bottom">
    <span class="sr-only">Open user menu</span>
    <img class="w-12 h-12 rounded-full" src={{asset('/assets/user.png')}} alt="user photo">
  </button>
  <!-- Dropdown menu -->
  <div class="z-50 hidden my-4 text-base  overflow-hidden list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown-{{$componentId}}">
    <div class="px-4 py-3">
      <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">{{session('email')}}</span>
    </div>
    <ul class="pt-2" aria-labelledby="user-menu-{{$componentId}}">
      @foreach ($dropDownOptions as $option)
      <li>
        <a href="/{{$userType}}/{{$option}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">{{ucfirst($option)}}</a>
      </li>
      @endforeach
      <li>
        <a href="/logout" class="block px-4 py-2 text-sm text-white hover:bg-red-700 bg-red-600">Logout</a>
      </li>
    </ul>
</div>