<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WishlistProductGoneNotification extends BaseNotification
{
    use Queueable;
    protected string $notificationType = 'wishlist';
    protected array $via = ['mail'];

    protected static function notificationRenderer(\App\Models\Notification $notification):string{
        $product = $notification->wishlistProduct()->get()->first();
        return view('notifications.wishlistProductGone', ['product' => $product, 'notification' => $notification])->render();
    }

    /**
     * Create a new notification instance.
     */
    public function __construct(public Product $product)
    {
        $this->notificationData['wishlist_product'] = $product->id;
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->greeting('Hi '.$notifiable->display_name)
                    ->line('It seems like that product \''.$this->product->name.'\' was sold before you could buy it.')
                    ->line('Hurry up and don\'t miss a product again!')
                    ->action('Go to wishlist', url('/profile/me/likes'))
                    ->subject($this->product->name. ' was sold!');
    }
}
