@extends('layouts.app', ['search_bar' => 'true'])

@section('content')
    <x-filter-bar :filterAttributes="$filterAttributes"></x-filter-bar>
    <div class="search-page">
        @foreach ($products as $product)
            @php
                $price = $product['product']->price;
                $image = $product['product']->image_paths[0];
                $size = $product['size'];
                $id = $product['product']->id;
                $condition = $product['condition'];
            @endphp
            <x-productCard :price="$price" :image="$image" :size="$size" :id="$id" :condition="$condition"
                :shipping="2" />
        @endforeach
        <div id="page-end">
        </div>
    </div>
@endsection
