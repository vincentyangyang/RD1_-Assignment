<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRainfallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rainfalls', function (Blueprint $table) {
            $table->increments("rId")->unique();
            $table->string("city");
            $table->string("station");
            $table->string("hour");
            $table->string("day");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rainfalls');
    }
}
