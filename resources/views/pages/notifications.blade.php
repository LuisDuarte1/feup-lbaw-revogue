@extends('layouts.app', ['search_bar' => true])


@section('content')

    <div class="column justify-center items-center gap-2 nofitifications-page">
        <h1 class="title">Notifications</h1>

        <div class="action-buttons">
            <button>Mark all as read</button>
            <button>Dismiss all</button>
        </div>

        <div class="notification-tab">
            <a href="#">All</a>
            <a href="#">Dismissed</a>
        </div>

        <div class="notifications-list column gap-2 ">
            @foreach ($notifications as $notification)
                {!!$notification !!}
            @endforeach
        </div>
    </div>
@endsection 