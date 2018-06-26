<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(RegimenFiscalTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(BancosTableSeeder::class);
        $this->call(FormaEmpaquesTableSeeder::class);
        $this->call(EmpresasCEPROZACTableSeeder::class);
        $this->call(CalidadTableSeeder::class);
        Model::reguard();
    }
}
