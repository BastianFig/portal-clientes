<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFasePostventaTable extends Migration
{
    public function up()
    {
        Schema::table('fase_postventa', function (Blueprint $table) {
            $table->unsignedBigInteger('encuesta_id')->nullable();
            $table->foreign('encuesta_id', 'encuesta_fk_8680370')->references('id')->on('encuesta');
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->foreign('ticket_id', 'ticket_fk_8680374')->references('id')->on('tickets');
            $table->unsignedBigInteger('id_proyecto_id')->nullable();
            $table->foreign('id_proyecto_id', 'id_proyecto_fk_8680375')->references('id')->on('proyectos');
        });
    }
}
