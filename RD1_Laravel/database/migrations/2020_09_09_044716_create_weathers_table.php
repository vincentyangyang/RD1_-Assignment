<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeathersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weathers', function (Blueprint $table) {
            $table->increments("rId")->unique();
            $table->string("city");
            $table->string("now")->nullable();
            $table->string("firstDay");
            $table->string("secondDay");
            $table->string("thirdDay");
            $table->string("fourthDay");
            $table->string("fifthDay");
            $table->string("sixthDay");
            $table->string("seventhDay");
            $table->string("firstNight");
            $table->string("secondNight");
            $table->string("thirdNight");
            $table->string("fourthNight");
            $table->string("fifthNight");
            $table->string("sixthNight");
            $table->string("seventhNight");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weathers');
    }
}
