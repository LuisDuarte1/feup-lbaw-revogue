<?php

// AbstractFilter.php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class AbstractFilter
{
    protected $request;

    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function filter(Builder $builder)
    {
        //dd($this->getFilters());
        foreach ($this->getFilters() as $filter => $value) {

            $this->resolveFilter($filter)->filter($builder, $value);
        }

        //dd($builder->toSql(), $builder->getBindings());

        return $builder;
    }

    protected function getFilters()
    {
        //dd($this->request->all());

        return array_filter($this->request->only(array_keys($this->filters)));
    }

    protected function resolveFilter($filter)
    {
        return new $this->filters[$filter];
    }
}
