@extends('layouts.main')

@php
    $objArray = [
        [
        'src'  => 'assets/aboutUs1.jpeg',
        'is_text_enable' => false
        ],[
        'src'  => 'assets/aboutUs2.png',
        'is_text_enable' => false
        ],[
        'src'  => 'assets/aboutUs3.jpg',
        'is_text_enable' => false
        ],[
        'src'  => 'assets/aboutUs4.jpg',
        'is_text_enable' => false
        ]
        ];
@endphp

@section('content')

<main class="container mx-auto px-6 py-12 font-sans">
    <section class="text-center">
      <h2 class="text-3xl font-semibold text-blue-600 tracking-tight leading-tight">
        About Scatch
      </h2>
      <p class="mt-2 text-lg text-gray-700 max-w-5xl mx-auto leading-relaxed">
        At <span class="font-semibold text-blue-600">E-Shop</span>, we
        believe online shopping should be more than just a transaction; it
        should be an experience. Discover a curated selection of quality
        products that meet your needs and exceed your expectations.
      </p>
    </section>

    <section class="mt-16 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
      <x-carousel :objArray="$objArray" navigation="hide" />
      <div>
        <h3 class="text-3xl font-semibold text-gray-800 leading-snug">
          Who We Are
        </h3>
        <p class="mt-6 text-gray-600 text-lg leading-relaxed">
          Established in 2023,
          <span class="font-medium text-blue-600">E-Shop</span> has been
          dedicated to transforming how people shop online. From our humble
          beginnings to becoming a trusted name in e-commerce, our journey
          is built on delivering quality, innovation, and trust to our
          customers.
        </p>
        <p class="mt-4 text-gray-600 text-lg leading-relaxed">
          With a team of passionate professionals, we constantly strive to
          offer the best products, seamless services, and an unforgettable
          shopping experience.
        </p>
      </div>
    </section>

    <section class="mt-20 bg-gradient-to-r from-blue-50 to-blue-100  w-full py-8 px-10 rounded-lg shadow-lg">
      <h3 class="text-2xl font-semibold text-center text-gray-900">
        Our Mission
      </h3>
      <p class="mt-3 text-center text-gray-700 text-sm max-w-4xl mx-auto leading-relaxed">
        To revolutionize online shopping by creating an environment where
        convenience, quality, and customer satisfaction converge seamlessly.
        We aim to connect people with products that inspire and enrich their
        lives.
      </p>
    </section>

    <section class="mt-20">
      <h3 class="text-3xl font-semibold text-center text-gray-900">
        Our Core Values
      </h3>
      <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-12">
        <div class="text-center  border p-8 bg-white shadow-md rounded-lg">
          <div class="text-6xl text-blue-600 mb-6">🤝</div>
          <h4 class="text-xl font-semibold text-gray-800">Integrity</h4>
          <p class="mt-2 text-gray-600 leading-relaxed">
            Honesty and transparency are at the heart of everything we do.
          </p>
        </div>
        <div class="text-center border p-8 bg-white shadow-md rounded-lg">
          <div class="text-6xl text-blue-600 mb-6">🌟</div>
          <h4 class="text-xl font-semibold text-gray-800">
            Excellence
          </h4>
          <p class="mt-2 text-gray-600 leading-relaxed">
            Continuously exceeding expectations with exceptional service.
          </p>
        </div>
        <div class="text-center  border p-8 bg-white shadow-md rounded-lg">
          <div class="text-6xl text-blue-600 mb-6">🌍</div>
          <h4 class="text-xl font-semibold text-gray-800">
            Sustainability
          </h4>
          <p class="mt-2 text-gray-600 leading-relaxed">
            Committed to creating a greener future for generations to come.
          </p>
        </div>
      </div>
    </section>

    <section class="mt-20 border shadow-sm  py-4  rounded-md">
     <x-testimonials />
    </section>

    <section class="mt-20 text-center">
      <h3 class="text-3xl font-semibold text-gray-900">
        Join the E-Shop Family
      </h3>
      <p class="mt-2  text-gray-700 leading-relaxed max-w-2xl mx-auto">
        Become a part of our growing community and enjoy the benefits of a
        seamless online shopping experience. Explore our wide range of
        products today!
      </p>
      <a href='/products' class="inline-block mt-5 px-4 py-2 bg-blue-600 text-white rounded-lg shadow-md font-medium hover:bg-blue-700 transition">
        Start Shopping
      </a>
    </section>
  </main>

@endsection