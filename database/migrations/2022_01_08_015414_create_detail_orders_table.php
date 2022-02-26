<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_orders', function (Blueprint $table) {
            $table->bigIncrements('id_detail_orders');
            $table->unsignedBigInteger('id_orders');
            $table->unsignedBigInteger('id_product');
            $table->integer('qty');
            $table->integer('subtotal');

            $table->foreign('id_orders')->references('id_orders')->on('orders');
            $table->foreign('id_product')->references('id_product')->on('product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_orders');
    }
}
