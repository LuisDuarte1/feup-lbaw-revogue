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
            <article class="product line">
                <div class="layout-divider">
                    <div class="product-image">
                        <img src="../test_image.png" alt="product">
                    </div>
                    <div class="product-details">
                        <h3>Product name</h3>
                        <p>Color: <span>Red</span></p>
                        <p>Size: <span>XL</span></p>
                    </div>
                </div>
                <div class="layout-divider">
                    <div class="product-price">
                        <p>23€</p>
                    </div>
                    <div class="product-remove">
                        <ion-icon name="trash"></ion-icon>
                    </div>
                </div>
            </article>
            <article class="product line">
                <div class="layout-divider">
                    <div class="product-image">
                        <img src="../test_image.png" alt="product">
                    </div>
                    <div class="product-details">
                        <h3>Product name</h3>
                        <p>Color: <span>Red</span></p>
                        <p>Size: <span>XL</span></p>
                    </div>
                </div>
                <div class="layout-divider">
                    <div class="product-price">
                        <p>23€</p>
                    </div>
                    <div class="product-remove">
                        <ion-icon name="trash"></ion-icon>
                    </div>
                </div>
            </article>
            <article class="product line">
                <div class="layout-divider">
                    <div class="product-image">
                        <img src="../test_image.png" alt="product">
                    </div>
                    <div class="product-details">
                        <h3>Product name</h3>
                        <p>Color: <span>Red</span></p>
                        <p>Size: <span>XL</span></p>
                    </div>
                </div>
                <div class="layout-divider">
                    <div class="product-price">
                        <p>23€</p>
                    </div>
                    <div class="product-remove">
                        <ion-icon name="trash"></ion-icon>
                    </div>
                </div>
            </article>
        </div>
    </div>
    <div class="order-summary column gap-2">
        <div class="order-title line">
            <h1 class="title">Order Summary</h1>
        </div>
        <div class="order-categories">
            <p>3 items</p>
            <p>423€</p>
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
            <button>Checkout</button>
        </div>
    </div>
</section>


@endsection