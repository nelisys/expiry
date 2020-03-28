<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\ProductFilter;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'expiry_date',
    ];

    public function scopeFilter($builder, ProductFilter $filter)
    {
        return $filter->apply($builder);
    }
}
