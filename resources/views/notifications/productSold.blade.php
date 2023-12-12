<x-notification :route="'/product/'.$product->id" :notification="$notification">

        @php
            $firstImage = $product->image_paths[0];    
        @endphp
        <div class="notification-image" style="background-image: url('{{$firstImage}}')"></div>
        <div class="notification-card-content">
            <p>Hurray! Seems like your product '<b>{{$product->name}}</b>' was bought by <a href="/profile/{{$broughtBy->id}}">{{$broughtBy->display_name}}</a> for <b>{{$price}}€</b>.</p>
            <p class="notification-date">{{$notification->creation_date->diffForHumans()}}</p>
        </div>
</x-notification>