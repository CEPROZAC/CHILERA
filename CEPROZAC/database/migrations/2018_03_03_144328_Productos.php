<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Productos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('calidad')->unsigned();
            $table->foreign('calidad')->references('id')->on('calidad');
            $table->string('unidad_de_Medida');
            $table->string('formato_de_Empaque');
            $table->string('porcentaje_Humedad');
            $table->string('imagen');
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
        Schema::drop('productos');
    }
}
