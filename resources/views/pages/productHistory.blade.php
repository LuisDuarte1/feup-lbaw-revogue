@extends('layouts.app', ['search_bar' => true])

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
        <div class="purchase column gap-1">
            <div class="purchase-header row items-center">
                <div class="row">
                    <div class="column">
                        <h3 class="purchase-title">Purchase 1</h3>
                        <div class="purchase-date">11/12/21</div>
                    </div>
                </div>
                <div class="purchase-price">Total: 100€</div>
            </div>
            <div class="purchase-orders column gap-2">
                <div class="purchase-order column gap-3">
                    <div class="order-header row gap-1">
                        <div class="row items-center gap-3">
                            <div class="row items-center">
                                <img src="/defaultProfileImage.png" class="profile-picture">
                                <div class="order-user">
                                    <div class="display-name">Display name</div>
                                    <div class="username">@username</div>
                                </div>
                            </div>
                            <div class="order-status row items-center">
                                <ion-icon name="ellipse" class="sent"></ion-icon>
                                Status: Delivered
                            </div>
                            <div class="order-shipping">
                                Shipping: 2€
                            </div>
                        </div>
                        <div class="row gap-1 items-center">
                            <div class="review-button">
                                <button>Review</button>
                            </div>
                            <div class="cancel-button">
                                <button>Cancel</button>
                            </div>
                        </div>
                    </div>
                    <div class="order-products column gap-1">
                        <div class="order-product row gap-1 items-center">
                            <div class="product-image column items-center">
                                <img src="https://picsum.photos/1020/720">
                            </div>
                            <div class="product-info row gap-1 items-center">
                                <div class="column wrapper">
                                    <div class="product-name">Product name</div>
                                    <div class="product-size">Size: M</div>
                                    <div class="product-condition">Condition: Good</div>
                                </div>
                                <div class="column wrapper">
                                    <div class="product-total">Total: 52€</div>
                                    <div class="product-price">Price: 50€</div>
                                    <div class="product-discount">Discount: 2€</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    <!-- @class(['sent'=> true, ])-->