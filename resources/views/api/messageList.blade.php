@foreach ($messages->reverse() as $message)
@if($message->message_type !== 'system')
    <x-message-bubble :message="$message" :current-user="$currentUser"></x-message-bubble>
@else
    <x-message-bubble :message="$message" :current-user="null"></x-message-bubble>
@endif
@endforeach