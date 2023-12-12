<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductCartGoneNotification extends BaseNotification
{
    use Queueable;

    protected string $notificationType = 'cart';

    protected array $via = ['mail'];

    protected static function notificationRenderer(\App\Models\Notification $notification): string
    {
        $product = $notification->cartProduct()->get()->first();

        return view('notifications.productCartGone', ['product' => $product, 'notification' => $notification])->render();
    }

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Product $product)
    {
        $this->notificationData['cart_product'] = $product->id;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('Hi '.$notifiable->display_name)
            ->line('It seems like that product \''.$this->product->name.'\' was sold before you could buy it.')
            ->line('Hurry up and don\'t miss a product again!')
            ->action('Go to cart', url('/cart'))
            ->subject($this->product->name.' was sold!');

    }
}
