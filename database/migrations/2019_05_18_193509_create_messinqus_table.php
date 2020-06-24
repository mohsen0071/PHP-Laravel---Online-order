<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessinqusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messinqus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pinquiry_id')->unsigned();
            $table->foreign('pinquiry_id')->references('id')->on('pinquiries')->onDelete('RESTRICT');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->text('body');
            $table->string('range', 10)->nullable();
            $table->integer('length')->nullable();
            $table->integer('width')->nullable();
            $table->text('images')->nullable();
            $table->string('price')->nullable();
            $table->string('deposit')->nullable();
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
        Schema::dropIfExists('messinqus');
    }
}
