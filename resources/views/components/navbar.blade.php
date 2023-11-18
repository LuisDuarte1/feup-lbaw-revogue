<nav class="navbar">
    <div class="sidebar">
        <div class="logo">
            <a href="#">
                <h1> ReVogue </h1>
            </a>
        </div>
        <ul class="menu">
            @auth
            <li>
                <a href="#" class="menu-item">
                    <ion-icon name="person-circle"></ion-icon>
                        Profile
                </a>
            </li>
            <li>
                <a href="#" class="menu-item">
                        <ion-icon name="home"></ion-icon>
                        Home
                </a>
            </li>
            <li>
                <a href="#" class="menu-item">
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
                <a href="#" class="menu-item">
                        <ion-icon name="settings"></ion-icon>
                        Settings
                </a>
            </li>
            <li>
                <a href="#" class="menu-item">
                        <ion-icon name="help-circle"></ion-icon>
                        FAQs
                </a>
            </li>
            
            @endauth
            @guest
            <li>
                <a href="#" class="menu-item">
                        <ion-icon name="home"></ion-icon>
                        Home
                </a>
            </li>
            <li>
                <a href="#" class="menu-item">
                        <ion-icon name="help-circle"></ion-icon>
                        FAQs
                </a>
            </li>            
            @endguest
        </ul>
    </div>
    @auth
    <a href="#" class="menu-item logout">
        <ion-icon name="log-out"></ion-icon>
        Logout
    </a>
    @endauth
    @guest
    <div>
        <a href="#" class="menu-item sign-in">
            <ion-icon name="log-in"></ion-icon>
            Login
        </a>
        <a href="#" class="menu-item sign-up">
            <ion-icon name="person-add"></ion-icon>
            Register
        </a>
    </div>
    @endguest
</nav>