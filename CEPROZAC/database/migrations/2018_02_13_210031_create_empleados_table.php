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
            $table->string('apellido_P');
            $table->string('apellido_M');
            $table->date('fecha_Ingreso');
            $table->date('fecha_Alta_Seguro');
            $table->string('numero_Seguro_Social');
            $table->date('fecha_Nacimiento');
            $table->string('curp');
            $table->string('email');
            $table->string('telefono');
            $table->string('sexo');
            $table->double('sueldo_Fijo');
            $table->string('rol');
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
