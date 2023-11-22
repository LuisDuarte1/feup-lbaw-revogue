<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    public function AddProductToWishlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        } else {
            $productId = $request->product;
            $userId = $request->user()->id;

            $productInWishlist = $request->user()->wishlist()->where('product', $productId)->get()->first();

            if ($productInWishlist != null) {
                return response()->json(['error' => 'Product already in wishlist'], 400);
            } else {
                $product = Product::find($productId);
                if ($product == null) {
                    return response()->json(['error' => 'Product not found'], 404);
                }

                $request->user()->wishlist()->attach($productId); // attach() is a method from BelongsToMany relationship (User.php

                return response()->json(['success' => 'Product added to wishlist successfully'], 200);
            }
        }
    }

    public function RemoveProductFromWishlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        } else {
            $productId = $request->product;

            $productInWishlist = request()->user()->wishlist()->where('product', $productId)->get()->first();
            if ($productInWishlist == null) {
                return response()->json(['error' => 'Product not in wishlist'], 400);
            } else {
                $product = Product::find($productId);
                if ($product == null) {
                    return response()->json(['error' => 'Product not found'], 404);
                }

                $request->user()->wishlist()->detach($productId); // detach() is a method from BelongsToMany relationship (User.php

                return response()->json(['success' => 'Product removed from wishlist successfully'], 200);
            }
        }
    }
}
