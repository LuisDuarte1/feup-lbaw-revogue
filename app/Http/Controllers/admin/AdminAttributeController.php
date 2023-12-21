<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AdminAttributeController extends Controller
{
    function getPage(Request $request){

        $attributes = Attribute::orderBy('key')->paginate(20);
        return view('pages.admin.attributes', ['attributes' => $attributes]);
    }

    function createAttribute(Request $request){
        $request->validate([
            'attribute_key' => 'required|max:30',
            'attribute_value' => 'required|max:50'
        ]);

        Attribute::create([
            'key' => $request->attribute_key,
            'value' => $request->attribute_value
        ]);

        return redirect('/admin/attributes');
    }

    function removeAttribute(Request $request){
        $attributeId = $request->input('id');

        $attribute = Attribute::find($attributeId);

        $attribute->delete();

        return redirect('/admin/attributes');
    }
}
