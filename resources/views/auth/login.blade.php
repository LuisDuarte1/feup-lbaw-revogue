@extends('layouts.app')

@section('content')
<div class="login-wrapper">
    <div class="login-page">
        <h1 class="title">Login</h1>
        <div>
            <form class="login-box" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <label for="email" required>E-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

                <label for="password" required>Password</label>
                <input id="password" type="password" name="password" required>

                <label class="login-remember">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                </label>

                <button type="submit">
                    Login
                </button>
                @if (session('success'))
                <p class="success">
                    {{ session('success') }}
                </p>
                @endif
            </form>
            <div class="goto-register">
                <a href="{{ route('register') }}">Don't have an account? Register now</a>
            </div>
        </div>
    </div>
</div>
@endsection