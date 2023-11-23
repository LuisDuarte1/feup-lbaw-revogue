<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartProductController extends Controller
{
    public function AddProductToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        } else {
            $productId = $request->product;

            $productInCart = $request->user()->cart()->where('product', $productId)->get()->first();

            if ($productInCart != null) {
                return response()->json(['error' => 'Product already in cart'], 400);
            } else {
                $product = Product::find($productId);
                if (ProductController::isProductSold($product)) {
                    return response()->json(['error' => 'Product has been already sold'], 400);
                }
                if ($product == null) {
                    return response()->json(['error' => 'Product not found'], 404);
                }
                if ($request->user()->id == $product->id) {
                    return response()->json(['error' => 'Cannot add own product to cart'], 400);
                }
                $request->user()->cart()->attach($productId); // attach() is a method from BelongsToMany relationship (User.php

                return response()->json(['success' => 'Product added to cart successfully'], 200);
            }
        }
    }

    public function RemoveProductFromCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        } else {
            $productId = $request->product;

            $productInCart = $request->user()->cart()->where('product', $productId)->get()->first();

            if ($productInCart == null) {
                return response()->json(['error' => 'Product not in cart'], 400);
            } else {
                $product = Product::find($productId);
                if ($product == null) {
                    return response()->json(['error' => 'Product not found'], 404);
                }
                if (ProductController::isProductSold($product)) {
                    return response()->json(['error' => 'Product has been already sold'], 400);
                }
                if ($request->user()->id == $product->id) {
                    return response()->json(['error' => 'Cannot remove own product to cart'], 400);
                }
                $request->user()->cart()->detach($productId); // detach() is a method from BelongsToMany relationship (User.php

                return response()->json(['success' => 'Product removed from cart successfully'], 200);
            }
        }
    }
}
