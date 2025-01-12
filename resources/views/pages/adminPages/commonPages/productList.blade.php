@extends('layouts.admin')

@php
    $productList = reset($pageData);
    @endphp

@section('adminContent')

<div class="container mx-auto flex  flex-col gap-3">
    @if (is_array($productList) && count($productList)  > 0)
    @foreach ($productList as $product)
    <a href="/seller/product-details/{{urlencode($product['name'])}}/{{$product['id']}}">
        <x-product-list  :name="$product['name']" :description="$product['description']"  :price="$product['price']"  :images="$product['images']" />
    </a>
    @endforeach
    @else
        <p class="italic font-light text-sm text-gray-500">No Products...</p>
    @endif
</div>

@endsection