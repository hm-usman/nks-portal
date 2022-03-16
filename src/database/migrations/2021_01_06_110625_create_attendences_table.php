<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::enableForeignKeyConstraints();
        Schema::create('attendences', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id')->unsigned(); 
            $table->string('status');
            $table->string('behaviour');
            $table->string('endingtime');
            $table->string('performance');
            $table->timestamps();
        });
        Schema::table('attendences', function($table) {
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade')->onUpdate('cascade');
     });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendences');
    }
}
