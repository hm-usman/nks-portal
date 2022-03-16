<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::enableForeignKeyConstraints();
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id')->unsigned(); 
            $table->bigInteger('project_id')->unsigned(); 
            $table->timestamps();
        });
           Schema::table('teams', function($table) {
       $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade')->onUpdate('cascade');
        $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
   });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
