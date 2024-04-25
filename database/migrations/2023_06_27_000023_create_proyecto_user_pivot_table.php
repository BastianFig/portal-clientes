<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('proyecto_user', function (Blueprint $table) {
            $table->unsignedBigInteger('proyecto_id');
            $table->foreign('proyecto_id', 'proyecto_id_fk_8644313')->references('id')->on('proyectos')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_8644313')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
