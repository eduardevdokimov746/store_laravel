<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilterValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_value', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->text('value');
            $table->foreign('group_id')
                ->references('id')
                ->on('filter_group');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filter_value');
    }
}
