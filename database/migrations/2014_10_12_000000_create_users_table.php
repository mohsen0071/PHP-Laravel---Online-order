<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username', 64)->nullable();
            $table->string('level')->default('user');
            $table->smallInteger('user_type')->default('1');
            $table->string('name')->nullable();
            $table->string('company')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->char('mobile', 11)->unique();
            $table->char('tel', 11)->nullable();
            $table->char('national_code', 10)->nullable();
            $table->char('postal_code', 10)->nullable();
            $table->string('address', 128)->nullable();
            $table->integer('province_id')->unsigned()->nullable();
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('RESTRICT');
            $table->integer('city_id')->unsigned()->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('RESTRICT');
            $table->text('images')->nullable();
            $table->boolean('status')->default(true);
            $table->decimal('balance', 12)->default(0.00);
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
