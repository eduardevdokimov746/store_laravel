<?php

use Illuminate\Database\Seeder;

class FilterProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = include(database_path('dump/filter_productData.php'));
        DB::statement($sql);
    }
}
