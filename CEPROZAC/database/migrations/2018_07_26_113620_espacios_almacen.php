<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EspaciosAlmacen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('espacios_almacen', function (Blueprint $table) {
         $table->increments('id');
         $table->string('num_espacio');
         $table->integer('id_almacen')->unsigned();
         $table->foreign('id_almacen')->references('id')->on('almacengeneral');
         $table->string('capacidad')->nullable();
         $table->string('medida')->nullable();
         $table->string('total_ocupado')->nullable();
         $table->string('total_libre')->nullable();
         $table->integer('id_producto')->unsigned()->nullable();
         $table->foreign('id_producto')->references('id')->on('productos');
         $table->integer('id_provedor')->unsigned()->nullable();
         $table->foreign('id_provedor')->references('id')->on('provedores');
         $table->string('descripcion')->nullable();
          $table->string('estado')->nullable();
          $table->date('fecha_entrada')->nullable();
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
        Schema::drop('espacios_almacen');
    }
}
