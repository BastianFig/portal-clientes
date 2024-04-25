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
        Schema::table('fasedespachos', function (Blueprint $table) {
            $table->boolean('distribucion')->nullable();
            $table->boolean('armado')->nullable();
            $table->boolean('entrega_conforme')->nullable();
            $table->boolean('carguio')->nullable();
            $table->boolean('transporte')->nullable();
            $table->boolean('entrega')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fasedespachos', function (Blueprint $table) {
            $table->boolean('distribucion')->nullable();
            $table->boolean('armado')->nullable();
            $table->boolean('entrega_conforme')->nullable();
            $table->boolean('carguio')->nullable();
            $table->boolean('transporte')->nullable();
            $table->boolean('entrega')->nullable();
        });
    }
};
