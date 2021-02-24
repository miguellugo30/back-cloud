<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuario = User::create([
            'name' => 'Miguel Chavez Lugo',
            'email' => 'ingmchlugo@gmail.com',
            'password' => Hash::make('mch@v3s3')
        ]);

        $usuario->assignRole( 'Super Admin' );
    }
}
