@extends('layouts.app', ['search_bar' => true])




@section('content')

<div class="header-image">
    <img src="{{ asset('images/landing.jpg') }}" alt="landing image">
</div>
<div class="trending-section">
    <h1>Trending</h1>
    <div class="trend-carousel">
        @foreach ($products as $product)
            <div class="trend-card">
                <img src="{{ asset('images/'.$product->image) }}" alt="product image">
                <div class="trend-card-info">
                    <h3>{{ $product->name }}</h3>
                    <p>{{ $product->description }}</p>
                    <p>{{ $product->price }}</p>
                </div>
            

            <x-productCard :price="$price" :image="$image" :size="$size" :id="$id"/>
        @endforeach
    </div>
</div>


@endsection