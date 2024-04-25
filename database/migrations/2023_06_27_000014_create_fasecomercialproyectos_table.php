<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFasecomercialproyectosTable extends Migration
{
    public function up()
    {
        Schema::create('fasecomercialproyectos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('estado')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
