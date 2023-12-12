<x-notification :route="'/product/'.$product->id" :notification="$notification">
        @php
            $firstImage = $product->image_paths[0];    
        @endphp
        <div class="notification-image" style="background-image: url('{{$firstImage}}')">
        </div>
        <div class="notification-card-content">
            <p>Someone also liked '<b>{{$product->name}}</b>' and bought it it. It was automatically removed from your wishlist.</p>
            <p class="notification-date">{{$notification->creation_date->diffForHumans()}}</p>
        </div>
</x-notification>
