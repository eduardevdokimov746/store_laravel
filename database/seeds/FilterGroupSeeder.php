<?php

use Illuminate\Database\Seeder;

class FilterGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = include(database_path('dump/filter_groupData.php'));
        DB::statement($sql);
    }
}
