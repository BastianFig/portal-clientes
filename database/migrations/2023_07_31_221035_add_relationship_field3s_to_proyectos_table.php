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
        Schema::table('proyectos', function (Blueprint $table) {
            $table->unsignedBigInteger('facturacion_id')->nullable();
            $table->foreign('facturacion_id', 'facturacion_fk_8563285')->references('id')->on('facturacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->unsignedBigInteger('facturacion_id')->nullable();
            $table->foreign('facturacion_id', 'facturacion_fk_8563285')->references('id')->on('facturacion');
        });
    }
};
