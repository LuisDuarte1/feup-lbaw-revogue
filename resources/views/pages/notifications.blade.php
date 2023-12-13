@extends('layouts.app', ['search_bar' => true])


@section('content')

    <div class="column items-center gap-2 notifications-page">
        <h1 class="title">Notifications</h1>

        <div class="notification-tab">
            <a href="/notifications" class="{{$dismissed == '1' ? '' : 'active'}}">All</a>
            <a href="/notifications?dismissed=1" class="{{$dismissed == '1' ? 'active' : ''}}">Dismissed</a>
        </div>

        <div class="action-buttons">
            <form method="POST" action="/notifications">
                @csrf
                <input type="hidden" name="action" value="readAll">
                <button type="submit">Mark all as read</button>
            </form>
            <form method="POST" action="/notifications">
                @csrf
                <input type="hidden" name="action" value="dismissAll">
                <button type="submit">Dismiss all</button>
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
            <div class="column items-center justify-center grow-2">
                <p>It seems that your notification section is empty.</p>
            </div>
        @endif
    </div>
@endsection 