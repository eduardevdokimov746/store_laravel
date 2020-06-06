<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = ['user_id', 'title', 'type_def'];
    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(WishlistProduct::class, 'wishlist_id', 'id');
    }
}
