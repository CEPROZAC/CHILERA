<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('empresas', function (Blueprint $table) {
       $table->increments('id');
       $table->string('nombre');
       $table->string('rfc');
        $table->string('regimenFiscal');
       $table->string('telefono');
       $table->string('direccion');
       $table->string('email');
       $table->integer('id_Banco')->unsigned();
       $table->foreign('id_Banco')->references('id')->on('bancos');
       $table->string('cve_Interbancaria');
       $table->string('nom_cuenta');
       $table->string('estado');
       $table->integer('provedor_id')->unsigned();
       $table->foreign('provedor_id')->references('id')->on('provedores');
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
     Schema::drop('empresa');
   }
 }
