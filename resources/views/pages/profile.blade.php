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
        <x-profileLayout :profilePicture="$productPicture" :name="$name" :username="$username" :bio="$bio" :rating="$rating" :id="$id" />
        <x-profileNavbar :tab="$tab" :ownPage="$ownPage" :id="$id" />
    </div>
    <div class="profile-products">
        @foreach ($products as $product)
        @php
        $price = $product['product']->price;
        $image = $product['product']->image_paths[0];
        $size = $product['size'];
        $id = $product['product']->id;
        @endphp
        <x-productCard :price="$price" :image="$image" :size="$size" :id="$id" :shipping="2" :condition="'Good'" />
        @endforeach
    </div>
    <div id="page-end">
    </div>
    @endsection