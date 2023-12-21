@extends('layouts.app')

@section('content')
    <div class="login-wrapper">
        <div class="login-page">
            <h1 class="title">Reset password</h1>
            <div>
                <form class="login-box" method="POST" action="{{ route('password.update') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <label for="email">E-mail</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>


                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>



                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>


                    <input type="hidden" name="token" value="{{ $token }}">
                    <button type="submit">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    @endsection
