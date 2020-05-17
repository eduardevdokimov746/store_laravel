<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    public function products()
    {
        return $this->hasMany(WishlistProduct::class, 'product_id', 'id');
    }
}
