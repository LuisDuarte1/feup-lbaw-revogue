@extends('layouts.app')

@section('content')
    @php
        $sum = 0;
        $numOrders = count($cart);
        $numProducts = 0;
    @endphp
    <section class="layout-wrap">
        <div class="shopping-cart column gap-2 justify-center">
            <div class="cart-header line">
                <h1 class="title">Shopping Cart</h1>
            </div>
            <div class="purchase-details row items-center">
                <p>Purchase details</p>
                <p class="number-of-orders">{{ $numOrders }} Orders</p>
            </div>
            <div class="cart-orders column gap-3">
                @foreach ($cart as $id => $products)
                    @php
                        $numProducts += count($products);
                        $seller = App\Models\User::where('id', $id)
                            ->get()
                            ->first();
                        $sellerPicture = $seller->profile_image_path !== null ? '/storage/' . $user->profile_image_path : '/defaultProfileImage.png';
                    @endphp
                    <div class="seller-products column gap-2" data-seller-id="{{ $seller->id }}">
                        <div class="seller-products-header row items-center">
                            <div class="row wrapper items-center">
                                <img src="{{ $sellerPicture }}" alt="seller" class="seller-image">
                                <div class="selller-name">
                                    <a href="/profile/{{ $seller->id }}" class="profile-link">
                                        <div class="seller-display-name">{{ $seller->display_name }}</div>
                                        <div class="seller-username">{{ '@' . $seller->username }}</div>
                                    </a>
                                </div>
                            </div>
                            <a href="#" class="cart-order-remove">
                                <button class="remove-all-button" data-seller-id="{{ $seller->id }}">Remove All</button>
                            </a>
                        </div>
                        <div class="cart-products
                                    column gap-1">
                            @foreach ($products as $product)
                                @php
                                    $sum += $product->price;
                                    $productPicture = $product->image_paths[0];
                                    $price = $product->price;
                                    $size = $product
                                        ->attributes()
                                        ->where('key', 'Size')
                                        ->get()
                                        ->first()->value;
                                    $condition = $product
                                        ->attributes()
                                        ->where('key', 'Condition')
                                        ->get()
                                        ->first()->value;

                                @endphp
                                <article class="product column gap-1" data-id="{{ $product->id }}" data-price="{{ $price }}">
                                    <a href="#" class="product-remove"><ion-icon name="close-outline"></ion-icon></a>
                                    <div class="cart-product row gap-1 items-center">
                                        <div class="product-image column items-center">
                                            <a href="/products/{{ $product->id }}">
                                                <img src="{{ $productPicture }}">
                                            </a>
                                        </div>
                                        <div class="cart-product-info row gap-1">
                                            <a href="/products/{{ $product->id }}" class="column wrapper">
                                                <div class="product-name">{{ $product->name }}</div>
                                                <div class="product-size">Size: {{ $size }}</div>
                                                <div class="product-condition">Condition:'{{ $condition }}'</div>
                                            </a>
                                            <div class="product-price">Price: {{ $price }}€</div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="purchase-summary column gap-2">
            <div class="purchase-title line">
                <h1 class="title">Purchase Summary</h1>
            </div>
            <div class="purchase-details items-center row">
                <p class="number-of-products">{{ $numProducts }} items</p>
                <p class="price-sum">{{ $sum }}€</p>
            </div>
            <div class="shipping column justify-center gap-1">
                <h3>Shipping: </h3>
                <div class="shipping-price">
                    <p>Standard Delivery - Free</p>
                </div>
            </div>
            <div class="promo column justify-center gap-1">
                <h3><label for="promo-code">
                        Promo code:
                    </label></h3>
                <div class="apply-button">
                    <input type="text" id="promo-code" name="promo-code">
                    <button>Apply</button>
                </div>
            </div>
            <span class="line"></span>
            @foreach ($appliedVouchers as $voucher)
                @php
                    $difference = $voucher->getProduct->price - $voucher->bargainMessage->proposed_price;
                @endphp
                <div class="voucher row justify-between">
                    <p class="voucher-code">Voucher: <span>{{ $voucher->code }}</span><a href="#"
                            class="voucher-remove" data-voucher-code="{{ $voucher->code }}"><ion-icon
                                name="close-circle-outline"></ion-icon></a></p>
                    <p class="difference">-{{ $difference }}€</p>
                </div>
            @endforeach
            <div class="total">
                <h3>Total: </h3>
                <div class="total-price">
                    <p class="price-sum">{{ $cartPrice }}€</p>
                </div>
            </div>
            <div class="checkout-button column">
                <a href="{{ route('checkout') }}" class="column"><button>Checkout</button></a>
            </div>
        </div>
    </section>
@endsection
