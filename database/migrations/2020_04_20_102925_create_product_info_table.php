<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_info', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->text('hrefs_img')->nullable();
            $table->text('little_specifications')->nullable();
            $table->text('big_specifications')->nullable();
            $table->text('description')->nullable();
            $table->float('rating')->default(0);
            $table->unsignedInteger('count_comment')->default(0);
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_info');
    }
}
