<?php

namespace App\Notifications;

use App\Notifications\NotificationDatabaseChannel;
use ErrorException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BaseNotification extends \Illuminate\Notifications\Notification
{
    use Queueable;
    protected string $notificationType;
    protected array $via = [];
    protected array $notificationData;

    protected static function notificationRenderer(\App\Models\Notification $notification):string{
        throw new ErrorException(get_called_class().' has not defined a notification render handler...');
    }

    final public static function renderNotification(\App\Models\Notification $notification):string{
        return static::notificationRenderer($notification);
    }

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
    }

    final public function getNotificationType(){
        return $this->notificationType;
    }

    final public function via(object $notifiable): array
    {
        return [NotificationDatabaseChannel::class, ...$this->via];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    final public function toArray(object $notifiable): array
    {
        if(!isset($this->notificationType)){
            throw new ErrorException('notificationType is not defined in '.get_class($this));
        }
        if(!isset($this->notificationData)){
            throw new ErrorException('notificationData is not defined in '.get_class($this));
        }
        return [
            'class_name' => get_class($this),
            'type' => $this->notificationType,
            'read' => false,
            'dismissed' => false,
            ... $this->notificationData
        ];
    }
}
