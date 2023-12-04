@php
    $cartCount = 0;
    if (Auth::check()) {
        $cartCount = Auth::user()
            ->cart()
            ->count();
    }
@endphp

<nav class= "topnav">
    <form method="GET" action="/search">
        <ion-icon id="search_icon" name="search"></ion-icon>
        <input id="search" class="search" type="text" placeholder="Search" name="q">
    </form>
    <div>
        <a href="/products/new">
            <ion-icon name="add"></ion-icon>
        </a>
        <a href="/profile/me/likes">
            <ion-icon name="heart-outline"></ion-icon>
        </a>

        <a href="{{ route('cart') }}">
            <ion-icon name="cart"></ion-icon>
            <span class="cart-badge" style="font-size:24px" value={{ $cartCount }}></span>
        </a>
    </div>
</nav>
