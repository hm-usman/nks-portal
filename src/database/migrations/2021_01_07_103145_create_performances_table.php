<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::enableForeignKeyConstraints();
       Schema::create('performances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id')->unsigned(); 
            $table->bigInteger('team_id')->unsigned();
            $table->bigInteger('task_id')->unsigned();
            $table->bigInteger('attendence_id')->unsigned();
            $table->integer('performance'); 
            $table->bigInteger('tasks_completed');
            $table->timestamps();
        });
        Schema::table('performances', function($table) {
         $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade')->onUpdate('cascade');
         $table->foreign('task_id')->references('id')->on('tasktables')->onDelete('cascade')->onUpdate('cascade');
         $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade')->onUpdate('cascade');
         $table->foreign('attendence_id')->references('id')->on('attendences')->onDelete('cascade')->onUpdate('cascade');
     });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('performances');
    }
}
