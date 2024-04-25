<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFasePostventaTable extends Migration
{
    public function up()
    {
        Schema::create('fase_postventa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('estado')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
