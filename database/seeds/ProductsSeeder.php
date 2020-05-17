<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = include(database_path('dump/productData.php'));
        foreach ($sql as $item) {
            DB::statement($item);
        }


    }
}
