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
            $table->unsignedBigInteger('id_fasediseno')->nullable();
            $table->foreign('id_fasediseno', 'id_fasediseno_fk_864431225')->references('id')->on('fase_disenos');

            $table->unsignedBigInteger('id_fasecomercial')->nullable();
            $table->foreign('id_fasecomercial', 'id_fasecomercial_fk_864431223')->references('id')->on('fasecomercials');

            $table->unsignedBigInteger('id_fasecomercialproyectos')->nullable();
            $table->foreign('id_fasecomercialproyectos', 'id_fasecomercialproyectos_fk_86443122')->references('id')->on('fasecomercialproyectos');

            $table->unsignedBigInteger('id_fasecontables')->nullable();
            $table->foreign('id_fasecontables', 'id_fasecontables_fk_86443122')->references('id')->on('fasecontables');

            $table->unsignedBigInteger('id_fasedespachos')->nullable();
            $table->foreign('id_fasedespachos', 'id_fasedespachos_fk_86443122')->references('id')->on('fasedespachos');

            $table->unsignedBigInteger('id_fasefabricas')->nullable();
            $table->foreign('id_fasefabricas', 'id_fasefabricas_fk_86443122')->references('id')->on('fasefabricas');

            $table->unsignedBigInteger('id_fasepostventa')->nullable();
            $table->foreign('id_fasepostventa', 'id_fasepostventa_fk_86443122')->references('id')->on('fase_postventa');
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
            $table->unsignedBigInteger('id_fasediseno')->nullable();
            $table->foreign('id_fasediseno', 'id_fasediseno_fk_864431225')->references('id')->on('fase_disenos');

            $table->unsignedBigInteger('id_fasecomercial')->nullable();
            $table->foreign('id_fasecomercial', 'id_fasecomercial_fk_864431223')->references('id')->on('fasecomercials');

            $table->unsignedBigInteger('id_fasecomercialproyectos')->nullable();
            $table->foreign('id_fasecomercialproyectos', 'id_fasecomercialproyectos_fk_86443122')->references('id')->on('fasecomercialproyectos');

            $table->unsignedBigInteger('id_fasecontables')->nullable();
            $table->foreign('id_fasecontables', 'id_fasecontables_fk_86443122')->references('id')->on('fasecontables');

            $table->unsignedBigInteger('id_fasedespachos')->nullable();
            $table->foreign('id_fasedespachos', 'id_fasedespachos_fk_86443122')->references('id')->on('fasedespachos');

            $table->unsignedBigInteger('id_fasefabricas')->nullable();
            $table->foreign('id_fasefabricas', 'id_fasefabricas_fk_86443122')->references('id')->on('fasefabricas');

            $table->unsignedBigInteger('id_fasepostventa')->nullable();
            $table->foreign('id_fasepostventa', 'id_fasepostventa_fk_86443122')->references('id')->on('fase_postventa');
            
        });
    }
};
