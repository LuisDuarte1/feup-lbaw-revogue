@extends('layouts.app', ['search_bar' => true])


@section('content')
<section class="column justify-center gap-3">
    <div class="layout-wrapper">
        <div class="product-image">
            <img src="https://picsum.photos/1020/720" alt="product image">
        </div>
        <div class="product-details">
            <div class="product-title">
                <h1 class="title">{{$product->name}}</h1>
            </div>
            <div class="product-price-shipping">
                <div class="product-price">
                    <h3> {{$product->price}}€</h3>
                </div>
                <div class="product-shipping">
                    <h3>Shipping: 2€</h3>
                </div>
            </div>
            <div class="product-info">
                <p>@foreach ($attributes as $attribute)
                    {{$attribute->key}} - {{$attribute->value}} 
                    <span class="separator">•</span>
                    @endforeach
                    <!-- temporary -->
                    Category - Shoes
                    <span class="separator">•</span>
                    Color - Black
                </p>
            </div>
            <div class="product-description">
                <p>{{$product->description}}</p>
            </div>
            <div class="product-buttons">
                <button class="buy-now">Buy now</button>
                <button class="add-to-cart">Add to cart</button>
            </div>
        </div>
    </div>
    <div class="layout-wrapper">
        <div class="reviews w-full"> <!-- TODO --> </div>
        <div class="seller column gap-2">
            <div class="seller-wrapper">
                <div class="profile-pic"> 
                    <!-- TODO, temporary --> 
                    <div class="square"></div>
                </div>

                <div class="seller-info">
                    <div class="seller-name">
                        <h3>Anne Hathaway</h3>
                    </div>
                    <div class="seller-rating">
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star-half-outline"></ion-icon>
                        <ion-icon name="star-outline"></ion-icon>
                    </div>
                    <div class="seller-buttons">
                        <button class="ask-question">Ask a question</button>
                        <button class="visit-shop">Visit shop</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection