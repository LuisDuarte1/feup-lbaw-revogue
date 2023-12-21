<nav class="navbar">
    <div class="sidebar">
        <div class="logo-section row justify-between items-center">
            <a href="/" class="logo title">
                <h1> ReVogue </h1>
            </a>
            <a class="close-menu-mobile" href="#"><ion-icon name="close"></ion-ion></a>
        </div>
        <ul class="menu">
            @auth
            <li>
                <a href="/profile/me" class="menu-item">
                    <ion-icon name="person-circle" aria-label="profile-icon"></ion-icon>
                    Profile
                </a>
            </li>
            @endauth
            <li>
                <a href="/" class="menu-item">
                    <ion-icon name="home" aria-label="home-icon"></ion-icon>
                    Home
                </a>
            </li>
            @auth
            <li>
                <a href="/products" class="menu-item">
                    <ion-icon name="bag-handle-sharp" aria-label="listings-icon"></ion-icon>
                    Listings
                </a>
            </li>
            <li>
                <a href="/messages" class="menu-item">
                    <ion-icon name="chatbubble-ellipses-sharp" aria-label="messages-icon"></ion-icon>
                    Messages
                </a>
            </li>
            <li>
                <a href="/settings/general" class="menu-item">
                    <ion-icon name="settings" aria-label="settings-icon"></ion-icon>
                    Settings
                </a>
            </li>
            @endauth
            <li>
                <a href="/faqs" class="menu-item">
                    <ion-icon name="help-circle" aria-label="faqs-icon"></ion-icon>
                    FAQs
                </a>
            </li>
            <li>
                <a href="/aboutUs" class="menu-item">
                    <ion-icon name="planet" aria-label="about-us-icon"></ion-icon>
                    About Us
                </a>
            </li>
        </ul>
    </div>
    @auth
    <a href="/logout" class="menu-item logout">
        <ion-icon name="log-out" aria-label="log-out-icon"></ion-icon>
        Logout
    </a>
    @endauth
    @guest
    <div>
        <a href="/login" class="menu-item sign-in">
            <ion-icon name="log-in" aria-label="log-in-icon"></ion-icon>
            Login
        </a>
        <a href="/register" class="menu-item sign-up">
            <ion-icon name="person-add" aria-label="register-icon"></ion-icon>
            Register
        </a>
    </div>
    @endguest
</nav>