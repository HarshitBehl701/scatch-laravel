@php
    $categories = [
        [
            'name' => 'clothing',
            'imageSrc' =>  '/assets/clothing.jpg'
        ],
        [
            'name' => 'shoes',
            'imageSrc' =>  '/assets/shoes.jpg'
        ],
        [
            'name' => 'electronics',
            'imageSrc' =>  '/assets/electronics.jpg'
        ],
        [
            'name' => 'accessories',
            'imageSrc' =>  '/assets/accessories.jpg'
        ],
        [
            'name' => 'baby',
            'imageSrc' =>  '/assets/baby.jpg'
        ]
    ]
@endphp

<div class="categoriesContainer flex items-center  flex-wrap justify-center gap-8">
    @foreach ($categories as $categoryObj)
    <a href="/{{$categoryObj['name']}}">
        <div class="category">
            <div class="imageCont w-24 h-24 rounded-full overflow-hidden shadow-sm border flex flex-col items-center justify-center">
                <img src={{asset($categoryObj['imageSrc'])}} alt="image" class="object-cover w-full h-full">
            </div>
            <p class="text-center mt-2 text-sm">{{$categoryObj['name']}}</p>
        </div>
    </a>
    @endforeach
</div>
