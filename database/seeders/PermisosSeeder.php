<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Permisos Empresa
         */
        Permission::create(['name' => 'view empresas']);
        Permission::create(['name' => 'create empresas']);
        Permission::create(['name' => 'edit empresas']);
        Permission::create(['name' => 'delete empresas']);
        /**
         * Permisos Usuarios
         */
        Permission::create(['name' => 'view usuarios']);
        Permission::create(['name' => 'create usuarios']);
        Permission::create(['name' => 'edit usuarios']);
        Permission::create(['name' => 'delete usuarios']);
        /**
         * Permisos Logs
         */
        Permission::create(['name' => 'view logs']);
    }
}
