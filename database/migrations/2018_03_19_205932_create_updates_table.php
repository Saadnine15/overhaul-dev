<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('updates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('update_id');
            $table->string('sku');
            $table->integer('old_qty')->nullable();
            $table->integer('new_qty')->nullable();
            $table->double('old_price')->nullable();
            $table->double('new_price')->nullable();
            $table->double('old_compare_at_price')->nullable();
            $table->double('new_compare_at_price')->nullable();
            $table->timestamps();
            $table->softDeletes(); // <-- This will add a deleted_at field
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
