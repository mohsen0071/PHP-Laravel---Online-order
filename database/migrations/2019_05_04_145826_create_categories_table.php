<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parent_id')->unsigned()->nullable()->index();
            $table->string('name', 128);
            $table->text('description')->nullable();
            $table->text('images')->nullable();
            $table->integer('lft')->unsigned()->nullable()->index();
            $table->integer('rgt')->unsigned()->nullable()->index();
            $table->integer('depth')->unsigned()->nullable();
            $table->integer('sheet_count');
            $table->boolean('status')->default(1);
            $table->integer('pservice_unit');
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
        Schema::dropIfExists('categories');
    }
}
