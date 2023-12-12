<div class="notification-container">
    <div class="notification" actionUrl="{{$route}}" data-notificationId="{{$notification->id}}">
        {{ $slot }}
        @if (!$notification->read)
            <div class="notification-read">
            </div>
        @endif
        <div class="notification-actions">

        </div>
    </div>
</div>