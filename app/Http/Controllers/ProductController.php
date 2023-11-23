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
        $isInWishlist = false;
        $ownProduct = false;
        if($request->user() !== null){
            $isInWishlist = $request->user()->wishlist()->where('id', $product_id)->exists();
            $ownProduct = $user_id === $request->user()->id;
        }
        while (isset($category)) {
            array_unshift($categories, $category);
            $category = $category->parentCategory;
        }

        return view('pages.product', ['product' => $product, 'attributes' => $attributes, 'user' => $user, 'imagePath' => $imagePath, 'categories' => $categories, 'sold' => ProductController::isProductSold($product), 'isInWishlist' => $isInWishlist, 'ownProduct' => $ownProduct]);
    }

    public static function getTrendingProducts()
    {
        return Product::withCount('wishlist')->get()->sortBy('wishlist_count');
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

    public function deleteProduct(Request $request)
    {
        $product_id = $request->route('id');
        $product = Product::find($product_id);
        if ($product === null) {
            return back()->with('errors', 'Product not found');
        }
        if ($request->user()->id !== $product->sold_by) {
            return back()->with('errors', 'You cannot delete the product because you are not the seller');
        }
        if (ProductController::isProductSold($product)) {
            return back()->with('errors', 'You cannot delete the item because the item has already been sold');
        }
        $product->delete();

        return redirect('/');
    }

    public function editProductPage(Request $request){
        $product_id = $request->route('id');
        $product = Product::find($product_id);
        if ($product === null) {
            return back()->with('errors', 'Product not found');
        }
        if ($request->user()->id !== $product->sold_by) {
            return back()->with('errors', 'You cannot edit the product because you are not the seller');
        }
        if (ProductController::isProductSold($product)) {
            return back()->with('errors', 'You cannot edit the item because the item has already been sold');
        }
        return view('pages.editProduct', ['product' => $product]);
    }

    public function editProduct(Request $request){
        $product_id = $request->route('id');
        $product = Product::find($product_id);
        if ($product === null) {
            return back()->with('errors', 'Product not found');
        }
        if ($request->user()->id !== $product->sold_by) {
            return back()->with('errors', 'You cannot edit the product because you are not the seller');
        }
        if (ProductController::isProductSold($product)) {
            return back()->with('errors', 'You cannot edit the item because the item has already been sold');
        }
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable|max:5000',
            'price' => 'required|gt:0'
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();

        return redirect('/products/'.$product->id);
    }
}
