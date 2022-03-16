<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  Schema::enableForeignKeyConstraints();
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('department_id')->unsigned(); 
            $table->string('name');
            $table->string('contact');
            $table->string('designation');
            $table->string('Email');
            $table->string('city');
            $table->string('gender');
            $table->string('cnic');
            $table->string('address');
            $table->string('status');
            $table->string('marital_status');
            $table->string('salary');
            $table->string('income_tax');
            $table->string('pic');
            $table->timestamps();
        });
         Schema::table('employees', function($table) {
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade')->onUpdate('cascade');
     });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
