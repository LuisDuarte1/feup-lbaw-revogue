@extends('layouts.app', ['search_bar' => true, 'needs_full_height' => true])



@section('content')
    <div class="messages-page">
        <h1 class="title">Messages</h1>
        <div class="message-thread-details row justify-between">
            @if($currentThread !== null)
                @php
                    $product = $currentThread->messageProduct()->get()->first();
                    $soldBy = $product->soldBy()->get()->first();
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
                        $isActive = $currentThread->id == $messageThread->id
                    @endphp
                    <x-product-message-thread :messageThread="$messageThread" :isActive="$isActive"></x-product-message-thread>
                @endforeach
            </div>
        </div>
        <div class="message-thread">
            @if($currentThread !== null)
                <div class="message-thread-content" data-thread-id="{{$currentThread->id}}">
                    <!--TODO: add bargain logic  -->
                    <div id="page-end"></div>
                    @foreach ($messages->reverse() as $message)
                        <x-message-bubble :message="$message" :current-user="$currentUser"></x-message-bubble>
                    @endforeach
                </div>
                <div class="message-thread-input">
                    <div class="text-input" data-thread-id="{{$currentThread->id}}">
                        <textarea class="message" rows="1" wrap="hard"></textarea>
                        <a href="#" class="send-icon"><ion-icon name="send"></ion-icon></a>
                    </div>
                    <div class="misc-buttons">
                        <a href="#" class="send-image-message"><ion-icon name="images"></ion-icon></a>
                        <a href="#" class="send-bargain-message" data-product-id="{{$currentThread->product}}"><ion-icon name="diamond"></ion-icon></a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection