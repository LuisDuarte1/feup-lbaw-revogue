@extends('layouts.app', ['search_bar' => true, 'needs_full_height' => true])



@section('content')
    <div class="messages-page">
        <h1 class="title">Messages</h1>
        <div class="message-thread-details row justify-between">
            @if($currentThread !== null && $messageThreadType === 'product')
                @php
                    $product = $currentThread->messageProduct()->get()->first();
                    $soldBy = $product->soldBy()->get()->first();
                @endphp
                <a class="username" href="#">{{'@'.$soldBy->username}}</a>
                <div class="message-thread-details-buttons">
                    <a href="/products/{{$product->id}}" class="button">View Item</a>
                    <a href="/profile/{{$soldBy->id}}" class="button outline">Visit Shop</a>
                </div>
            @elseif ($currentThread !== null && $messageThreadType === 'order')
                @php
                    $soldBy = $currentThread->messageOrder->products[0]->soldBy;
                @endphp
                <a class="username" href="#">{{'@'.$soldBy->username}}</a>
                <div class="message-thread-details-buttons">
                    <a href="/profile/{{$soldBy->id}}" class="button outline">Visit Shop</a>
                </div>
            @endif
        </div>
        <div class="message-list column gap-2 items-center">

            <div class="messages-tab">
                <a href="/messages?type=product" @class(['active' => $messageThreadType == 'product'])>Products</a>
                <a href="/messages?type=order" @class(['active' => $messageThreadType == 'order'])>Orders</a>
            </div>
            <div class="message-thread-list column gap-1">
                @foreach ($messageThreads as $messageThread)
                    @php
                        $isActive = $currentThread->id == $messageThread->id
                    @endphp
                    @if($messageThreadType === 'product')
                        <x-product-message-thread :messageThread="$messageThread" :isActive="$isActive"></x-product-message-thread>
                    @else
                        <x-order-message-thread :messageThread="$messageThread" :isActive="$isActive"></x-order-message-thread>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="message-thread">
            @if($currentThread !== null)
                <div class="message-thread-content" data-thread-id="{{$currentThread->id}}" data-current-user-id="{{Auth::user()->id}}">
                    <!--TODO: add bargain logic  -->
                    <div id="page-end"></div>
                    @foreach ($messages->reverse() as $message)
                        @if($message->message_type !== 'system')
                            <x-message-bubble :message="$message" :current-user="$currentUser"></x-message-bubble>
                        @else
                            <x-message-bubble :message="$message" :current-user="null"></x-message-bubble>
                        @endif
                    @endforeach
                </div>
                <div class="message-thread-input">
                    <div class="text-input" data-thread-id="{{$currentThread->id}}">
                        <textarea class="message" rows="1" wrap="hard"></textarea>
                        <a href="#" class="send-icon"><ion-icon name="send"></ion-icon></a>
                    </div>
                    <div class="misc-buttons">
                        <a href="#" class="send-image-message"><ion-icon name="images"></ion-icon></a>
                        @if ($messageThreadType == 'product')
                            <a href="#" class="send-bargain-message" data-product-id="{{$currentThread->product}}"><ion-icon name="diamond"></ion-icon></a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection