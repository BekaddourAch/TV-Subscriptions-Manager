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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id('id_subscription');
            $table->bigInteger("id_service")->unsigned(); 
            $table->bigInteger("id_customer")->unsigned(); 
            $table->bigInteger("id_user")->unsigned();  
            $table->decimal('cost_price', 6, 2);
            $table->integer('quantity');
            $table->decimal('selling_price', 6, 2);
            $table->date('begin_date');
            $table->date('end_date');
            $table->decimal('total', 6, 2);  
            $table->timestamps();
        });
            
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreign('id_service')->references('id_service')->on('services');
        });
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreign('id_customer')->references('id_customer')->on('customers');
        });
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
};
