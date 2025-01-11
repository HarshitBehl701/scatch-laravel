@extends('layouts.main')

@section('content')

{{-- Home Header --}}
<x-home-header />

<br />
<br />
{{-- Categories  Section --}}
<x-home-categories />

{{-- Products Section --}}
<x-display-products />

@endsection