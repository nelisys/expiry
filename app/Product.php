<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\ProductFilter;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'expiry_date',
    ];

    public function scopeFilter($builder, ProductFilter $filter)
    {
        return $filter->apply($builder);
    }
}
