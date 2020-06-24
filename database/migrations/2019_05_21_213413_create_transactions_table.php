<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id',20)->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->bigInteger('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->smallInteger('transaction_type');
            $table->text('body')->nullable();
            $table->smallInteger('payment_type');
            $table->string('price', '20');
            $table->string('deposit', '20')->default(0);
            $table->string('discount', '20')->default(0);
            $table->string('rest_balance', '20');
            $table->smallInteger('bank_type')->nullable();
            $table->smallInteger('payment_way')->nullable();
            $table->string('proof_number',20)->nullable();
            $table->string('pay_date','25')->nullable();

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
        Schema::dropIfExists('transactions');
    }
}
