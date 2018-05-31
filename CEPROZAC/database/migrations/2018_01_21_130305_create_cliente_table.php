<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
             Schema::create('cliente', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('rfc')->unique()->required();
            $table->string('fiscal');
            $table->string('telefono');
             $table->string('email');
             $table->string('direccion_fact');
             $table->string('direccion_entr');
             $table->string('cantidad_venta');
           $table->string('volumen_venta');
            $table->integer('saldocliente');
            $table->string('estado');
            $table->timestamps(); //
              });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
