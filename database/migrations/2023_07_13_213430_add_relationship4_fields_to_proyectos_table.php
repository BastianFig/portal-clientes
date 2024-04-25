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
        Schema::table('proyectos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_carpetacliente')->nullable();
            $table->foreign('id_carpetacliente', 'id_fasediseno_fk_86443456541225')->references('id')->on('carpetaclientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_carpetacliente')->nullable();
            $table->foreign('id_carpetacliente', 'id_fasediseno_fk_86443456541225')->references('id')->on('carpetaclientes');
        });
    }
};
