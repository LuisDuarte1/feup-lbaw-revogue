<div class="notification" actionUrl="/">
    <!--TODO(luisd): add action URL to redirect to order message -->
    @php
        $firstImage = $product->image_paths[0];    
    @endphp
    <div class="notification-image">
        <img src="{{$firstImage}}">

    </div>
    <div class="notification-card-content">
        <p>Hurray! Seems like your product '<b>{{$product->name}}</b>' was brought by <a href="/profile/{{$broughtBy->id}}">{{$broughtBy->display_name}}</a> for <b>{{$price}}€</b>.</p>
        <p class="notification-date">{{$notification->creation_date->diffForHumans()}}</p>
    </div>
    @if (!$notification->read)
        <div class="notification-read">
        </div>
    @endif
</div>
