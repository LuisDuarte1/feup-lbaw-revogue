@extends('layouts.app')

@section('content')

<section class="layout-wrap">
    <div class="shopping-cart column gap-1 justify-center">
        <div class="cart-header line">
            <div class="cart-title">
                <h1 class="title">Shopping Cart</h1>
            </div>
        </div>
        <div class="product-categories">
            <p>Product details</p>
        </div>
        <div class="products column gap-1">
            @foreach ($cart as $product)
                @php
                    $image = $product['product']->image_paths[0];
                    $title = $product['product']->name;
                    $id = $product['product']->id;
                    $color = $product['color'];
                    $size = $product['size'];
                    $price = $product['product']->price;

                @endphp
                <article class="product line" data-id="{{$id}}">
                    <div class="layout-divider image-details-group">
                        <div class="product-image">
                            <img src="{{$image}}" alt="product">
                        </div>
                        <div class="product-details">
                            <h3>{{$title}}</h3>
                            <p>Color: <span>{{$color}}</span></p>
                            <p>Size: <span>{{$size}}</span></p>
                        </div>
                    </div>
                    <div class="layout-divider price-trash-group">
                        <div class="product-price">
                            <p>{{$price}}</p>
                        </div>
                        <div class="product-remove">
                            <a href="#"><ion-icon name="trash"></ion-icon></a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
    <div class="order-summary column gap-2">
        <div class="order-title line">
            <h1 class="title">Order Summary</h1>
        </div>
        <div class="order-categories">
            <p>{{count($cart)}} items</p>
            <p>{{$sum}}€</p>
        </div>
        <div class="shipping column justify-center gap-1">
            <h3>Shipping: </h3>
            <div class="shipping-price">
                <p>Standard Delivery - Free</p>
            </div>
        </div>
        <form action="">
            <div class="promo column justify-center gap-1">
                    <h3><label for="promo-code">
                        Promo code:
                    </label></h3>
                    <div class="apply-button">
                    <input type="text" id="promo-code" name="promo-code">
                        <button>Apply</button>
                    </div>
            </div>
        </form>
        <span class="line"></span>
        <div class="total">
            <h3>Total: </h3>
            <div class="total-price">
                <p>423€</p>
            </div>
        </div>
        <div class="checkout-button column">
            <a href="{{ route('checkout') }}" class="column"><button>Checkout</button></a>
        </div>
    </div>
</section>


@endsection
