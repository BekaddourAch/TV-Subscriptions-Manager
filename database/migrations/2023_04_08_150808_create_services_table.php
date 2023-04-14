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
        Schema::create('services', function (Blueprint $table) {
            $table->id('id_service');
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->decimal('cost_price');
            $table->decimal('selling_price');
            $table->integer('duration_unit')->default(1);
            $table->integer('duration')->default(1);
            $table->boolean('active')->default('0');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('services');
    }
};
