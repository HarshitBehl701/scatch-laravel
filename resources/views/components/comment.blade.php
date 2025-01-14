<div class="commentLayout border-b border-gray-200 py-4  px-3 flex  items-center  gap-4">

    <div class="leftsection  w-20 h-20  rounded-full  shadow-sm overflow-hidden border">
        <img alt="picture" src="{{Storage::url($commentData['picture']) ?? "https://placehold.co/400"}}" class="object-cover   object-top w-full h-full"/>
    </div>

    <div class="rightSection">
        <h4  class="text-sm  font-semibold">{{$commentData['name']}}</h4>
        <h5   class="text-xs  text-gray-500">{{$commentData['dateOfComment']}}</h5>
        <p>{{$commentData['comment']}}</p>
    </div>

</div>