<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlmacenMaterialMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('almacenmateriales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('provedor')->nullable();
            $table->string('codigo')->nullable();
            $table->string('imagen')->nullable();
            $table->string('descripcion')->nullable();
            $table->integer('cantidad');
            $table->string('estado');
             $table->integer('stock_minimo')->nullable();
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
        Schema::drop('almacenmateriales');
    }
}
