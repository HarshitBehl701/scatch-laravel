@php
    $objArray = [
    [
        'src' => '/assets/image1.jpg',
        'heading' => "Discover Exclusive Collections",
        'subHeading' => "Elevate Your Style with Our Handpicked Products",
        'is_text_enable' => true
    ],
    [
        'src' => '/assets/image2.jpg',
        'heading' => "Unmatched Deals Await",
        'subHeading' => "Shop More, Save More—Limited Time Offers",
        'is_text_enable' => true
    ],
    [
        'src' => '/assets/slider1.jpg',
        'heading' => "Trending Now",
        'subHeading' => "Find What’s Hot and In-Demand Today",
        'is_text_enable' => true
    ]
];
@endphp


<header  class="w-[90%]  mx-auto relative">
    <x-carousel :objArray="$objArray" navigation="show" />
</header>