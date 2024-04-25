<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectosTable extends Migration
{
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo_proyecto')->nullable();
            $table->string('estado')->nullable();
            $table->string('fase')->nullable();
            $table->string('nombre_proyecto');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
