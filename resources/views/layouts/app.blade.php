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

    <!-- Scripts -->
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    

    @if (session('modal-error'))
        <meta name="modal-error" confirm-button="{{session('modal-error')['confirm-button']}}" title="{{session('modal-error')['title']}}" content="{{session('modal-error')['content']}}">
    @endif

    @if (isset($errors) && get_class($errors) == 'Illuminate\Support\ViewErrorBag' && $errors->count() > 0)
        @php
            $errorArray = $errors->getBag('default')->all();    
        @endphp
        <meta name="toast-error" content="{{json_encode($errorArray)}}">
    @elseif (isset($errors) && get_class($errors) == 'Illuminate\Support\Collection' && $errors->count() > 0)
        @php
            $errorArray = $errors->values()->toArray();
        @endphp
        <meta name="toast-error" content="{{json_encode($errorArray)}}">
    @endif

    @if (session()->has('success'))
        @php
            $errorMessage = session('success');
        @endphp
        <meta name="toast-success", content="{{json_encode($errorMessage)}}">
    @endif

    @vite(['resources/css/app.scss', 'resources/ts/app.ts'])

</head>

<body>

    @if(isset($search_bar) == true && $search_bar == true)
    <x-searchBar />
    @endif
    <nav class="mobile-navbar">
        <a href="/" class="title">ReVogue</a>
        <a href="#" class="mobile-hamburger-menu"><ion-icon name="menu-outline"></ion-icon></a>
    </nav>
    <x-navbar />
    <div class="main-content {{isset($needs_full_height) && $needs_full_height == true ? 'full-page-height' : ''}}">@yield('content')</div>
</body>

</html>