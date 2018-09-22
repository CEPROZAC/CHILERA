<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Unidadesmedidamigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidadesmedida', function (Blueprint $table) {
        $table->increments('id');
        $table->string('nombre'); 
        $table->integer('cantidad')->nullable();
        $table->string('unidad_medida')->nullable();
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
        Schema::drop('unidadesmedida');
    }
}
