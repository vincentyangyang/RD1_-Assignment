<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwodaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twodays', function (Blueprint $table) {
            $table->increments("tId")->unique();
            $table->string("city");
            $table->string("one");
            $table->string("two");
            $table->string("three");
            $table->string("four");
            $table->string("five");
            $table->string("six");
            $table->string("seven");
            $table->string("eight");
            $table->string("nine");
            $table->string("ten");
            $table->string("eleven");
            $table->string("twelve");
            $table->string("thirteen");
            $table->string("fourteen");
            $table->string("fifteen");
            $table->string("sixteen");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('twodays');
    }
}
