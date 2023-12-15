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
        $reviews = $user->reviewed()->orderBy('sent_date', 'desc')->limit(5)->get();
        if ($request->user() !== null) {
            $isInWishlist = $request->user()->wishlist()->where('id', $product_id)->exists();
            $ownProduct = $user_id === $request->user()->id;
        }
        while (isset($category)) {
            array_unshift($categories, $category);
            $category = $category->parentCategory;
        }

        return view('pages.product', ['product' => $product, 'attributes' => $attributes, 'user' => $user, 'imagePath' => $imagePath, 'categories' => $categories, 'sold' => ProductController::isProductSold($product), 'isInWishlist' => $isInWishlist, 'ownProduct' => $ownProduct, 'reviews' => $reviews]);
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

        return view('pages.productList', ['products' => $list, 'paginator' => $products]);
    }

    public function deleteProduct(Request $request)
    {
        $product_id = $request->route('id');
        $product = Product::find($product_id);
        $this->authorize('delete', $product);
        $product->delete();

        return redirect('/');
    }

    public function editProductPage(Request $request)
    {
        $product_id = $request->route('id');
        $product = Product::find($product_id);
        $this->authorize('update', $product);

        return view('pages.editProduct', ['product' => $product]);
    }

    public function editProduct(Request $request)
    {
        $product_id = $request->route('id');
        $product = Product::find($product_id);
        $this->authorize('update', $product);

        if ($product === null) {
            return back()->with('errors', 'Product not found');
        }
        if ($request->user()->id !== $product->sold_by) {
            return back()->with('errors', 'You cannot edit the product because you are not the seller');
        }
        if (ProductController::isProductSold($product)) {
            return back()->with('errors', 'You cannot edit the item because the item has already been sold');
        }

        if ($request->hasfile('imageToUpload')) {
            $existingImages = $product->image_paths;
            if (count($existingImages) > 0) {
                foreach ($existingImages as $existingImage) {
                    $filename = public_path($existingImage);
                    unlink($filename);
                }
            }
        }

        $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable|max:5000',
            'price' => 'required|gt:0',
            'imageToUpload' => 'required',
        ]);

        $image_paths = [];

        $images = $request->file('imageToUpload');

        if (! is_array($images)) {
            $images = [$images];
        }

        foreach ($images as $image) {
            $filename = '/storage/'.$image->storePublicly('product-images', ['disk' => 'public']);
            array_push($image_paths, $filename);
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->image_paths = $image_paths;
        $product->save();

        return redirect('/products/'.$product->id);
    }
}
