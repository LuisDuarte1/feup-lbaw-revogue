<?php
namespace App\Notifications;

use ErrorException;
use Illuminate\Notifications\Notification;

class NotificationDatabaseChannel{


    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send(object $notifiable, Notification $notification)
    {
        if(!method_exists($notification, 'toArray')){
            throw new ErrorException("Couldn't get toArray method on ".get_class($notification)." class.");
        }
        $notifiable->notifications()->create($notification->toArray($notifiable));
 
        // Send notification to the $notifiable instance...
    }
}