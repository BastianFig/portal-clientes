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
        Schema::create('mensajes_ticket', function (Blueprint $table) {

            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->foreign('sender_id', 'sender_id_fk_864443122')->references('id')->on('users');
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->foreign('ticket_id', 'ticket_id_fk_864434122')->references('id')->on('tickets');
            $table->string('mensaje')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mensajes_ticket');
        $table->id();
        $table->timestamps();
        $table->unsignedBigInteger('sender_id')->nullable();
        $table->foreign('sender_id', 'sender_id_fk_864443122')->references('id')->on('users');
        $table->unsignedBigInteger('ticket_id')->nullable();
        $table->foreign('ticket_id', 'ticket_id_fk_864434122')->references('id')->on('tickets');
        $table->string('mensaje')->nullable();
    }
};
