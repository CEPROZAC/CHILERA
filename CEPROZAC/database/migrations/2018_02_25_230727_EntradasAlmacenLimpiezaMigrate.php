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
        Schema::create('entradasalmacenlimpieza', function (Blueprint $table) {
            $table->increments('id');
            $table->string('provedor');
            $table->date('fecha');
            $table->integer('factura');
            $table->integer('id_material')->unsigned();
            $table->foreign('id_material')->references('id')->on('almacenlimpieza');
            $table->integer('cantidad');
            $table->double('p_unitario');
            $table->double('importe');
            $table->double('iva');
            $table->double('total');
             $table->string('comprador');

            $table->integer('entregado')->unsigned();
            $table->foreign('entregado')->references('id')->on('empleados');
              $table->integer('recibe_alm')->unsigned();
            $table->foreign('recibe_alm')->references('id')->on('empleados');
            $table->string('observacionesc')->nullable();
            $table->timestamps();

        });
        DB::unprepared('

            CREATE TRIGGER inserta_entrada3 AFTER INSERT ON entradasalmacenlimpieza
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
        Schema::drop('entradasalmacenlimpieza');
    }
}
