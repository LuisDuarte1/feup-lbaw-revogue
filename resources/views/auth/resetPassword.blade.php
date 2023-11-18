@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('reset-password') }}">
    {{ csrf_field() }}

    <label for="email">E-mail</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif

    <label for="password" >Password</label>
    <input id="password" type="password" name="password" required>
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif


    <label for="password_confirmation" >Confirm Password</label>
    <input id="password_confirmation" type="password" name="password_confirmation" required>
    @if ($errors->has('password_confirmation'))
        <span class="error">
            {{ $errors->first('password_confirmation') }}
        </span>
    @endif

    <input type="hidden" name="token" value="{{ $token }}">
    <button type="submit">
        Reset Password
    </button>
    @endsection