@extends('layouts.admin')


@section('content')
    <div class="admin-login-page">
        <h1 class="title">Login Admin</h1>
        <form action="{{route('admin-login')}}" method="POST">
            <div class="information-section">
                <label for="email" required>Email</label>
                <input id="email" name="email" required type="text">
                <label for="password" required>Password</label>
                <input id="password" name="password" required type="text">
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
@endsection