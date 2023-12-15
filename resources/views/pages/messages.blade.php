@extends('layouts.app', ['search_bar' => true, 'needs_full_height' => true])



@section('content')
    <div class="messages-page">
        <h1 class="title">Messages</h1>
        <div class="message-thread-details row justify-between">
            <a class="username" href="#">@@username</a>
            <div class="message-thread-details-buttons">
                <a href="#" class="button">View Item</a>
                <a href="#" class="button outline">Visit Shop</a>

            </div>
        </div>
        <div class="message-list column gap-2 items-center">

            <div class="messages-tab">
                <a href="#" class="active">Products</a>
                <a href="#">Orders</a>
            </div>
            <div class="message-thread-list column gap-1">
                @foreach ($messageThreads as $messageThread)
                    <x-product-message-thread :product="$messageThread"></x-product-message-thread>
                @endforeach
            </div>
        </div>
        <div class="message-thread">
            <div class="message-thread-content">
            </div>
            <div class="message-thread-input">
                <div class="text-input">
                    <textarea class="message" rows="1" wrap="hard"></textarea>
                    <ion-icon name="send"></ion-icon>
                </div>
                <div class="misc-buttons">
                    <a href="#"><ion-icon name="images"></ion-icon></a>
                    <a href="#"><ion-icon name="diamond"></ion-icon></a>
                </div>
            </div>
        </div>
    </div>
@endsection