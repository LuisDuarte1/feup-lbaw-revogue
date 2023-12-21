@php
$cartCount = 0;
if (Auth::check()) {
$cartCount = Auth::user()
->cart()
->count();
}
@endphp

<nav class="topnav">
    <form method="GET" action="/search">
        <ion-icon id="search_icon" name="search" aria-label="search-icon"></ion-icon>
        <input id="search" class="search" type="text" placeholder="Search" name="q">
    </form>
    <div>
        @auth
        <div id="notifications-icon">
            @php
            $unreadNotificationCount = Auth::user()
            ->notifications()
            ->where('read', 'false')
            ->where('dismissed', '<>', 'true')
                ->count();
                $hasNotifications = $unreadNotificationCount !== 0;
                @endphp
                <a href="#" aria-label="notifications-dropdown">
                    @if ($hasNotifications === true)
                    <ion-icon name="notifications"></ion-icon>
                    <span class="notification-ball"></span>
                    @else
                    <ion-icon name="notifications-outline" aria-label="notifications-icon"></ion-icon>
                    @endif
                </a>
                <div class="notification-wrapper">
                    <div class="row justify-between notification-wrapper-title">
                        <h3>Notifications</h3>
                        <a href="{{ route('notifications') }}">See all</a>
                    </div>
                    <div class="notification-content">

                    </div>
                </div>
        </div>
        @endauth
        @guest
        <a href="{{ route('notifications') }}">
            <ion-icon name="notifications-outline" aria-label="notifications-icon"></ion-icon>
        </a>
        @endguest
        <a href="/products/new" aria-label="new-product-button">
            <ion-icon name="add" aria-label="add-icon"></ion-icon>
        </a>
        <a href="/profile/me/likes" aria-label="likes-button">
            <ion-icon name="heart-outline" aria-label="like-button"></ion-icon>
        </a>

        <a href="{{ route('cart') }}" aria-label="cart-button">
            <ion-icon name="cart" aria-label="cart-icon"></ion-icon>
            @auth
            <span class="cart-badge" style="font-size:24px" value="{{ $cartCount }}"></span>
            @endauth
        </a>
    </div>
</nav>