<div class="notification" actionUrl="/products/{{$product->id}}">
    <!--TODO(luisd): add action URL to redirect to product -->
    @php
        $firstImage = $product->image_paths[0];    
    @endphp
    <div class="notification-image" style="background-image: url('{{$firstImage}}')">
    </div>
    <div class="notification-card-content">
        <p>Someone also liked '<b>{{$product->name}}</b>' and bought it it. It was automatically removed from your wishlist.</p>
        <p class="notification-date">{{$notification->creation_date->diffForHumans()}}</p>
    </div>
    @if (!$notification->read)
        <div class="notification-read">
        </div>
    @endif
</div>
