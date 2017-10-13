<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaymentItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('payment_item'))
        Schema::create('payment_item', function(Blueprint $table){
            $table->increments('id'); 
            $table->integer('payment_id')->unsigned();
            $table->foreign('payment_id')->references('id')->on('payment')->onDelete('cascade');;
            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('item')->onDelete('cascade');;
            $table->integer('quantity')->unsigned()->default(1);
            $table->string('size')->nullable();
            $table->decimal('amount', 9, 2)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_item');
    }
}
