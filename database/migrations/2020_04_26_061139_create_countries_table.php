<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Helper\CustomBlueprint;

class CreateCountriesTable extends Migration
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
        $schema->create('countries', function (CustomBlueprint $table) {
            $table->id();
            $table->integer('name')->nullable()->unsigned();
            $table->string('code',100)->nullable();
            $table->string('code_a3',100)->nullable();
            $table->string('code_n3',200)->nullable();
            $table->text('lat')->nullable();
            $table->tinyInteger('lot')->nullable();
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
        Schema::dropIfExists('countries');
    }
}
