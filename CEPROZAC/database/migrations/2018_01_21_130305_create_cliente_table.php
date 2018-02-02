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
            $table->string('telefono');
            $table->string('calle');
            $table->integer('numero');
            $table->string('colonia');
            $table->string('ciudad');
            $table->string('entidad');
            $table->string('pais');
            $table->string('email');
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
