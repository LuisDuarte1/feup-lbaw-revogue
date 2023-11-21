@extends('layouts.app')

@section('content')

<section class="layout-wrapper">
    <div class="shopping-cart column gap-1 justify-center">
        <div class="cart-header">
            <div class="cart-title">
                <h1 class="title">Shopping Cart</h1>
            </div>
        </div>
        <div class="product-categories">
            <p>Product details</p>
        </div>
        <div class="products column gap-1">
            <article class="product">
                <div class="product-image">
                    <img src="../test_image.png" alt="product">
                </div>
                <div class="product-details">
                    <h3>Product name</h3>
                    <p>Color: <span>Red</span></p>
                    <p>Size: <span>XL</span></p>
                </div>
                <div class="product-price">
                    <p>23€</p>
                </div>
                <div class="product-remove">
                    <ion-icon name="trash"></ion-icon>
                </div>
            </article>
            <article class="product">
                <div class="product-image">
                    <img src="../test_image.png" alt="product">
                </div>
                <div class="product-details">
                    <h3>Product name</h3>
                    <p>Color: <span>Red</span></p>
                    <p>Size: <span>XL</span></p>
                </div>
                <div class="product-price">
                    <p>23€</p>
                </div>
                <div class="product-remove">
                    <ion-icon name="trash"></ion-icon>
                </div>
            </article>
            <article class="product">
                <div class="product-image">
                    <img src="../test_image.png" alt="product">
                </div>
                <div class="product-details">
                    <h3>Product name</h3>
                    <p>Color: <span>Red</span></p>
                    <p>Size: <span>XL</span></p>
                </div>
                <div class="product-price">
                    <p>23€</p>
                </div>
                <div class="product-remove">
                    <ion-icon name="trash"></ion-icon>
                </div>
            </article>
        </div>
    </div>
    <div class="order-summary column gap-2 justify">
        <form action="">
            <div class="order-title">
                <h1 class="title">Order Summary</h1>
            </div>
            <div class="order-categories">
                <p>X items</p>
                <p>423€</p>
            </div>
            <div class="shipping column justify-center gap-1">
                <h3>Shipping: </h3>
                <div class="shipping-price">
                    <p>Free</p>
                </div>
            </div>
            <div class="promo column justify-center gap-1">
                <h3>Promo code: </h3>
                <div class="promo-place">
                    <input type="text" placeholder="Enter your code">
                    <button>Apply</button>
                </div>
            </div>
            <span class="line"></span>
            <div class="total">
                <h3>Total: </h3>
                <div class="total-price">
                    <p>423€</p>
                </div>
            </div>
        </form>
    </div>
</section>


@endsection
