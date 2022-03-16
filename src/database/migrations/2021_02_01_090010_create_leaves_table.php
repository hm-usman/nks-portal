<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
  
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id')->unsigned(); 
            $table->string('tittle'); 
            $table->string('Description'); 
            $table->string('To');
            $table->string('From');
            $table->string('status');
            $table->timestamps();
        });
          Schema::table('leaves', function($table) {
         $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade')->onUpdate('cascade');
     });
    }

    public function down()
    {
        Schema::dropIfExists('leaves');
    }
}
