<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_id_fk_8644453456541225')->references('id')->on('users');
            $table->unsignedBigInteger('vendedor_id')->nullable();
            $table->foreign('vendedor_id', 'vendedor_id_fk_8644455433456541225')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_id_fk_8644453456541225')->references('id')->on('users');
            $table->unsignedBigInteger('vendedor_id')->nullable();
            $table->foreign('vendedor_id', 'vendedor_id_fk_8644455433456541225')->references('id')->on('users');
        });
    }
};
