<?php

namespace App\Extensions;

use App\Models\Comment;

class CommentExtension
{

    /**
     * Get new rating product
     *
     * @return float
     */
    public static function getNewRating($product_id, $rating)
    {
        $data = Comment::selectRaw('SUM(`rating`) as sum, COUNT(`rating`) as count')->where('product_id', $product_id)->first();

        return ($data->sum + $rating) / ++$data->count;
    }

    public static function addComment()
    {

    }
}
