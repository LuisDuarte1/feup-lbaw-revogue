<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class CategoryFilter
{
    public function filter(Builder $builder, $value)
    {
        $builder->where('category', $value);

        //dd($builder->toSql(), $builder->getBindings());

        return $builder;
    }
}
