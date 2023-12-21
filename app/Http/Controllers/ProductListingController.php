<?php

namespace App\Http\Controllers;

use App\Http\Controllers\api\AttributeController;
use App\Http\Requests\ProductListingForm;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductListingController extends Controller
{
    public function getPage()
    {
        return view('pages.productListing', [
            'colors' => AttributeController::getAttributeValues('Color'),
            'sizes' => AttributeController::getAttributeValues('Size'),
            'categories' => Category::all(),
        ]);
    }

    public function addProduct(ProductListingForm $request)
    {

        $validated = collect($request->validated());
        $image_paths = [];

        $images = $request->file('imageToUpload');
        if (! is_array($images)) {
            $images = [$images];
        }

        foreach ($images as $image) {
            $filename = '/storage/'.$image->storePublicly('product-images', ['disk' => 'public']);
            array_push($image_paths, $filename);
        }
        DB::beginTransaction();

        $product = $request->user()->products()->create([
            'slug' => 'bloat',
            'name' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'image_paths' => $image_paths,
        ]);

        $product->productCategory()->associate($request->category);

        $product->update([
            'slug' => $product->id.'-'.Str::slug($request->title),
        ]);
        foreach ($request->input('attributes') as $key => $value) {
            $attr = Attribute::where('key', $key)->where('value', $value)->get();
            $product->attributes()->save($attr[0]);
        }
        $attr = Attribute::where('key', 'Size')->where('value', $request->size)->get();
        $product->attributes()->save($attr[0]);
        $attr = Attribute::where('key', 'Color')->where('value', $request->color)->get();
        $product->attributes()->save($attr[0]);
        DB::commit();

        //TODO (luisd): use named routed
        return redirect('/products/'.$product->id);
    }
}
