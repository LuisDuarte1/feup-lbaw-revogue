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
        <a class="username" href="/profile/{{$soldBy->id}}">{{'@'.$soldBy->username}}</a>
        <div class="message-thread-details-buttons">
            <div class="report row items-center" data-type="message_thread" data-id="{{$currentThread->id}}">
                <ion-icon name="flag-outline" aria-label="report-icon"></ion-icon>
                Report
            </div>
            <a href="/products/{{$product->id}}" class="row button items-center">View Item</a>
            <a href="/profile/{{$soldBy->id}}" class="button outline">Visit Shop</a>
        </div>
        @elseif ($currentThread !== null && $messageThreadType === 'order')
        @php
        $soldBy = $currentThread->messageOrder->products[0]->soldBy;
        @endphp
        <div class="report row items-center" data-type="message_thread" data-id="{{$currentThread->id}}">
            <ion-icon name="flag-outline" aria-label="report-icon"></ion-icon>
            Report
        </div>
        <a class="username" href="#">{{'@'.$soldBy->username}}</a>
        <div class="order-status row items-center">
            @php
            $status = $currentThread->messageOrder->status;
            $stat = ucfirst($status);
            $stat = preg_split('/(?=[A-Z])/', $stat);
            $stat = implode(" ", $stat);
            @endphp

            <ion-icon name="ellipse" class="{{$status}}" aria-label="order-status-icon"></ion-icon>
            Status: {{$stat}}
        </div>
        <div class="message-thread-details-buttons">
            <a href="/profile/{{$soldBy->id}}" class="button outline">Visit Shop</a>
        </div>
        @endif
    </div>
    <div class="message-list column gap-2 items-center">

        <div class="messages-tab">
            <a href="/messages?type=product" @class(['active'=> $messageThreadType == 'product'])>Products</a>
            <a href="/messages?type=order" @class(['active'=> $messageThreadType == 'order'])>Orders</a>
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
                <textarea class="message" aria-label="message-text-area" rows="1" wrap="hard"></textarea>
                <a href="#" class="send-icon" aria-label="message-send-button"><ion-icon name="send" aria-label="send-icon"></ion-icon></a>
            </div>
            <div class="misc-buttons">
                <a href="#" class="send-image-message" aria-label="message-send-image"><ion-icon name="images" aria-label="images-icon"></ion-icon></a>
                @if ($messageThreadType == 'product')
                <a href="#" class="send-bargain-message" aria-label="message-send-bargain" data-product-id="{{$currentThread->product}}"><ion-icon name="diamond" aria-label="bargain-icon"></ion-icon></a>
                @endif
                @if ($messageThreadType == 'order')
                <a href="#" class="change-order-status" aria-label="change-order-status" data-order-id="{{$currentThread->order}}"><ion-icon src="/truck-line.svg" aria-label="status-icon"></ion-icon></a>
                <a href="#" class="cancel-order" aria-label="cancel-order" data-order-id="{{$currentThread->order}}"><ion-icon name="close" aria-label="cancel-icon"></ion-icon></a>
                @endif
            </div>
        </div>
        @else
        <div class="no-messages column items-center justify-center h-full">
            <img src="/empty_notifications.svg" width="500">
            <p>You don't have any messages yet</p>
        </div>
        @endif
    </div>
</div>
@endsection