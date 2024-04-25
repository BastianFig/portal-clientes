<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToProyectosTable extends Migration
{
    public function up()
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_cliente_id')->nullable();
            $table->foreign('id_cliente_id', 'id_cliente_fk_8644312')->references('id')->on('empresas');
            $table->unsignedBigInteger('sucursal_id')->nullable();
            $table->foreign('sucursal_id', 'sucursal_fk_8644314')->references('id')->on('sucursals');
        });
    }
}
