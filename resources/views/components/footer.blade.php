<div class="getEmailUpdates  w-full py-1  mt-12  px-3 bg-slate-100"></div>
      <footer class="w-full h-fit bg-[#2D3142]">
        <div class="upperSection text-white flex flex-wrap  gap-4 pt-12 pb-8 md:px-20 px-8 justify-between  w-full ">
          <ul class="md:w-1/6 w-full">
            <li class="flex items-center  gap-2">
              <img
                src="/assets/logoBgRemove.png"
                class="h-12   cursor-pointer"
                alt="Flowbite Logo"
              />
              <h5 class="text-2xl font-semibold cursor-pointer hover:text-blue-400">
                Scatch
              </h5>
            </li>
            <li class="text-sm italic  mt-2">Your Store, Your Choice</li>
          </ul>
          <ul class="md:w-1/6 w-full">
            <li class="font-semibold">Quick as</li>
            <li>
              <a href="/home" class="hover:text-blue-500 text-sm ">
                Home
              </a>
            </li>
            <li>
              <a href="/about" class="hover:text-blue-500 text-sm  ">
                About
              </a>
            </li>
            <li>
              <a href="/products" class="hover:text-blue-500 text-sm">
                Products
              </a>
            </li>
          </ul>
          <ul  class="md:w-1/6 w-full">
            <li class="font-semibold">Important as</li>
            <li>
              <a href="/faq" class="hover:text-blue-500 text-sm">
                FAQ
              </a>
            </li>
            @if (!session()->has('userType'))
            <li class="">
              <a href="/seller-login" class="hover:text-blue-500 text-sm">
                Join As Seller
              </a>
            </li>
            @endif
          </ul>
          <ul class="cursor-pointer md:w-1/5 w-full">
            <li class="font-semibold">Get In Touch</li>
            <li class="text-sm">Email: scatch@helpdesk.in</li>
            <li class="text-sm">Mob: 123-456-789 , 123-456-789</li>
            <li class="text-sm">
              Address: R-z 24, some district, <br />
              city , country , 123012
            </li>
          </ul>
        </div>
      </footer>
      <div class="lowerSection text-white text-xs bg-zinc-800 w-full py-2">
          <p class="text-white  text-center">© 2024 All Rights Reserved. Scatch </p>
        </div>