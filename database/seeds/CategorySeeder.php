<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = include(database_path('dump/categoryData.php'));
        DB::statement($sql);
    }
}
