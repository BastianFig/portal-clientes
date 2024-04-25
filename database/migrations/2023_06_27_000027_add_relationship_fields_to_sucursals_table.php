<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSucursalsTable extends Migration
{
    public function up()
    {
        Schema::table('sucursals', function (Blueprint $table) {
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->foreign('empresa_id', 'empresa_fk_8563285')->references('id')->on('empresas');
        });
    }
}
