@extends('layouts.app')

@section('content')
<div class="page-center">
    <div class="complete-profile-page">
        <h1 class="title">Complete Profile</h1>
        <p>Thanks for verifying your email! You should now complete you registration by upload a photo and writing a bit about yourself so that other users can know a little about you.<br><br> If you don't feel like doing this you can do it later by accessing the settings page. Welcome to ReVougue!</p>
        <form class="complete-profile-form" action="{{ route('complete-profile') }}" method="POST">
            <div class="complete-profile-items">
                <div class="select-image">
                    <img id="image" src="{{$imagePath}}">
                    <input type="file" id="profileImage" name="profileImage" hidden>
                    <label for="profileImage">Upload photo</label>
                </div>
                <div class="biography">
                    <label for="bio">Biography:</label>
                    <textarea id="bio" name="bio" placeholder="Tell me about yourself..."></textarea>
                </div>
            </div>
            <button type="submit">Update profile</button>
        </form>
    </div>
</div>

@endsection