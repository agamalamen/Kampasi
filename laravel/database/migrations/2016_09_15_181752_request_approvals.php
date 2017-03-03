<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RequestApprovals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('off_campus_requests', function ($table){
      $table->string('driver_approval')->default('waiting');
      $table->string('student_life_approval')->default('waiting');
      $table->string('security_approval')->default('waiting');
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
