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
        Schema::create('variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('variant_id');
            $table->bigInteger('product_id');
            $table->string('sku')->nullable();
            $table->double('grams')->nullable();
            $table->double('weight')->nullable();
            //$table->string('inventory_tracker')->nullable();
            //$table->string('inventory_policy')->nullable();
            $table->integer('inventory_qty');
            //$table->string('fulfilment_service')->nullable();
            $table->double('price')->nullable();
            $table->double('compare_at_price')->nullable();
            //$table->boolean('require_shipment');
            //$table->boolean('taxable');
            //$table->text('barcode');
            //$table->text('image');
            //$table->string('weight_unit')->nullable();
            //$table->string('tax_code')->nullable();

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
