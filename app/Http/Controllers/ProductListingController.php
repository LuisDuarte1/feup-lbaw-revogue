<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductListingController extends Controller
{
    public function getPage()
    {
        return view('pages.productListing');
    }

    public function addProduct(Request $request)
    {}

    
}
