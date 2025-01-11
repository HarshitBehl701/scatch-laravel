@extends('layouts.admin')

@section('adminContent')

<div class="container mx-auto flex  flex-col gap-3">
    <x-product-list />
    <x-product-list />
    <x-product-list />
</div>

@endsection