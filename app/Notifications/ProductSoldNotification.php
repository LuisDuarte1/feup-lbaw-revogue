<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductSoldNotification extends BaseNotification
{
    use Queueable;

    protected string $notificationType = 'sold';

    protected array $via = ['mail'];

    protected static function notificationRenderer(\App\Models\Notification $notification): string
    {
        $product = Product::where('id', $notification->sold_product)->get()->first();
        $order = $product->orders()->where('status', '<>', 'cancelled')->get()->first();
        $broughtBy = $order->user()->get()->first();
        $price = $product->price - $order->pivot->discount;

        return view('notifications.productSold', ['product' => $product, 'broughtBy' => $broughtBy, 'notification' => $notification, 'price' => $price])->render();
    }

    /**
     * Create a new notification instance.
     */
    public function __construct(public Product $product)
    {
        $this->notificationData['sold_product'] = $product->id;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('Hi '.$notifiable->display_name.'!')
            ->subject('Your product \''.$this->product->name.'\' was sold!')
            ->line('\''.$this->product->name.'\' was sold for '.$this->product->price.'€.')
                    //TODO: action with order message thread
                    //->action('Notification Action', url('/'))
            ->line('Thank you for using ReVogue');
    }
}
