@extends('layouts.app')

@section('content')

<section class="layout-wrap">
    <div class="shopping-cart column gap-2 justify-center">
        <div class="cart-header line">
            <h1 class="title">Shopping Cart</h1>
        </div>
        <div class="purchase-details row items-center">
            <p>Purchase details</p>
            <p># Orders</p>
        </div>
        <div class="cart-orders column gap-3">
            <div class="seller-products column gap-2">
                <div class="seller-products-header row items-center">
                    <div class="row wrapper items-center">
                        <img src="/defaultProfileImage.png" alt="seller" class="seller-image">
                        <div class="selller-name">
                            <div class="seller-display-name">Display name</div>
                            <div class="seller-username">@username</div>
                        </div>
                    </div>
                    <a href="#" class="cart-order-remove">
                        <button>Remove All</button>
                    </a>
                </div>
                <div class="cart-products column gap-1">
                    <article class="product column gap-1">
                        <a href="#" class="product-remove"><ion-icon name="close-outline"></ion-icon></a>
                        <div class="cart-product row gap-1 items-center">
                            <div class="product-image column items-center">
                                <a href="#">
                                    <img src="https://picsum.photos/1020/720">
                                </a>
                            </div>
                            <div class="cart-product-info row gap-1">
                                <a href="#" class="column wrapper">
                                    <div class="product-name">Product Name</div>
                                    <div class="product-size">Size: M</div>
                                    <div class="product-condition">Condition: Good</div>
                                </a>
                                <div class="product-price">Price: 20€</div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
    <div class="purchase-summary column gap-2">
        <div class="purchase-title line">
            <h1 class="title">Purchase Summary</h1>
        </div>
        <div class="purchase-details items-center row">
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
                <p>{{$sum}}€</p>
            </div>
        </div>
        <div class="checkout-button column">
            <a href="{{ route('checkout') }}" class="column"><button>Checkout</button></a>
        </div>
    </div>
</section>


@endsection