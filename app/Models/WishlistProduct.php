<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishlistProduct extends Model
{
    protected $table = 'wishlists_products';
    protected $fillable = ['wishlist_id', 'product_id'];
    public $timestamps = false;

    public function list()
    {
        return $this->belongsTo(Wishlist::class, 'wishlist_id', 'id');
    }
}
