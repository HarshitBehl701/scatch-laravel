@php
    $objArray = [
        [
        'src'  => '/assets/image1.jpg',
        'heading' => "Heading",
        'subHeading' => "Sub Heading",
        'is_text_enable'  => true
        ],[
        'src'  => '/assets/image2.jpg',
        'heading' => "Heading",
        'subHeading' => "Sub Heading",
        'is_text_enable'  => true
        ],[
        'src'  => '/assets/slider1.jpg',
        'heading' => "Heading",
        'subHeading' => "Sub Heading",
        'is_text_enable'  => true
        ]];
@endphp


<header  class="w-[90%]  mx-auto relative">
    <x-carousel :objArray="$objArray" navigation="show" />
</header>