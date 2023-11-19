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