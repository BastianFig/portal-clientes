<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSucursalUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('sucursal_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_8563548')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('sucursal_id');
            $table->foreign('sucursal_id', 'sucursal_id_fk_8563548')->references('id')->on('sucursals')->onDelete('cascade');
        });
    }
}
