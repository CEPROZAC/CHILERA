<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EntradasAlmacenLimpiezaMigrate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('EntradasAlmacenLimpieza', function (Blueprint $table) {
            $table->increments('id');
            $table->string('provedor');
            $table->date('fecha');
            $table->integer('factura');
            $table->integer('id_material')->unsigned();
            $table->foreign('id_material')->references('id')->on('almacenlimpieza');
            $table->integer('cantidad');
            $table->double('p_unitario');
            $table->double('importe');
            $table->double('total');
            $table->string('comprador');
            $table->timestamps();

        });
         DB::unprepared('
        
        CREATE TRIGGER inserta_entrada3 AFTER INSERT ON EntradasAlmacenLimpieza
        FOR EACH ROW BEGIN
                UPDATE almacenlimpieza SET cantidad=cantidad+NEW.cantidad
                WHERE almacenlimpieza.id=NEW.id_material;

        END

        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('EntradasAlmacenLimpieza');
    }
}
