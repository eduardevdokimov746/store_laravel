<?php

namespace App\Services;

use App\Models\Comment as ModelComment;
use App\Models\DislikeComment;
use App\Models\LikeComment;
use App\Extensions\CommentExtension;
use Illuminate\Http\Request;
use App\Models\ProductInfo;

class Comment
{
	protected $user_id;
	protected $comment_id;

	public function __construct($user_id, $comment_id)
	{
		$this->user_id = $user_id;
		$this->comment_id = $comment_id;
	}

	public function like()
	{
		LikeComment::create($this->getData());

		if ($this->checkDislike()) {
			$this->decrementDislike();
		}
	}

	public function decrementLike()
	{
		LikeComment::where('user_id', $this->user_id)->where('comment_id', $this->comment_id)->delete();
	}

	public function decrementDislike()
	{
		DislikeComment::where('user_id', $this->user_id)->where('comment_id', $this->comment_id)->delete();
	}

	protected function getData()
	{
		return [
			'user_id' => $this->user_id,
			'comment_id' => $this->comment_id
		];
	}

	public function dislike()
	{
		DislikeComment::create($this->getData());

		if ($this->checkLike()) {
			$this->decrementLike();
		}
	}

	public function checkLike()
	{
		return LikeComment::where('user_id', $this->user_id)->where('comment_id', $this->comment_id)->exists();
	}

	public function checkDislike()
	{
		return DislikeComment::where('user_id', $this->user_id)->where('comment_id', $this->comment_id)->exists();
	}

	public static function add(Request $request)
    {
        $rating = 0;

        $data = self::getRequest($request);

        if ($data['rating'] > 0) {
            $rating = CommentExtension::getNewRating($request->get('product_id'), $request->get('rating'));
            self::updateRatingProduct($data['product_id'], $rating);
        }

        $create_data = self::getCreateData($data);

        return ModelComment::create($create_data);
    }

    protected static function getCreateData($old_data)
    {
        $new_data = [
            'user_id' => \Auth::id()
        ];

        return array_merge($old_data, $new_data);
    }

    protected static function updateRatingProduct($product_id, $rating)
    {
        $sql = 'UPDATE `product_info` SET `rating`=:rating, `count_comment`=`count_comment` + 1 WHERE `product_id`=:product_id';
        $data = ['rating' => $rating, 'product_id' => $product_id];
        return \DB::update($sql, $data);
    }

    protected static function getRequest(Request $request)
    {
        $select = [
            'good_comment',
            'bad_comment',
            'comment',
            'is_notifiable',
            'product_id',
            'type',
            'rating'
        ];

        return $request->only($select);
    }
}
