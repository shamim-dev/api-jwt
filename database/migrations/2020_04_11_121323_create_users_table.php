<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('id');
            $table->tinyInteger('userType')->nullable()->unsigned();
            $table->string('userName');
            $table->string('password');
            $table->string('email')->unique();
            $table->string('firstName',100)->nullable();
            $table->string('lastName',100)->nullable();
            $table->string('address',256)->nullable();
            $table->string('city',100)->nullable();
            $table->integer('businessType')->nullable()->unsigned();
            $table->string('state',100)->nullable();
            $table->tinyInteger('is_verified')->nullable()->unsigned();
            $table->string('zipCode',100)->nullable();
            $table->string('phone',100)->nullable();
            $table->string('status',100)->nullable();
            $table->integer('created_by')->nullable()->unsigned();
            $table->integer('updated_by')->nullable()->unsigned();

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
