<?php

use Illuminate\Database\Seeder;

class UnidadesMedidaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {



        DB::table('unidades_medidas')->insert([
            'nombre' => 'COSTAL',
            'cantidad' => '5',
            'unidad_medida' => 'KILOGRAMOS', 
            'estado'=>'Activo',
            ]);
        DB::table('unidades_medidas')->insert([
            'nombre' => 'GALON',
            'cantidad' => '3',
            'unidad_medida' => 'LITROS', 
            'estado'=>'Activo',
            ]);
        DB::table('unidades_medidas')->insert([
            'nombre' => 'MALLA',
            'cantidad' => '5',
            'unidad_medida' => 'METROS', 
            'estado'=>'Activo',
            ]);

        //
    }
}
