<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInfo extends Model
{
    protected $table = 'product_info';
    public $timestamps = false;

    public function parentProduct()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
