<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'currency_id', 'status', 'addr', 'notice', 'sum', 'count_product', 'confirmed_at'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
}
