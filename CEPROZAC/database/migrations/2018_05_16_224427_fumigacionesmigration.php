<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Fumigacionesmigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fumigaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hora');
            $table->date('fechai');
            $table->date('fechaf');
            $table->integer('id_quimicos')->unsigned();
            $table->foreign('id_quimicos')->references('id')->on('almacenagroquimicos');
            $table->integer('id_fumigador')->unsigned();
            $table->foreign('id_fumigador')->references('id')->on('empleados');
             $table->integer('id_recepcion')->unsigned();
            $table->foreign('id_recepcion')->references('id')->on('recepcioncompra');
            $table->string('cantidad_aplicada');
            $table->string('status');
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
        Schema::drop('fumigaciones');
    }
}
