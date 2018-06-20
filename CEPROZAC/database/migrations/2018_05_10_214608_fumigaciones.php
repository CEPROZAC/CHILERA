<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Fumigaciones extends Migration
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
            $table->string('horai');
            $table->date('fechai');
            $table->date('fechaf');
            $table->string('horaf');
             $table->string('agroquimicos');
             $table->string('destino');
            $table->integer('id_fumigador')->unsigned();
            $table->foreign('id_fumigador')->references('id')->on('empleados');
            $table->string('cantidad_aplicada');
            $table->string('status');
            $table->string('observaciones');
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
