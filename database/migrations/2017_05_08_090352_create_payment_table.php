<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments_table', function (Blueprint $table) {
            $table->increments('or_no');
            $table->string('stud_id');
            $table->string('academic_year');
            $table->float('total', 8, 2);
            $table->float('balance', 8, 2);
            $table->string('semester');
            $table->string('cashier');
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
        Schema::dropIfExists('payments_table');
    }
}
