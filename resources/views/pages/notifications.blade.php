@extends('layouts.app', ['search_bar' => true])


@section('content')

    <div class="column items-center gap-3 notifications-page">
        <h1 class="title">Notifications</h1>

        <div class="notification-tab justify-center items-center">
            <a href="/notifications" class="{{$dismissed == '1' ? '' : 'active'}}">All</a>
            <a href="/notifications?dismissed=1" class="{{$dismissed == '1' ? 'active' : ''}}">Dismissed</a>
        </div>

        <div class="action-buttons justify-center items-center">
            <form method="POST" action="/notifications" class="row justify-end">
                @csrf
                <input type="hidden" name="action" value="readAll">
                <button type="submit" class="read items-center row">
                    <ion-icon name="checkmark-outline"></ion-icon>
                    Mark all as read
                </button>
            </form>
            <form method="POST" action="/notifications" class="row justify-start">
                @csrf
                <input type="hidden" name="action" value="dismissAll">
                <button type="submit" class="dismiss items-center row">
                    <ion-icon name="close-outline"></ion-icon>
                    Dismiss all
                </button>
            </form>
        </div>
        @if(count($notifications) !== 0)
            <div class="notifications-list column gap-2 ">
                @foreach ($notifications as $notification)
                    {!!$notification !!}
                @endforeach
                
                <div id="page-end">
                </div>
            </div>
        @else
            <div class="column w-full items-center justify-center grow-2">
                <img src="/empty_notifications.svg" width="400">
                <p>It seems that your notification section is empty.</p>
            </div>
        @endif
    </div>
@endsection 