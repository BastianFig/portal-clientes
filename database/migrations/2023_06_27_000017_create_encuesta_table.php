<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncuestaTable extends Migration
{
    public function up()
    {
        Schema::create('encuesta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('observacion')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
