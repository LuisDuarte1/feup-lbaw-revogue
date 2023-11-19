@extends('layouts.app')

@section('content')
<div class="page-center">
    <div class="email-confirmation-page">
        <h1 class="title">Confirm your email</h1>
        <p>In order to use ReVougue, we need to confirm that your email is really yours. Please check your email and once you click on the confirmation link your account will be activated.</p> 
        <div>
            <p>An email was sent to:</p>
            <p class="email-box">{{ $email }}</p>
        </div>
        @if (session('status'))
        <!--TODO (luisd): add CSS to make a green box with a checkmark to better indicate that the email has been sent -->
            <div>
                <p> {{session('status')}}</p>
            </div>
        @endif
        <form method="POST" action="{{ route('verification.notice') }}">
            <p style="text-align: center">Didn't receive the email?</p>
            @csrf
            <button type="submit">Resend confirmation email</button>
        </form>
    </div>
</div> 

@endsection