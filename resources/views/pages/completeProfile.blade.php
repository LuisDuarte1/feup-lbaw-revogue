@extends('layouts.app')

@section('content')
    <x-settingsNavbar :tab="$tab" />

    <div class="page-center">
        <div class="complete-profile-page">
            <h1 class="title">Profile Settings</h1>
            <p>You should now complete you registration by uploading a photo and writing a
                bit about yourself so that other users can know a little about you.<br><br> If you don't feel like doing
                this you can do it later by accessing the settings page. Welcome to ReVogue!</p>
            <form class="complete-profile-form" action="{{ route('complete-profile') }}" method="POST"
                enctype='multipart/form-data'>
                @csrf
                <div class="display-name-box">
                    <label for="display_name">Display Name</label>
                    <input id="display_name" type="text" name="display_name" value="{{ $displayName }}">
                </div>
                <div class="complete-profile-items">
                    <div class="select-image">
                        <img id="image"
                            src="{{ $imagePath !== null ? '/storage/' . $imagePath : '/defaultProfileImage.png' }}">
                        <input type="file" id="profileImage" name="profileImage" hidden>
                        <label for="profileImage">Upload photo</label>
                    </div>
                    <div class="biography">
                        <label for="bio">Biography:</label>
                        <textarea id="bio" name="bio" placeholder="Tell me about yourself...">{{ $bio }}</textarea>
                    </div>
                </div>
                <button type="submit">Update profile</button>
            </form>
        </div>
    </div>
@endsection
