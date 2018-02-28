<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SalidaAlmacenMaterialMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SalidasAlmacenMaterial', function (Blueprint $table) {
            $table->increments('id');
             $table->integer('id_material')->unsigned();
            $table->foreign('id_material')->references('id')->on('AlmacenMateriales');
            $table->integer('cantidad');
            $table->string('destino');
            $table->string('entrego');
            $table->string('recibio');
            $table->string('tipo_movimiento');

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
        Schema::drop('SalidasAlmacenMaterial');
    }
}
