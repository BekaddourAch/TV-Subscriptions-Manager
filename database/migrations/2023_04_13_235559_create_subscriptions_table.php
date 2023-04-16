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
            $table->bigInteger("id_service")->unsigned()->nullable(); 
            $table->bigInteger("id_customer")->unsigned()->nullable(); 
            $table->bigInteger("id_user")->unsigned()->nullable();  
            $table->decimal('cost_price', 9, 2);
            $table->integer('quantity');
            $table->decimal('selling_price', 9, 2);
            $table->date('begin_date');
            $table->date('end_date');
            $table->decimal('total', 9, 2);  
            $table->text('notes')->nullable();
            $table->timestamps();
        });
            
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreign('id_service')->references('id_service')->on('services')->onDelete('set null');
        });
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreign('id_customer')->references('id_customer')->on('customers')->onDelete('set null');
        });
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null');;
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
