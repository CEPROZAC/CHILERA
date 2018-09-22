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
        DB::table('unidadesmedida')->insert([
            'nombre' => 'KILOGRAMOS',
            'cantidad' => '1',
            'unidad_medida' => 'KILOGRAMOS', 
            'estado'=>'Activo',
            ]);
        DB::table('unidadesmedida')->insert([
            'nombre' => 'LITROS',
            'cantidad' => '1',
            'unidad_medida' => 'LITROS', 
            'estado'=>'Activo',
            ]);
        DB::table('unidadesmedida')->insert([
            'nombre' => 'METROS',
            'cantidad' => '1',
            'unidad_medida' => 'METROS', 
            'estado'=>'Activo',
            ]);
        DB::table('unidadesmedida')->insert([
            'nombre' => 'UNIDADES',
            'cantidad' => '1',
            'unidad_medida' => 'UNIDADES', 
            'estado'=>'Activo',
            ]);
        //
    }
}
