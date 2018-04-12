<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlmacenAgroquimicosMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('AlmacenAgroquimicos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('codigo')->nullable();
            $table->string('imagen')->nullable();
            $table->string('descripcion')->nullable();
            $table->integer('cantidad');
             $table->string('medida');
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
        Schema::drop('AlmacenAgroquimicos');
    }
}
