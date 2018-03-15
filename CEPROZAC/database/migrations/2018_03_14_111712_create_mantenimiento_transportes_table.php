<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMantenimientoTransportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mantenimiento_transportes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idTransporte')->unsigned();
            $table->foreign('idTransporte')->references('id')->on('transportes');
            $table->string('concepto');
            $table->string('descripcion');
            $table->string('fecha');
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
        Schema::drop('mantenimiento_transportes');
    }
}
