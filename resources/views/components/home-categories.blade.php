@php
    $categories = $categoriesData['categoriesData'];
@endphp

<div class="categoriesContainer flex items-center  flex-wrap justify-center gap-8">
    @foreach ($categories as $data)
    <a href="/{{$data['name']}}">
        <div class="category">
            <div class="imageCont w-24 h-24 rounded-full overflow-hidden shadow-sm border flex flex-col items-center justify-center">
                <img src={{asset('/assets/'.$data['image'])}} alt="image" class="object-cover w-full h-full">
            </div>
            <p class="text-center mt-2 text-sm">{{ucfirst($data['name'])}}</p>
        </div>
    </a>
    @endforeach
</div>
