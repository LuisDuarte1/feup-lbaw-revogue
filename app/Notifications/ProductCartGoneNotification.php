<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductCartGoneNotification extends BaseNotification
{
    use Queueable;
    protected string $notificationType = 'cart';
    protected array $via = ['mail'];

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
                    ->line('It seems like that product \''.$this->product->name.'\' was sold before you could buy it.')
                    ->line('Hurry up and don\'t miss a product again!')
                    ->action('Show product', url('/products/'.$this->product->id))
                    ->action('Go to cart', url('/cart'));
    }
}
