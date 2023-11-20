<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * getAttributeValues
     *
     * @param  string  $key
     * @return array
     */
    public static function getAttributeValues($key)
    {
        return Attribute::select('value')->where('key', $key)->get()->pluck('value');
    }

    public static function getAllAtributes()
    {
        return Attribute::select('key')->get()->unique('key')->pluck('key');
    }

    public function getValues(Request $request)
    {
        $key = $request->query('q');
        if ($key === null) {
            $attrs = AttributeController::getAllAtributes();

            return response()->json(['attributes' => $attrs]);
        } else {
            $values = AttributeController::getAttributeValues($key);

            return response()->json(['values' => $values]);
        }
    }
}
