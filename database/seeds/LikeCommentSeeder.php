<?php

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class LikeCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users_id = User::get()->pluck('id');
        $comments = Comment::inRandomOrder()->take(1000)->get();

        $comments->each(function ($item, $key) use ($users_id){
            $user_id = $users_id->random();

            $checkDislike = \DB::select('SELECT COUNT(*) FROM dislikes_comments WHERE user_id=? AND comment_id=?', [$user_id, $item->id]);
            if ($checkDislike[0]->{"COUNT(*)"} == 0) {
                \DB::insert('INSERT INTO likes_comments (user_id, comment_id) VALUES (?, ?)', [$user_id, $item->id]);
            }
        });
    }
}
