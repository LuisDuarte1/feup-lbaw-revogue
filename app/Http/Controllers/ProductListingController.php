<?php

namespace App\Http\Controllers;

use App\Http\Controllers\api\AttributeController;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductListingController extends Controller
{
    public function getPage()
    {
        return view('pages.productListing', [
            'colors' => AttributeController::getAttributeValues('Color'),
            'sizes' => AttributeController::getAttributeValues('Size'),
            'categories' => Category::all()
        ]);
    }

    public function addProduct(Request $request)
    {
    }
}
