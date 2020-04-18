<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Http\Helper\CustomBlueprint;
use Illuminate\Support\Facades\DB;
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
        $schema = DB::connection()->getSchemaBuilder();

        $schema->blueprintResolver(function ($table, $callback) {
            return new CustomBlueprint($table, $callback);
        });

        $schema->create('users', function (CustomBlueprint $table) {
            $table->id();
            $table->tinyInteger('userType')->nullable()->unsigned();
            $table->string('userName')->unique()->nullable();
            $table->string('password');
            $table->string('email')->unique()->nullable();
            $table->string('firstName',100)->nullable();
            $table->string('lastName',100)->nullable();
            $table->text('address')->nullable();
            $table->string('city',100)->nullable();
            $table->integer('businessType')->nullable()->unsigned();
            $table->string('state',100)->nullable();
            $table->mediumText('verificationToken')->nullable();
            $table->tinyInteger('isVerified')->nullable()->unsigned();
            $table->string('zipCode',100)->nullable();
            $table->string('phone',100)->unique()->nullable();

            $table->commonFields();
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
