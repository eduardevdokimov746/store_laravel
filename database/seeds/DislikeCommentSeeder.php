<?php

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\User;

class DislikeCommentSeeder extends Seeder
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
            \DB::insert('INSERT INTO dislikes_comments (user_id, comment_id) VALUES (?, ?)', [$user_id, $item->id]);
        });
    }
}
