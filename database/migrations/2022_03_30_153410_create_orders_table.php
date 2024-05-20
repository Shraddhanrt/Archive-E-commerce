<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('buyer_fname');
            $table->string('buyer_lname');
            $table->text('buyer_address');
            $table->text('buyer_address1');
            $table->string('buyer_country');
            $table->string('buyer_state');
            $table->string('buyer_city');
            $table->string('buyer_postal_code');
            $table->string('buyer_mobile');
            $table->string('receiver_fname');
            $table->string('receiver_lname');
            $table->text('receiver_address');
            $table->text('receiver_address1');
            $table->string('receiver_country');
            $table->string('receiver_state');
            $table->string('receiver_city');
            $table->string('receiver_postal_code');
            $table->string('receiver_mobile');
            $table->string('code');
            $table->integer('producttotalcost');
            $table->integer('tax');
            $table->integer('shippingcost');
            $table->integer('grandtotal');
            $table->string('shippingcompany');
            $table->string('shippingcompanylogo');
            $table->string('delivery_range');
            $table->string('paymentmethod');
            $table->string('paymentstatus');
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
        Schema::dropIfExists('orders');
    }
};
