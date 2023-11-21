<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

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
            $userId = $request->user()->id;

            $productInCart = CartProduct::where('product', $productId)->where('belongs_to', $userId)->first();

            if ($productInCart != null) {
                return response()->json(['error' => 'Product already in cart'], 404);
            } else {
                $product = Product::find($productId);
                if ($product == null) {
                    return response()->json(['error' => 'Product not found'], 404);
                }

                $cartProduct = $request->user()->cart()->attach($productId); // attach() is a method from BelongsToMany relationship (User.php

                return response()->json(['success' => 'Product added to cart successfully'], 200);
            }
        }
    }
}
