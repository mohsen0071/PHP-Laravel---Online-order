<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 200);
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('RESTRICT');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('RESTRICT');
            $table->string('range', 10);
            $table->string('order_number', 20);
            $table->string('price_design', 20)->nullable();
            $table->text('body')->nullable();
            $table->integer('length')->nullable();
            $table->integer('width')->nullable();
            $table->integer('unit');
            $table->text('images');
            $table->text('pservices')->nullable();
            $table->integer('status_sheets')->default(1);
            $table->integer('status')->default(0);
            $table->boolean('urgent')->default(0);
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->bigInteger('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->bigInteger('sheet_id')->unsigned()->nullable();
            $table->foreign('sheet_id')->references('id')->on('sheets')->onDelete('RESTRICT');
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
        Schema::dropIfExists('orders');
    }
}
