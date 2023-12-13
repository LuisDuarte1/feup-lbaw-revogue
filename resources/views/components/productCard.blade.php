<a href="/products/{{$id}}">
    <div class="product-card">
        <div class="product-image-card">
            <!--TODO (luisd): do the random hash if only on debug mode -->
            <img src="{{ $image }}?hash={{fake()->lexify('???????????????')}}" loading="lazy" decoding="async" alt="product image">
        </div>
        <div class="product-description-card column">
            <div class="product-description-top">
                <div class="product-price">
                    <p>{{ $price }}</p>
                </div>
                <div class="product-size">
                    <p>{{ $size }}</p>
                </div>
            </div>
            <div class="product-description-bottom">
                <div class="product-shipping">
                    <div class="product-shipping-text @if($shipping === 'Free') free-shipping @endif">
                        <p>{{ $shipping }}</p>
                    </div>
                    <div class="product-shipping-icon">
                        <ion-icon name="airplane"></ion-icon>
                    </div>
                </div>
                <div class="product-condition">
                    <p>{{ $condition }}</p>
                </div>
            </div>
        </div>
    </div>
</a>