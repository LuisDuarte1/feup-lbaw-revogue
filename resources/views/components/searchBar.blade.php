
<nav class= "topnav">
    <form method="GET" action="/search">
        <ion-icon id="search_icon" name="search"></ion-icon>
        <input id="search" class="search" type="text" placeholder="Search" name="q">
    </form>
    <div>
    <a href="/products/new">
        <ion-icon name="add"></ion-icon>
    </a>
    @auth
    <a href="#" id="notifications-icon">
            @php
                $unreadNotificationCount = Auth::user()->notifications()->where('read', 'false')->count();
                $hasNotifications = $unreadNotificationCount !== 0;
            @endphp
            @if ($hasNotifications === true)
                <ion-icon name="notifications"></ion-icon>
                <span></span>

            @else 
                <ion-icon name="notifications-outline"></ion-icon>
            @endif
    </a>
    @endauth
    @guest
        <a href="{{route('notifications')}}">
            <ion-icon name="notifications-outline"></ion-icon>
        </a>
    @endguest
    <a href="/profile/me/likes">
        <ion-icon name="heart-outline"></ion-icon>
    </a>
    
    <a href="{{route('cart')}}">
        <ion-icon name="cart"></ion-icon>
    </a>
    </div>
</nav>