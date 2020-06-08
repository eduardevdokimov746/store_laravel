<?php

namespace App\Services;

use App\Models\Comment as ModelComment;
use App\Models\DislikeComment;
use App\Models\LikeComment;

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
}