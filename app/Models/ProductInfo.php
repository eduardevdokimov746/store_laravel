<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInfo extends Model
{
    protected $table = 'product_info';
    public $timestamps = false;
    protected $fillable = ['hrefs_img', 'little_specifications', 'big_specifications', 'product_id'];
    protected $primaryKey = 'product_id';

    public function parentProduct()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
