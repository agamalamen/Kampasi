<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetailsElections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('elections', function ($table){
      $table->string('intro');
      $table->string('what'); //what are you going to contribute to the school
      $table->string('why'); //why do you want to contribute
      $table->string('how'); //how being in this position will help you contribute
      $table->string('slogan');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
