<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 200);
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('RESTRICT');
            $table->text('body')->nullable();
            $table->text('images')->nullable();
            $table->text('allfiles')->nullable();
            $table->boolean('status')->default(1);
            $table->string('price', 20);
            $table->string('partner_price', 20)->nullable();
            $table->integer('unit');
            $table->string('delivery_time')->nullable();
            $table->boolean('urgent_status')->default(0);
            $table->string('urgent_price', 20)->nullable();
            $table->string('partner_urgent_price', 20)->nullable();
            $table->string('delivery_urgent_time')->nullable();
            $table->string('length',5);
            $table->string('max_length',5);
            $table->string('width',5);
            $table->string('max_width',5);
            $table->timestamps();
        });


        Schema::create('product_pservice', function (Blueprint $table) {

            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->bigInteger('pservice_id')->unsigned();
            $table->foreign('pservice_id')->references('id')->on('pservices')->onDelete('cascade');

            $table->primary(['pservice_id','product_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_pservice');
    }
}
