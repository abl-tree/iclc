<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Payment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('payment'))
        Schema::create('payment', function(Blueprint $table){
            $table->increments('id');
            $table->string('invoice_number');
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('student');
            $table->decimal('total_amount', 9, 2)->unsigned();
            $table->integer('cashier_id')->unsigned();
            $table->foreign('cashier_id')->references('user_id')->on('cashier_profile');
            $table->integer('sy_id')->unsigned();
            $table->foreign('sy_id')->references('id')->on('school_year');
            $table->integer('semester_id')->unsigned();
            $table->foreign('semester_id')->references('id')->on('semester');
            $table->timestamp('created_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment');
    }
}
