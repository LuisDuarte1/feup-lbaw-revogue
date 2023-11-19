<?php
namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ProductCard extends Component
{
   public $image;
   public $price;
   public $size;

   public function __construct($image, $price, $size)
   {
       $this->image = $image;
       $this->price = $price;
       $this->size = $size;
   }

   public function render()
   {
       return view('components.productCard', [
           'image' => $this->image,
           'price' => $this->price,
           'size' => $this->size,
       ]);
   }
}

?>