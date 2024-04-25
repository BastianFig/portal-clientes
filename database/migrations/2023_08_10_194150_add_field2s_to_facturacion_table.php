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
        Schema::table('facturacion', function (Blueprint $table) {
            $table->string('direccion_despacho')->nullable();
            $table->string('nombre_despacho')->nullable();
            $table->string('telefono_despacho')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facturacion', function (Blueprint $table) {
            $table->string('direccion_despacho')->nullable();
            $table->string('nombre_despacho')->nullable();
            $table->string('telefono_despacho')->nullable();
        });
    }
};
