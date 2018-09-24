<?php

use Illuminate\Database\Seeder;

class TipoProvedorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	DB::table('tipo_provedor')->insert([
    		'nombre' => 'REFACCIONES', 
    		'descripcion' => '',
    		'estado'=>'Activo',]);

    	DB::table('tipo_provedor')->insert([
    		'nombre' => 'AGROQUIMICOS', 
    		'descripcion' => '',
    		'estado'=>'Activo',]);

    	DB::table('tipo_provedor')->insert([
    		'nombre' => 'LIMPIEZA', 
    		'descripcion' => '',
    		'estado'=>'Activo',]);

    	DB::table('tipo_provedor')->insert([
    		'nombre' => 'EMPAQUE', 
    		'descripcion' => '',
    		'estado'=>'Activo',]);


    }
}
