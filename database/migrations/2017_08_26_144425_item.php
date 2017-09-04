<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Item extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('item'))
        Schema::create('item', function(Blueprint $table){
            $table->increments('id');
            $table->string('description');
            $table->integer('option');
            $table->decimal('amount', 9, 2);
            $table->integer('department_id')->unsigned();
            $table->foreign('department_id')->references('id')->on('department');
            $table->integer('sy_id')->unsigned();
            $table->foreign('sy_id')->references('id')->on('school_year');
            $table->integer('semester_id')->unsigned();
            $table->foreign('semester_id')->references('id')->on('semester');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item');
    }
}
