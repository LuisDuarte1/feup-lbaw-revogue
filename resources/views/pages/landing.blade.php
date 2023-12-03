@extends('layouts.app', ['search_bar' => true])




@section('content')
<div class="column gap-3 landing-page">
    <div class="header-image">
        <img src="/header.png" alt="landing image">
    </div>
    <div class="trending-section">
        <h2 style="text-align: left">Most Liked</h2>
        <div class="search-page">
            @foreach ($products as $product)
                @php
                    $price = $product['product']->price;
                    $image = $product['product']->image_paths[0];
                    $size = $product['size'];
                    $id = $product['product']->id;
                    $shipping = $product['product']->shipping;
                    $condition = $product['product']->condition;
                @endphp
                <x-productCard :price="$price" :image="$image" :size="$size" :id="$id" :shipping="$shipping" :condition="$condition"/>
            @endforeach
        </div>
    </div>
</div>


@endsection