<nav class = "profile-navbar">
    <ul class = "profile-navbar-items">
        <li class= "profile-navbar-item"><a @if ($tab === 'selling') class="active" @endif
                href="/profile/{{ $id }}/">Selling</a></li>
        <li class= "profile-navbar-item"><a @if ($tab === 'sold') class="active" @endif
                href="/profile/{{ $id }}/sold">Sold</a></li>
        <li class= "profile-navbar-item"><a @if ($tab === 'likes') class="active" @endif
                href="/profile/{{ $id }}/likes">Likes</a></li>
        @if ($ownPage)
            <li class= "profile-navbar-item"><a @if ($tab === 'history') class="active" @endif
                    href="/profile/{{ $id }}/history">Purchase History</a></li>
        @endif
    </ul>
</nav>
