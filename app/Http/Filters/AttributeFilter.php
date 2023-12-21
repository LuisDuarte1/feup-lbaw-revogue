<?php

// SizeFilter.php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class AttributeFilter
{
    public function filter(Builder $builder, $value)
    {
        foreach ($value as $attribute => $valor) {
            $builder->whereHas('attributes', function ($query) use ($attribute, $valor) {
                $query->where('key', $attribute)
                    ->where('value', $valor);
            });
        }

        //dd($builder->toSql(), $builder->getBindings());

        return $builder;
    }
}
