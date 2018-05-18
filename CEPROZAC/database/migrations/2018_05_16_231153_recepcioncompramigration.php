<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Recepcioncompramigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepcioncompra', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
             $table->date('fecha');
             $table->integer('id_provedor')->unsigned();
            $table->foreign('id_provedor')->references('id')->on('provedores');
             $table->integer('id_producto')->unsigned();
            $table->foreign('id_producto')->references('id')->on('productos');
            $table->double('kg_recibidos');
            $table->double('kg_enviados');
            $table->double('diferencia');
            $table->integer('id_transporte')->unsigned();
            $table->foreign('id_transporte')->references('id')->on('transportes');
            $table->integer('id_ticket')->unsigned();
            $table->foreign('id_ticket')->references('id')->on('servicio_basculas');
            $table->double('precio');
            $table->string('observaciones')->nullable();
            $table->integer('recibe')->unsigned();
            $table->foreign('recibe')->references('id')->on('empleados');
            $table->integer('ubicacion_act')->unsigned();
            $table->foreign('ubicacion_act')->references('id')->on('almacengeneral');
            $table->integer('id_fumigacion')->unsigned()->nullable();
            $table->foreign('id_fumigacion')->references('id')->on('fumigaciones');
            $table->string('estado');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('recepcioncompra');
    }
}
