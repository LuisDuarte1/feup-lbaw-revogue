@extends('layouts.app', ['search_bar' => "true"])


@section('content')
<div class="profile-page">
    <div class="profile-header">
        @php
        $productPicture = $user->profile_image_path !== null ? "/storage/".$user->profile_image_path : '/defaultProfileImage.png';
        $name = $user->display_name;
        $username = $user->username;
        $bio = $user->bio === null ? '' : $user->bio;
        $rating = $user->reviewed()->avg('stars');
        $id = $ownPage ? 'me' : $user->id;
        @endphp
        <x-profileLayout :profilePicture="$productPicture" :name="$name" :username="$username" :bio="$bio" :rating="$rating" :id="$id"/>
        <x-profileNavbar :tab="$tab" :ownPage="$ownPage" :id="$id" />
    </div>
    <div class="profile-reviews column gap-3">
        @foreach ($reviews as $review)
        @php
        $reviewDescription = $review->description;
        $reviewer = $review->reviewer()->get()->first();
        $reviewerRating = $review->stars;
        $reviewImagePaths = $review->image_paths;
        $reviewDate = $review->sent_date->format('d/m/Y');
        @endphp
        <x-reviewCard :reviewer="$reviewer" :reviewerRating="$reviewerRating" :reviewDescription="$reviewDescription" :reviewImagePaths="$reviewImagePaths" :reviewDate="$reviewDate" />
        @endforeach
    </div>
    <div id="page-end">
    </div>
    @endsection