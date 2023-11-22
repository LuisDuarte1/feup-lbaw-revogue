@extends('layouts.app')

@section('content')

<section class="checkout-page">
    <form action="{{ route('checkout') }}" method="POST">
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
                    <input type="text" name="full_name" id="full-name">
                </div>
                <div class="shipping-email">
                    <label for="email" required>Email</label>
                    <input type="text" name="email" id="email">
                </div>
                <div class="shipping-address">
                    <label for="address" required>Address line</label>
                    <input type="text" name="address" id="address">
                </div>
                <div class="shipping-country">
                    <label for="country" required>Country</label>
                    <select id="country" name="country">
                        <option value=""></option>
                        <option value="portugal">Portugal</option>
                        <option value="finlandia">Finlândia</option>
                        <option value="espanha">Espanha</option>
                        <option value="alemanha">Alemanha</option>
                        <option value="holanda">Holanda</option>
                    </select>
                </div>
                <div class="shipping-zip">
                    <label for="zip-code" required>Zip or postal code</label>
                    <input type="text" name="zip_code" id="zip-code">
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
                <div class="pay-on-collection">
                    <label for="pay-on-collection">Pay at delivery</label>
                    <input type="radio" name="payment_method" id="pay-on-collection" value=0 checked>
                </div>
            </div>
            <div class="submit-button">
                <button class="">Place Order</button>
            </div>
        </div>
    </form>
</section>

@endsection
