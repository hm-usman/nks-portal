<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasktablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::enableForeignKeyConstraints();
           Schema::create('tasktables', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id')->unsigned(); 
            $table->bigInteger('project_id')->unsigned();
            $table->string('status');  
            $table->string('tittle');
            $table->string('link');  
            $table->string('description');
            $table->integer('performance');  
            $table->integer('calculatedpreformance');
            $table->string('starting_date');
            $table->string('deadline');
            $table->string('submitted_date');
            $table->timestamps();
        });
        Schema::table('tasktables', function($table) {
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
        Schema::dropIfExists('tasktables');
    }
}
