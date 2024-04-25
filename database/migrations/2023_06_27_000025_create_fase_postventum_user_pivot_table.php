<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFasePostventumUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('fase_postventum_user', function (Blueprint $table) {
            $table->unsignedBigInteger('fase_postventum_id');
            $table->foreign('fase_postventum_id', 'fase_postventum_id_fk_8680376')->references('id')->on('fase_postventa')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_8680376')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
