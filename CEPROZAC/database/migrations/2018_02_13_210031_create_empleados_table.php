<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nombre');
            $table->string('apellidos');
            $table->string('fecha_Ingreso');
            $table->string('fecha_Alta_Seguro');
            $table->string('numero_Seguro_Social');
            $table->string('fecha_Nacimiento');
            $table->string('curp');
            $table->string('email');
            $table->string('telefono');
            $table->string('sexo');
            $table->double('sueldo_Fijo');
            $table->integer('rol')->unsigned();
            $table->foreign('rol')->references('id')->on('rol_empleados');
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
        Schema::drop('empleados');
    }
}
