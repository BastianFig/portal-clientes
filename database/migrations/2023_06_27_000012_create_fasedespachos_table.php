<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFasedespachosTable extends Migration
{
    public function up()
    {
        Schema::create('fasedespachos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fecha_despacho')->nullable();
            $table->string('estado_instalacion')->nullable();
            $table->longText('comentario')->nullable();
            $table->string('recibe_conforme')->nullable();
            $table->string('estado')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
