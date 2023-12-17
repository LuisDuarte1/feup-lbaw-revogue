@extends('layouts.app', ['search_bar' => true, 'needs_full_height' => true])

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
    <div class="purchase-history column gap-3">
        @if (count($purchases) === 0)
        <div class="empty-purchase column items-center gap-3">
            <img src="/empty_purchase.svg" width="500">
            <div class="column items-center gap-1">
                <p>You still haven't made any purchases yet.</p>
                <a href="/products" class="shop-button">Shop</a>
            </div>
        </div>
        @else
        @foreach ($purchases as $purchase=>$orders)
        <x-purchaseCard :purchase="$purchase" :orders="$orders" />
        @endforeach
        <div id="page-end"></div>
        @endif
    </div>
@endsection