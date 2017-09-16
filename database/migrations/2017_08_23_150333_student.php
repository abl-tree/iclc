<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Student extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('student'))
        Schema::create('student', function(Blueprint $table){
            $table->increments('id');
            $table->string('student_number')->unique();
            $table->string('name');
            $table->string('gender')->nullable();
            $table->integer('year');
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('course');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student');
    }
}
