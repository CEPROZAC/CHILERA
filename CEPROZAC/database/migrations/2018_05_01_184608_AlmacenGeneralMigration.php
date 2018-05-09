<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlmacenGeneralMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('almacengeneral', function (Blueprint $table) {
           $table->increments('id');
         $table->string('nombre');
         $table->integer('capacidad');
         $table->string('medida')->nullable();
         $table->integer('ocupado');
         $table->integer('libre');
         $table->string('descripcion')->nullable();
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
        Schema::drop('almacengeneral');
    }
}
