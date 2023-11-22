@extends('layouts.app', ['search_bar' => true])




@section('content')

<div class="header-image">
    <img src="{{ asset('images/landing.jpg') }}" alt="landing image">
</div>
<div class="trending-section">
    <h1>Trending</h1>
    <div class="trend-carousel">
        @foreach ($products as $product)
            @php
                $price = $product['product']->price;
                $image = $product['product']->image_paths[0];
                $size = $product['size'];
                $id = $product['product']->id;
            @endphp
            
            @if ($request->user()->wishlist()->where('id', $product_id)->exists() === 1)
                @php $counter++; @endphp
            @endif

            <x-productCard :price="$price" :image="$image" :size="$size" :id="$id"/>
        @endforeach
    </div>
</div>


@endsection