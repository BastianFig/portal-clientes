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
        Schema::table('fasedespachos', function (Blueprint $table) {
            $table->string('total_parcial')->nullable();
            $table->string('lotes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fasedespachos', function (Blueprint $table) {
            $table->string('total_parcial')->nullable();
            $table->string('lotes')->nullable();
        });
    }
};
