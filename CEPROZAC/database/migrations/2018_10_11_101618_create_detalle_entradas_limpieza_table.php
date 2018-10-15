<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleEntradasLimpiezaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_entradas_limpieza', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('idEntradaLimpieza')->unsigned();
          $table->foreign('idEntradaLimpieza')->references('id')->on('entradasalmacenlimpieza');
          $table->integer('id_material')->unsigned();
          $table->foreign('id_material')->references('id')->on('almacenlimpieza');
          $table->integer('cantidad');
          $table->double('p_unitario');
          $table->double('iva');
          $table->double('ieps');
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
        Schema::drop('detalle_entradas_limpiezas');
    }
}
