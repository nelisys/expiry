<?php

namespace App\Http\Filters;

use Carbon\Carbon;

class ProductFilter extends Filter
{
    protected function name($name)
    {
        return $this->builder->where('name', 'LIKE', "%{$name}%");
    }

    protected function status($status)
    {
        if ($status == 'expired') {
            return $this->builder->whereDate('expiry_date', '<', Carbon::today());
        } elseif ($status == 'today') {
            return $this->builder->whereDate('expiry_date', Carbon::today());
        } elseif ($status == 'future') {
            return $this->builder->whereDate('expiry_date', '>', Carbon::today());
        }
    }
}
