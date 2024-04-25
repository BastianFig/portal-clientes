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
            $table->string('horario')->nullable();
            $table->string('empresa_transporte')->nullable();
            $table->string('nombre_conductor')->nullable();
            $table->string('celular_conductor')->nullable();
            $table->string('nombre_acompañantes')->nullable();
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
            $table->string('horario')->nullable();
            $table->string('empresa_transporte')->nullable();
            $table->string('nombre_conductor')->nullable();
            $table->string('celular_conductor')->nullable();
            $table->string('nombre_acompañantes')->nullable();
        });
    }
};
