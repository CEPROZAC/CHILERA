<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SalidasAgroquimicosMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salidasagroquimicos', function (Blueprint $table) {
            $table->increments('id');
             $table->integer('id_material')->unsigned();
            $table->foreign('id_material')->references('id')->on('almacenagroquimicos');
            $table->integer('cantidad');
            $table->string('destino');
            $table->string('entrego');
            $table->string('recibio');
            $table->string('tipo_movimiento');
            $table->date('fecha');
            $table->string('estado');

            $table->timestamps();

        });
          DB::unprepared('
        
        CREATE TRIGGER tr_updStrockVenta2 AFTER INSERT ON salidasagroquimicos
        FOR EACH ROW BEGIN
                UPDATE almacenagroquimicos SET cantidad=cantidad-NEW.cantidad
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
        Schema::drop('salidasagroquimicos');
    }
}
