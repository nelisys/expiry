<?php

namespace App\Http\Filters;

class ProductFilter extends Filter
{
    protected function name($name)
    {
        return $this->builder->where('name', 'LIKE', "%{$name}%");
    }
}
