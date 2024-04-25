<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFasefabricasTable extends Migration
{
    public function up()
    {
        Schema::create('fasefabricas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('aprobacion_course')->nullable();
            $table->string('estado_produccion')->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->string('estado')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
