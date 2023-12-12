<x-notification :route="'/products/'.$product->id" :notification="$notification">
        @php
            $firstImage = $product->image_paths[0];    
        @endphp
        <div class="notification-image" style="background-image: url('{{$firstImage}}')">
        </div>
        <div class="notification-card-content">
            <p>It seems like someone bought '<b>{{$product->name}}</b>' before you did. It was automatically removed from your cart.</p>
            <p class="notification-date">{{$notification->creation_date->diffForHumans()}}</p>
        </div>
</x-notification>