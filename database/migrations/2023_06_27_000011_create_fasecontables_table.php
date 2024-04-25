<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFasecontablesTable extends Migration
{
    public function up()
    {
        Schema::create('fasecontables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('comentario')->nullable();
            $table->string('estado')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
