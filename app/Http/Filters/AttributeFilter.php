<?php

// SizeFilter.php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class AttributeFilter
{
    public function filter(Builder $builder, $value)
    {
        $builder->join('productattributes', 'products.id', '=', 'productattributes.product')
            ->join('attributes', 'productattributes.attribute', '=', 'attributes.id');

        foreach ($value as $attribute => $valor) {

            $builder->where('attributes.key', $attribute)
                ->where('attributes.value', $valor);
        }

        //dd($builder->toSql(), $builder->getBindings());

        return $builder;
    }
}
