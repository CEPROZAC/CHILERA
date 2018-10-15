<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Almacenempaque extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('almacenempaque', function (Blueprint $table) {
       $table->increments('id');
       $table->integer('idFormaEmpaque')->unsigned();
       $table->foreign('idFormaEmpaque')->references('id')->on('forma_empaques');
       $table->string('codigo')->nullable();
       $table->string('imagen')->nullable();
       $table->string('descripcion')->nullable();
       $table->integer('cantidad');
       $table->integer('stock_minimo')->nullable();
       $table->integer('idUnidadMedida')->unsigned();
       $table->foreign('idUnidadMedida')->references('id')->on('unidades_medidas');
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
      Schema::drop('almacenempaque');
    }
  }
