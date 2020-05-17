<?php

use Illuminate\Database\Seeder;

class FilterValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = include(database_path('dump/filter_valueData.php'));
        DB::statement($sql);
    }
}
