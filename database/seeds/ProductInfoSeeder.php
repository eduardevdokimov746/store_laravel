<?php

use Illuminate\Database\Seeder;

class ProductInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = include(database_path('dump/product_infoData.php'));


        foreach ($sql as $item) {
            DB::statement($item);
        }
    }
}
