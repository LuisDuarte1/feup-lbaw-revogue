<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Icons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>

    @vite(['resources/css/admin.scss', 'resources/ts/admin.ts'])

</head>

<body>
    <header class="navbar">
        <div class="separator">
            <div class="logo">
                <h1>ReVogue</h1>
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="/admin" class="home">Home</a></li>
                    <li><a href="/admin/users">Users</a></li>
                    <li><a href="/admin/orders">Orders</a></li>
                    <li><a href="/admin/payouts">Payouts</a></li>
                </ul>
            </nav>
        </div>
        <div class="profile-pic">
            <img src="../defaultProfileImage.png" class="profile-pic">
        </div>
    </header>
    <div class="main-content">@yield('content')</div>
</body>

</html>