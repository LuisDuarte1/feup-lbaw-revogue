<div class="notification-container">
    <div class="notification" actionUrl="{{$route}}" data-notificationId="{{$notification->id}}">
        {{ $slot }}
        @if (!$notification->read)
            <div class="notification-read">
            </div>
        @endif
        <div class="notification-actions">
            
            <a href="#" class="mark-as-read-notification"><ion-icon name="{{$notification->read ? 'mail-open-outline' : 'mail-outline'}}"></ion-icon></a>
            <a href="#" class="dismiss-notification"><ion-icon name="{{$notification->dismissed ? 'arrow-back-outline' : 'trash-outline' }}"></ion-icon></a>
        </div>
    </div>
</div>