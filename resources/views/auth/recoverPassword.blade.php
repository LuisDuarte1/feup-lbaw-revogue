@extends('layouts.app')

@section('content')
@auth
<form method="POST" action="{{ route('recover-password') }}">
    {{ csrf_field() }}

    <label for="email">E-mail</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif

    <button type="submit">
        Recover Password
    </button>
</form>
@endauth
@endsection