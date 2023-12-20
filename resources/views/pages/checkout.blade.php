@extends('layouts.app')

@section('content')
    @php
        $amount = 0;
        foreach ($cart as $product) {
            $amount += $product->price;
        }
    @endphp
    <section class="checkout-page">
        <form class="checkout-form" action="{{ route('checkout') }}" method="POST">
            @csrf
            <div class="checkout-wrapper column justify-center gap-2">
                <header class="checkout-header">
                    <h1 class="title">Checkout</h1>
                </header>
                <div class="shipping-details column gap-2">
                    <div class="shipping-title">
                        <h2 class="">Billing Details</h2>
                    </div>

                    <div class="shipping-full-name">
                        <label for="full-name" required>Full name</label>
                        <input type="text" name="full_name" id="full-name" required>
                    </div>
                    <div class="shipping-email">
                        <label for="email" required>Email</label>
                        <input type="text" name="email" id="email" required>
                    </div>
                    <div class="shipping-address">
                        <label for="address" required>Address line</label>
                        <input type="text" name="address" id="address" required>
                    </div>
                    <div class="shipping-country">
                        <label for="country" required>Country</label>
                        <select id="country" name="country">
                            @foreach ($countries as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="shipping-zip">
                        <label for="zip-code" required>Zip or postal code</label>
                        <input type="text" name="zip_code" id="zip-code" required>
                    </div>
                    <div class="shipping-phone">
                        <label for="phone">Phone number</label>
                        <input type="text" name="phone" id="phone">
                    </div>
                </div>
                <div class="payment-methods column gap-1">
                    <div class="payment-methods-title">
                        <h2 class="">Payment Methods</h2>
                    </div>
                    <div class="payment-item">
                        <label for="pay-on-collection">Pay at delivery</label>
                        <input type="radio" name="payment_method" id="pay-on-collection" value=0>
                    </div>
                    <div class="payment-item">
                        <label for="payment-stripe">Card or other payment methods</label>
                        <input type="radio" name="payment_method" id="payment-stripe" value=1 checked>
                    </div>
                </div>
                <div id="stripe-payment-method" amount="{{ $amount }}"></div>
                <div class="submit-button">
                    <button type="submit">Place Order</button>
                </div>
            </div>
        </form>
    </section>
@endsection
