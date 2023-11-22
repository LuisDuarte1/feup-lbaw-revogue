<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    
    public function getTrendingProducts(){
        $products = ProductController::getTrendingProducts();
        return view('pages.landing', ['products' => $products]);
    }

     
}
