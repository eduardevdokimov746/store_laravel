<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    public function parentExists($id)
    {
        $result = $this->where('parent_id', $id)->first();

        return !empty($result) ? true : false;
    }
}
