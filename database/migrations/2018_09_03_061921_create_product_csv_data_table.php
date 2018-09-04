<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCsvDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_csv_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imei');
            $table->string('productcode');
            $table->string('invoiceno');
            $table->string('palletid');
            $table->string('boxid');
            $table->string('description');
            $table->string('model');
            $table->string('storage');
            $table->string('color');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_csv_data');
    }
}
