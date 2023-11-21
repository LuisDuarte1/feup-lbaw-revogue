<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getPage(Request $request)
    {
        $product_id = $request->route('id');
        $product = Product::find($product_id);
        $attributes = $product->attributes()->get();
        $user_id = $product->sold_by;
        $user = User::find($user_id);
        $imagePath = $user->profile_image_path ?? '../defaultProfileImage.png';
        $categories = [];
        $category = $product->productCategory;
        while (isset($category)) {
            array_unshift($categories, $category);
            $category = $category->parentCategory;
        }

        return view('pages.product', ['product' => $product, 'attributes' => $attributes, 'user' => $user, 'imagePath' => $imagePath, 'categories' => $categories]);
    }
}
