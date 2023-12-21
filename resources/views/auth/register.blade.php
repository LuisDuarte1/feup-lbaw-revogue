@extends('layouts.app')

@section('content')
    <div class="register-wrapper">
        <div class="register-page">
            <h1 class="title">Register</h1>
            <div class="register-content">
                <form method="POST" class="register-box" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <div>
                        <label for="name" required>Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                    </div>
                    <label for="username" required>Username</label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
                    <div>
                        <label for="date_birth" required>Date of Birth</label>
                        <input id="date_birth" type="date" name="date_birth" value="{{ old('date_birth') }}" required
                            autofocus>
                    </div>
                    <div>
                        <label for="email" required>E-mail</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <span class="error">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>
                    <div>
                        <label for="password" required>Password</label>
                        <input id="password" type="password" name="password" required>
                    </div>
                    <div>
                        <label for="password-confirm" required>Confirm Password</label>
                        <input id="password-confirm" type="password" name="password_confirmation" required>

                    </div>
                    <button type="submit">
                        Register
                    </button>
                </form>
                <div class="goto-login">
                    <a href="{{ route('login') }}">Already have an account? Log in now</a>
                </div>
            </div>
        </div>
    </div>
@endsection
