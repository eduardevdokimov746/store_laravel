<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\ProductScope;

class Product extends Model
{
    protected $fillable = ['title', 'category_id', 'slug', 'price', 'old_price', 'img', 'hit', 'is_published', 'new'];

    protected static function booted()
    {
        static::addGlobalScope(new ProductScope);
    }

    public function getImagePathAttribute()
    {
        return 'storage/images/' . $this->img;
    }

    public function getDiscountAttribute()
    {
        if ($this->attributes['old_price'] > 0) {
            return round((($this->old_price - $this->price) * 100) / $this->old_price);
        } else {
            return 0;
        }
    }

    public function info()
    {
        return $this->hasOne(ProductInfo::class, 'product_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
