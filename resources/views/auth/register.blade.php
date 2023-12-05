@extends('layouts.app')

@section('content')
    <div class="register-wrapper">
        <div class="register-page">
            <h1 class="title">Register</h1>
            <div class="register-content">
                <form method="POST" class="register-box" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <label for="name" required>Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                    @if ($errors->has('name'))
                        <span class="error">
                            {{ $errors->first('name') }}
                        </span>
                    @endif

                    <label for="username" required>Username</label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
                    @if ($errors->has('username'))
                        <span class="error">
                            {{ $errors->first('username') }}
                        </span>
                    @endif

                    <label for="email" required>E-mail</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <span class="error">
                            {{ $errors->first('email') }}
                        </span>
                    @endif

                    <label for="company_name" required>Company</label>
                    <input id="company_name" type="text" name="company_name" value="{{ old('company_name') }}" required
                        autofocus>
                    @if ($errors->has('company_name'))
                        <span class="error">
                            {{ $errors->first('company_name') }}
                        </span>
                    @endif

                    <label for="company_address" required>Address</label>
                    <input id="company_address" type="text" name="company_address" value="{{ old('company_address') }}"
                        required autofocus>
                    @if ($errors->has('company_address'))
                        <span class="error">
                            {{ $errors->first('company_address') }}
                        </span>
                    @endif


                    <label for="password" required>Password</label>
                    <input id="password" type="password" name="password" required>
                    @if ($errors->has('password'))
                        <span class="error">
                            {{ $errors->first('password') }}
                        </span>
                    @endif

                    <label for="password-confirm" required>Confirm Password</label>
                    <input id="password-confirm" type="password" name="password_confirmation" required>

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
