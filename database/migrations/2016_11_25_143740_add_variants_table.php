<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sku')->nullable();
            $table->integer('grams');
            $table->string('inventory_tracker')->nullable();
            $table->string('inventory_policy')->nullable();
            $table->integer('inventory_qty');
            $table->string('fulfilment_service')->nullable();
            $table->double('price');
            $table->double('compare_at_price');
            $table->boolean('require_shipment');
            $table->boolean('taxable');
            $table->text('barcode');
            $table->text('image');
            $table->string('weight_unit');
            $table->string('tax_code');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('variants');
    }
}
