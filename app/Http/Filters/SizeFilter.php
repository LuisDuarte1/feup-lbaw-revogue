<?php

// SizeFilter.php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SizeFilter
{
    public function index_product(Request $request, Builder $query)
    {

        if ($request->size) {
            $query->where('size', $request->size);
        }

        return $query;

    }
}
