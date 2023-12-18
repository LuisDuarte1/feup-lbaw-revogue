@foreach ($messages->reverse() as $message)
<x-message-bubble :message="$message" :current-user="$currentUser"></x-message-bubble>
@endforeach