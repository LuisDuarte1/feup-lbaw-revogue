<nav class="settings-navbar">
    <ul class="settings-navbar-items">
        <li class="settings-navbar-item"><a @if ($tab === 'general') class="active" @endif
                href="/settings/general">General</a></li>
        <li class="settings-navbar-item"><a @if ($tab === 'profile') class="active" @endif
                href="/settings/profile">Profile</a></li>
        <li class="settings-navbar-item"><a @if ($tab === 'payment') class="active" @endif
                href="/settings/payment">Payment</a></li>
        <li class="settings-navbar-item"><a @if ($tab === 'shipping') class="active" @endif
                href="/settings/shipping">Shipping</a></li>
    </ul>
</nav>
