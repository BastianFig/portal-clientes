<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFasecomercialsTable extends Migration
{
    public function up()
    {
        Schema::create('fasecomercials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('comentarios')->nullable();
            $table->string('estado')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
