<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PartialRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('optional_records', function (Blueprint $table) {
            $table->increments('or_no');
            $table->string('stud_id');
            $table->string('academic_year');
            $table->string('account');
            $table->string('semester');
            $table->char('size')->nullable();
            $table->float('total', 8, 2);
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
        Schema::dropIfExists('optional_records');
    }
}
