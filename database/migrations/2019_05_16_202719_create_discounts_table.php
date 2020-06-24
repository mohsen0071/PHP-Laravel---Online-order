<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('amount_type');
            $table->string('amount');
            $table->string('minAmount')->nullable()->default(0);
            $table->string('maxAmount')->nullable()->default(0);
            $table->smallInteger('type');
            $table->string('limit_used')->nullable();
            $table->string('expireDate')->nullable();
            $table->text('client_group')->nullable();
            $table->text('product_group')->nullable();
            $table->boolean('status');
            $table->text('body')->nullable();
            $table->timestamps();
        });

        Schema::create('discount_user', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT');

            $table->bigInteger('discount_id')->unsigned();
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('RESTRICT');

            $table->primary(['user_id' , 'discount_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}
