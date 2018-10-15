<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleEntradasEmpaquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_entradas_empaques', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('idEntradaMaterial')->unsigned();
          $table->foreign('idEntradaMaterial')->references('id')->on('entradasempaques');
          $table->integer('id_material')->unsigned();
          $table->foreign('id_material')->references('id')->on('almacenempaque');
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
        Schema::drop('detalle_entradas_empaques');
    }
}
