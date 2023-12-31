@extends('layouts.app', ['search_bar' => 'true'])

@section('content')
    <div class="column gap-2 justify-center product-list">
        <x-filter-bar :filterAttributes="$filterAttributes"></x-filter-bar> 
        <div class="search-page" style="justify-content: center">
            @foreach ($products as $product)
                @php

                    $price = $product['product']->price;
                    $image = $product['product']->image_paths[0];
                    $size = $product['size'];
                    $id = $product['product']->id;
                    $shipping = $product['product']->shipping;
                    $condition = $product['condition'];
                @endphp
                <x-productCard :price="$price" :image="$image" :size="$size" :id="$id" :shipping="2"
                    :condition="$condition" />
            @endforeach
        </div>
        {{ $paginator->links('vendor.pagination.simple-default') }}
        <div>
        @endsection
