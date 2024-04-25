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
        Schema::table('encuesta', function (Blueprint $table) {
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->foreign('empresa_id', 'empresa_fk_8563453547')->references('id')->on('empresas');
            $table->string('nombre_encuestado')->nullable();
            $table->string('como_llegaste')->nullable();
            $table->string('calificacion')->nullable();
            $table->string('satisfaccion1')->nullable();
            $table->string('satisfaccion2')->nullable();
            $table->string('satisfaccion3')->nullable();
            $table->string('satisfaccion4')->nullable();
            $table->string('satisfaccion5')->nullable();
            $table->string('satisfaccion6')->nullable();
            $table->string('satisfaccion7')->nullable();
            $table->string('rating')->nullable();
            $table->string('mejorar_servicio')->nullable();
            $table->string('autorizacion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('encuesta', function (Blueprint $table) {
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->foreign('empresa_id', 'empresa_fk_8563453547')->references('id')->on('empresas');
            $table->string('nombre_encuestado')->nullable();
            $table->string('como_llegaste')->nullable();
            $table->string('calificacion')->nullable();
            $table->string('satisfaccion1')->nullable();
            $table->string('satisfaccion2')->nullable();
            $table->string('satisfaccion3')->nullable();
            $table->string('satisfaccion4')->nullable();
            $table->string('satisfaccion5')->nullable();
            $table->string('satisfaccion6')->nullable();
            $table->string('satisfaccion7')->nullable();
            $table->string('rating')->nullable();
            $table->string('mejorar_servicio')->nullable();
            $table->string('autorizacion')->nullable();
        });
    }
};
