<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EntradaAlmacenMateriales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
               Schema::create('EntradaAlmacenMateriales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('provedor');
            $table->date('fecha');
            $table->integer('nota_venta');
            $table->integer('id_material')->unsigned();
            $table->foreign('id_material')->references('id')->on('AlmacenMateriales');
            $table->integer('cantidad');
            $table->double('p_unitario');
            $table->double('importe');
            $table->double('total');
            $table->string('comprador');
            $table->timestamps();
        });
        DB::unprepared('
        
        CREATE TRIGGER inserta_entrada AFTER INSERT ON EntradaAlmacenMateriales
        FOR EACH ROW BEGIN
                UPDATE almacenmateriales SET cantidad=cantidad+NEW.cantidad
                WHERE almacenmateriales.id=NEW.id_material;

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
        Schema::drop('EntradaAlmacenMateriales');
    }
}
