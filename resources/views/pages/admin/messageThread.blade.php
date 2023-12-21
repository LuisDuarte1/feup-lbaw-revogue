@extends('layouts.admin')


@section('content')
<section class="admin-message-wrapper page-center column justify-center gap-2">
    <h1>Message Thread</h1>
    <div class="admin-message-thread items-center gap-2">
        @if($messages->count() === 0)
        <div class="no-messages column items-center justify-center h-full">
            <img src="/empty_notifications.svg" width="500">
            <p>These users did not exchange messages</p>
        </div>
        @else
        @foreach ($messages->reverse() as $message)
        @if($message->message_type !== 'system')
        <x-message-bubble :message="$message" :current-user="$reporter"></x-message-bubble>
        @else
        <x-message-bubble :message="$message" :current-user="null"></x-message-bubble>
        @endif
        @endforeach
        @endif
    </div>
</section>
@endsection