<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;
use App\Product;

class ProductPolicy
{
    use HandlesAuthorization;

    public function access(User $user, Product $product)
    {
        return $product->user_id == $user->id;
    }
}
