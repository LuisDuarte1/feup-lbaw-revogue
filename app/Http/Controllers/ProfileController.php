<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;

//TODO (luisd): use pagination
class ProfileController extends Controller
{
    public static function getSellingProducts(User $user, $pageSize = 20): array
    {
        $products = $user->products()->get();
        $list = [];
        foreach ($products as $product) {
            if (ProductController::isProductSold($product)) {
                continue;
            }
            $size = $product->attributes()->where('key', 'Size')->get()->first()->value;
            $color = $product->attributes()->where('key', 'Color')->get()->first()->value;
            array_push($list, ['product' => $product, 'size' => $size, 'color' => $color]);
        }

        return $list;
    }

    public static function getSoldProducts(User $user, $pageSize = 20): array
    {
        $products = $user->products()->get();
        $list = [];
        foreach ($products as $product) {
            if (! ProductController::isProductSold($product)) {
                continue;
            }
            $size = $product->attributes()->where('key', 'Size')->get()->first()->value;
            $color = $product->attributes()->where('key', 'Color')->get()->first()->value;
            array_push($list, ['product' => $product, 'size' => $size, 'color' => $color]);
        }

        return $list;
    }

    public static function getLikedProducts(User $user, $pageSize = 20): array
    {
        $products = $user->wishlist()->get();
        $list = [];
        foreach ($products as $product) {
            $size = $product->attributes()->where('key', 'Size')->get()->first()->value;
            $color = $product->attributes()->where('key', 'Color')->get()->first()->value;
            array_push($list, ['product' => $product, 'size' => $size, 'color' => $color]);
        }

        return $list;
    }

    public function sellingProducts(Request $request)
    {
        $user = null;
        $ownPage = false;
        if ($request->route('id') === 'me') {
            $user = $request->user();
            $ownPage = true;
        } else {
            $user = User::where('id', $request->route('id'))->get()->first();
        }
        $products = ProfileController::getSellingProducts($user);

        return view('pages.profile', ['products' => $products, 'user' => $user, 'ownPage' => $ownPage, 'tab' => 'selling']);
    }

    public function soldProducts(Request $request)
    {
        $user = null;
        $ownPage = false;
        if ($request->route('id') === 'me') {
            $user = $request->user();
            $ownPage = true;
        } else {
            $user = User::where('id', $request->route('id'))->get()->first();
        }
        $products = ProfileController::getSoldProducts($user);

        return view('pages.profile', ['products' => $products, 'user' => $user, 'ownPage' => $ownPage, 'tab' => 'sold']);
    }

    public function likedProducts(Request $request)
    {
        $user = null;
        $ownPage = false;
        if ($request->route('id') === 'me') {
            $user = $request->user();
            $ownPage = true;
        } else {
            $user = User::where('id', $request->route('id'))->get()->first();
        }
        $products = ProfileController::getLikedProducts($user);

        return view('pages.profile', ['products' => $products, 'user' => $user, 'ownPage' => $ownPage, 'tab' => 'likes']);
    }

    public static function getPurchases(User $user)
    {
        $purchases = $user->orders()->get()->groupBy('purchase')->sortByDesc(function ($orders, $key) {
            return Purchase::where('id', $key)->get()->first()->creation_date;
        });

        return $purchases;
    }

    public function historyProducts(Request $request)
    {
        $user = null;
        $ownPage = false;
        if ($request->route('id') === 'me') {
            $user = $request->user();
            $ownPage = true;
        } else {
            $user = User::where('id', $request->route('id'))->get()->first();
        }
        if ($user->id !== $request->user()->id) {
            return redirect('/', 403);
        }
        $purchases = ProfileController::getPurchases($user);

        return view('pages.purchaseHistory', ['purchases' => $purchases, 'user' => $user, 'ownPage' => $ownPage, 'tab' => 'history']);
    }

    public function reviews(Request $request)
    {
        $user = null;
        $ownPage = false;
        if ($request->route('id') === 'me') {
            $user = $request->user();
            $ownPage = true;
        } else {
            $user = User::where('id', $request->route('id'))->get()->first();
        }
        $reviews = [];
        $reviews = $user->reviewed;

        return view('pages.reviews', ['reviews' => $reviews, 'user' => $user, 'ownPage' => $ownPage, 'tab' => 'reviews']);
    }
}
