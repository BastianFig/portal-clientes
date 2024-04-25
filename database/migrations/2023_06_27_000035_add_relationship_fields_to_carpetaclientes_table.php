<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCarpetaclientesTable extends Migration
{
    public function up()
    {
        Schema::table('carpetaclientes', function (Blueprint $table) {
            $table->unsignedBigInteger('id_fase_comercial_id')->nullable();
            $table->foreign('id_fase_comercial_id', 'id_fase_comercial_fk_8644691')->references('id')->on('fasecomercialproyectos');
        });
    }
}
