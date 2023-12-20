<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class CategoryFilter
{
    public function filter(Builder $builder, $value)
    {
        $builder->join('Categories', 'products.id', '=', 'Categories.id');

        foreach ($value as $Category => $valor) {

            $builder->where('Categories.key', $Category)
                ->where('Categories.name', $valor);
        }

        //dd($builder->toSql(), $builder->getBindings());

        return $builder;
    }
}
