<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public static function search_products($searchTerm, $perPage = 20)
    {
        return Product::whereHas('orders', function ($q) {
            $q->where('status', 'cancelled');
        })->doesntHave('orders', 'or')->whereRaw('(fts_search @@ plainto_tsquery(\'english\', ?) OR name = ?)', [$searchTerm, $searchTerm])
            ->orderByRaw('ts_rank(fts_search, plainto_tsquery(\'english\', ?)) DESC', [$searchTerm])->filter(request())->paginate($perPage);
        // n sei se aqui o request() ta certo
    }

    public function searchGet(Request $request)
    {
        if ($request->query('q') === null) {
            return view('pages.search', ['products' => []]);
        }
        $products = SearchController::search_products($request->query('q'))->withQueryString();
        $list = [];
        foreach ($products as $product) {
            $attributes = $product->attributes()->get();
            $size = null;
            foreach ($attributes as $attribute) {
                if ($attribute->key == 'Size') {
                    $size = $attribute->value;
                }
            }
            array_push($list, ['product' => $product, 'size' => $size]);
        }

        return view('pages.search', ['products' => $list]);
    }

    public function searchGetApi(Request $request)
    {
        if ($request->query('q') === null) {
            return response()->json(['error' => 'cursor not defined or queue not defined'], 400);
        }
        $products = SearchController::search_products($request->query('q'))->withQueryString();
        $list = [];
        foreach ($products as $product) {
            $attributes = $product->attributes()->get();
            $size = null;
            foreach ($attributes as $attribute) {
                if ($attribute->key == 'Size') {
                    $size = $attribute->value;
                }
            }
            array_push($list, ['product' => $product, 'size' => $size]);
        }

        return view('api.search', ['products' => $list, 'cursor' => $products]);
    }
}
