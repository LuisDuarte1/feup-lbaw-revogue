@extends('layouts.app', ['search_bar' => "true"])


@section('content')
<div class="profile-page">
    <div class="profile-header">
        @php
        $productPicture = $user->profile_image_path !== null ? "/storage/".$user->profile_image_path : '/defaultProfileImage.png';
        $name = $user->display_name;
        $username = $user->username;
        $bio = $user->bio === null ? '' : $user->bio;
        //TODO: dynamic rating
        $rating = 3;
        $id = $ownPage ? 'me' : $user->id;
        @endphp
        <x-profileLayout :profilePicture="$productPicture" :name="$name" :username="$username" :bio="$bio" :rating="$rating" />
        <x-profileNavbar :tab="$tab" :ownPage="$ownPage" :id="$id" />
    </div>
    <div class="profile-reviews column gap-2">
        @foreach ($reviews as $review)
        @php
        $reviewDescription = $review->description;
        $reviewerName = $review->reviewer()->get()->first()->display_name;
        $reviewerUsername = $review->reviewer()->get()->first()->username;
        $reviewerProfilePicture = $review->reviewer()->get()->first()->profile_image_path !== null ? "/storage/".$user->profile_image_path : '/defaultProfileImage.png';
        $reviewerRating = $review->stars;
        $reviewImagePaths = $review->image_paths;
        @endphp
        <x-reviewCard :reviewerName="$reviewerName" :reviewerUsername="$reviewerUsername" :reviewerPicture="$reviewerProfilePicture" :reviewerRating="$reviewerRating" :reviewDescription="$reviewDescription" :reviewImagePaths="$reviewImagePaths" />
        @endforeach
    </div>
    <div id="page-end">
    </div>
    @endsection