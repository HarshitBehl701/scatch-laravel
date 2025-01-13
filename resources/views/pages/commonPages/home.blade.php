@extends('layouts.main')

@php
    $categoriesData = $pageData['categories'];
    $productData  = Arr::except($pageData,['categories']);
@endphp

@section('content')
{{-- Home Header --}}
<x-home-header />

<br />
<br />
{{-- Categories  Section --}}
<x-home-categories :categoriesData="['categoriesData' => $categoriesData]"/>

{{-- Products Section --}}
<x-display-products :productData="['productData' => $productData]" />

@endsection