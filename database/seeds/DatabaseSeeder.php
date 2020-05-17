<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Email;
use App\Models\Comment;
use App\Models\ResponseComment;
use App\Models\DislikeComment;
use App\Models\LikeComment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 20)->create()->each(function ($item, $key) {
            $item->email()->save(factory(Email::class)->make());
        });

        $this->call(CategorySeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(ProductInfoSeeder::class);
        $this->call(FilterGroupSeeder::class);
        $this->call(FilterValueSeeder::class);
        $this->call(FilterProductSeeder::class);
        $this->call(CurrencySeeder::class);


        factory(Comment::class, 2000)->create()->each(function ($item, $key) {
            if (($key % 2) == 0) {
                $item->responseComment()->save(factory(ResponseComment::class)->make());
            }
        });


        $this->call(DislikeCommentSeeder::class);
        $this->call(LikeCommentSeeder::class);
    }
}
