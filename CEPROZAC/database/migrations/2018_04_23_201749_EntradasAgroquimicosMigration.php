<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EntradasAgroquimicosMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entradasagroquimicos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('provedor');
            $table->date('fecha');
            $table->string('factura');
            $table->integer('id_material')->unsigned();
            $table->foreign('id_material')->references('id')->on('almacenagroquimicos');
            $table->integer('cantidad');
            $table->double('p_unitario');
            $table->double('importe');
                        $table->double('iva');
            $table->double('ieps');
            $table->double('total');
             $table->string('comprador');
             $table->string('moneda');
            $table->integer('entregado')->unsigned();
            $table->foreign('entregado')->references('id')->on('empleados');
              $table->integer('recibe_alm')->unsigned();
            $table->foreign('recibe_alm')->references('id')->on('empleados');
            $table->string('observacionesc')->nullable();
            $table->timestamps();

        });
         DB::unprepared('
        
        CREATE TRIGGER inserta_entrada2 AFTER INSERT ON entradasagroquimicos
        FOR EACH ROW BEGIN
                UPDATE almacenagroquimicos SET cantidad=cantidad+NEW.cantidad
                WHERE almacenagroquimicos.id=NEW.id_material;

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
        Schema::drop('entradasagroquimicos');
    }
}
