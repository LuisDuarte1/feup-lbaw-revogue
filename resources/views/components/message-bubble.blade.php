<div class="message-bubble">
    @if ($message->message_type == 'text')
        <div class="message-text-content">
            <p>{{$message->text_content}}</p>
        </div>
    @endif
</div>