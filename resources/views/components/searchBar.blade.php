
<nav class= "topnav">
    <form method="GET" action="/search">
        <ion-icon id="search_icon" name="search"></ion-icon>
        <input id="search" class="search" type="text" placeholder="Search" name="q">
    </form>
    <div>
    <a href="/profile/me/likes">
        <ion-icon name="heart-outline"></ion-icon>
    </a>
    
    <a href="{{route('cart')}}">
        <ion-icon name="cart"></ion-icon>
    </a>
    </div>
</nav>