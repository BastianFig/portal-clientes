<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFasefabricasTable extends Migration
{
    public function up()
    {
        Schema::table('fasefabricas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_proyecto_id')->nullable();
            $table->foreign('id_proyecto_id', 'id_proyecto_fk_8644555')->references('id')->on('proyectos');
        });
    }
}
