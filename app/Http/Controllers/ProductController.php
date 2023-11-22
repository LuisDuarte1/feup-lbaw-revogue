<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public static function isProductSold(Product $product): bool
    {
        $orders = $product->orders()->get();
        foreach ($orders as $order) {
            if ($order->status !== 'cancelled') {
                return true;
            }
        }

        return false;
    }

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
        $isInWishlist = $request->user()->wishlist()->where('id', $product_id)->exists();
        while (isset($category)) {
            array_unshift($categories, $category);
            $category = $category->parentCategory;
        }

        return view('pages.product', ['product' => $product, 'attributes' => $attributes, 'user' => $user, 'imagePath' => $imagePath, 'categories' => $categories, 'sold' => ProductController::isProductSold($product), 'isInWishlist' => $isInWishlist]);
    }

    public static function getTrendingProducts() : array{
        $products = Product::;
         
    }

    public function listProductsDate(Request $request)
    {
        $products = Product::latest()->paginate(40);
        $list = [];
        foreach ($products as $product) {
            $size = $product->attributes()->where('key', 'Size')->get()->first()->value;
            $color = $product->attributes()->where('key', 'Color')->get()->first()->value;
            array_push($list, ['product' => $product, 'size' => $size, 'color' => $color]);
        }

        return view('pages.product-list', ['products' => $list, 'paginator' => $products]);
    }
}
