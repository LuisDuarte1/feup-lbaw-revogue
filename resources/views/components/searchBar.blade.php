<nav class= "topnav">
    <form method="GET" action="/search">
        <ion-icon id="search_icon" name="search"></ion-icon>
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
                <a href="#">
                    @if ($hasNotifications === true)
                        <ion-icon name="notifications"></ion-icon>
                        <span class="notification-ball"></span>
                    @else
                        <ion-icon name="notifications-outline"></ion-icon>
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
                <ion-icon name="notifications-outline"></ion-icon>
            </a>
        @endguest
        <x-filters>
            <ion-icon name="filter-outline"></ion-icon>
        </x-filters>

        <a href="/products/new">
            <ion-icon name="add"></ion-icon>
        </a>
        <a href="/profile/me/likes">
            <ion-icon name="heart-outline"></ion-icon>
        </a>

        <a href="{{ route('cart') }}">
            <ion-icon name="cart"></ion-icon>
        </a>
    </div>
</nav>
