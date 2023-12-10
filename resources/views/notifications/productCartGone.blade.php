<div class="notification" actionUrl="/products/{{$product->id}}">
    <!--TODO(luisd): add action URL to redirect to product -->
    @php
        $firstImage = $product->image_paths[0];    
    @endphp
    <div class="notification-image" style="background-image: url('{{$firstImage}}')">
    </div>
    <div class="notification-card-content">
        <p>It seems like someone brought '<b>{{$product->name}}</b>' before you did. It was automatically removed from your cart.</p>
        <p class="notification-date">{{$notification->creation_date->diffForHumans()}}</p>
    </div>
    @if (!$notification->read)
        <div class="notification-read">
        </div>
    @endif
</div>
