@extends('layouts.app')

@section('content')
    <div class="login-wrapper">
        <div class="login-page">
            <h1 class="title">Recover password</h1>
            <div>
                <form class="login-box" method="POST" action="{{ route('recover-password') }}">
                    {{ csrf_field() }}

                    <label for="email">E-mail</label>

                    <input class="search" placeholder="Write your email" id="email" type="email" name="email"
                        value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <span class="error">
                            {{ $errors->first('email') }}
                        </span>
                    @endif

                    <button type="submit">
                        Recover Password
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
