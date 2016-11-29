<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->text('access_token');
            $table->string('store_name', 300);
            $table->text('client_store_url')->nullable();
            $table->text('client_store_api_key')->nullable();
            $table->text('client_store_password')->nullable();
            $table->string('app_charge_id', 127)->nullable();
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
        Schema::drop('store_settings');
    }
}
