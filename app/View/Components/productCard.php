<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProductCard extends Component
{
    public $image;

    public $price;

    public $size;

    public $id;

    public $condition;

    public $name;

    public function __construct($image, $price, $size, $id)
    {
        $this->image = $image;
        $this->price = $price;
        $this->size = $size;
        $this->id = $id;
        $this->condition = 'Used';
        $this->name = 'Blue Button-Up Shirt';
    }

    public function render()
    {
        return view('components.productCard', [
            'image' => $this->image,
            'price' => $this->price,
            'size' => $this->size,
            'id' => $this->id,
            'condition' => $this->condition,
            'name' => $this->name,
        ]);
    }
}
