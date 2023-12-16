@extends('layouts.app', ['search_bar' => true, 'needs_full_height' => true])



@section('content')
    <div class="messages-page">
        <h1 class="title">Messages</h1>
        <div class="message-thread-details row justify-between">
            @if($product !== null)
                @php
                    $soldBy = $product->soldBy()->get()->first()
                @endphp
                <a class="username" href="#">{{'@'.$soldBy->username}}</a>
                <div class="message-thread-details-buttons">
                    <a href="/products/{{$product->id}}" class="button">View Item</a>
                    <a href="/profile/{{$soldBy->id}}" class="button outline">Visit Shop</a>
                </div>
            @endif
        </div>
        <div class="message-list column gap-2 items-center">

            <div class="messages-tab">
                <a href="#" class="active">Products</a>
                <a href="#">Orders</a>
            </div>
            <div class="message-thread-list column gap-1">
                @foreach ($messageThreads as $messageThread)
                    @php
                        $isActive = $product->id == $messageThread->id
                    @endphp
                    <x-product-message-thread :product="$messageThread" :isActive="$isActive"></x-product-message-thread>
                @endforeach
            </div>
        </div>
        <div class="message-thread">
            @if($product !== null)
                <div class="message-thread-content">
                    <!--TODO: add bargain logic  -->
                    @foreach ($messages->reverse() as $message)
                        <x-message-bubble :message="$message" :current-user="$currentUser"></x-message-bubble>
                    @endforeach
                </div>
                <div class="message-thread-input">
                    <div class="text-input" data-product-id="{{$product->id}}">
                        <textarea class="message" rows="1" wrap="hard"></textarea>
                        <a href="#" class="send-icon"><ion-icon name="send"></ion-icon></a>
                    </div>
                    <div class="misc-buttons">
                        <a href="#"><ion-icon name="images"></ion-icon></a>
                        <a href="#"><ion-icon name="diamond"></ion-icon></a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection