@extends('layouts.admin')


@section('content')
<div class="admin-login-page page-center">
    <h1 class="title">Admin - Login</h1>
    <form action="{{route('admin-login')}}" method="POST" class="column login-wrapper">
        <div class="information-section column w-full gap-1">
            <div class="column w-full">
                <label for="email" required>Email</label>
                <input id="email" name="email" required type="text">
            </div>
            <div class = "column w-full">
                <label for="password" required>Password</label>
                <input id="password" name="password" required type="password">
            </div>
        </div>
        <button type="submit">Login</button>
    </form>
</div>
@endsection