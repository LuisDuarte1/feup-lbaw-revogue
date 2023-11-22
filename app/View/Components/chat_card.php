<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class chat_card extends Component
{
    public $user_id;

    public $user_displayname;

    public $username;

    public $user_image;

    public $product_id;

    public $product_image;

    public $last_message;

    public $last_message_time;

    public function __construct($user_id, $user_displayname, $username, $user_image, $last_message, $last_message_time, $product_id, $product_image)
    {
        $this->user_id = $user_id;
        $this->user_displayname = $user_displayname;
        $this->username = $username;
        $this->user_image = $user_image;
        $this->last_message = $last_message;
        $this->last_message_time = $last_message_time;
        $this->product_id = $product_id;
        $this->product_image = $product_image;

    }

    //

    //

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.chat_card', [
            'user_id' => $this->user_id,
            'user_displayname' => $this->user_displayname,
            'username' => $this->username,
            'user_image' => $this->user_image,
            'last_message' => $this->last_message,
            'last_message_time' => $this->last_message_time,
            'product_id' => $this->product_id,
            'product_image' => $this->product_image,
        ]);
    }
}
