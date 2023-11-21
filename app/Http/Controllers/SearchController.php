<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class SearchController extends Controller
{
    static function search_products($searchTerm, $perPage=20){
        return Product::whereRaw('(fts_search @@ plainto_tsquery(\'english\', ?) OR name = ?)', [$searchTerm, $searchTerm])
                ->orderByRaw('ts_rank(fts_search, plainto_tsquery(\'english\', ?)) DESC', [$searchTerm])->paginate($perPage);

    }

    function searchGet(Request $request){
        if($request->query('q') === null){
            return view('pages.search', ['products' => []]);
        }
        $products = SearchController::search_products($request->query('q'))->withQueryString();
        $list = [];
        foreach($products as $product){
            $attributes = $product->attributes()->get();
            $size = null;
            foreach($attributes as $attribute){
                if($attribute->key == "Size"){
                    $size = $attribute->value;
                }
            }
            array_push($list, ["product"=>$product, "size"=>$size]);
        }
        return view('pages.search', ['products' => $list]);
    }

    function searchGetApi(Request $request){
        if($request->query('q') === null){
            return response()->json(["error" => "cursor not defined or queue not defined"], 400);
        }
        $products = SearchController::search_products($request->query('q'))->withQueryString();
        $list = [];
        foreach($products as $product){
            $attributes = $product->attributes()->get();
            $size = null;
            foreach($attributes as $attribute){
                if($attribute->key == "Size"){
                    $size = $attribute->value;
                }
            }
            array_push($list, ["product"=>$product, "size"=>$size]);
        }
        return view('api.search', ['products' => $list, 'cursor' => $products]);
    }
}
