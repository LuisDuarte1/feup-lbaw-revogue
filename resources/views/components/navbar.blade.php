<nav class="navbar">
    <div class="sidebar">
        <div class="logo title">
            <a href="/">
                <h1> ReVogue </h1>
            </a>
        </div>
        <ul class="menu">
            @auth
                <li>
                    <a href="/profile/me" class="menu-item">
                        <ion-icon name="person-circle"></ion-icon>
                        Profile
                    </a>
                </li>
            @endauth
            <li>
                <a href="/" class="menu-item">
                    <ion-icon name="home"></ion-icon>
                    Home
                </a>
            </li>
            @auth
                <li>
                    <a href="/products" class="menu-item">
                        <ion-icon name="bag-handle-sharp"></ion-icon>
                        Listings
                    </a>
                </li>
                <li>
                    <a href="#" class="menu-item">
                        <ion-icon name="chatbubble-ellipses-sharp"></ion-icon>
                        Messages
                    </a>
                </li>
                <li>
                    <a href="/settings/payment" class="menu-item">
                        <ion-icon name="settings"></ion-icon>
                        Settings
                    </a>
                </li>
            @endauth
            <li>
                <a href="#" class="menu-item">
                    <ion-icon name="help-circle"></ion-icon>
                    FAQs
                </a>
            </li>
        </ul>
    </div>
    @auth
        <a href="/logout" class="menu-item logout">
            <ion-icon name="log-out"></ion-icon>
            Logout
        </a>
    @endauth
    @guest
        <div>
            <a href="/login" class="menu-item sign-in">
                <ion-icon name="log-in"></ion-icon>
                Login
            </a>
            <a href="/register" class="menu-item sign-up">
                <ion-icon name="person-add"></ion-icon>
                Register
            </a>
        </div>
    @endguest
</nav>
