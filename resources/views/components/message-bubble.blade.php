@php
    $fromSelf = $message->from_user == $currentUser->id
@endphp

<div @class([
    'message-bubble',
    'sent' => $fromSelf,
    'received' => !$fromSelf
    ])>
    @if ($message->message_type == 'text')
        <div class="message-text-content">
            <p>{{$message->text_content}}</p>
        </div>
    @endif
    <div class="message-date">{{$message->sent_date->diffForHumans(['parts' => 2])}}</div>
</div>