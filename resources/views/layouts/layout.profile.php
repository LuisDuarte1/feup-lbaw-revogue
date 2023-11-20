@extends('layouts.app') //not sure if this is correct

<div class="profile-description-wrapper">
    <div class="profile-picture-container">
        <img src="{{ $image }}" alt="profile picture">
    </div>
    <div class="profile-description">
        <div class="profile-name">
            <h1>{{ $name }}</h1>
        </div>
        <div class="profile-username">
            <h1>{{ $username }}</h1> 
        </div>
        <div class="profile-bio">
            <p>{{ $bio }}</p> 
        </div>
        <div class="profile-rating">
            <p>{{ $rating }}</p> //have to see how to add the stars
        </div>
    </div>
</div>