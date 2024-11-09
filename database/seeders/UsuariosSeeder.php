<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Usuarios::create([
            'name' => 'Admin',
            'email' => 'admin@teste.com',
            'password' => Hash::make('123'),
            'role' => 'admin',
        ]);
    }
}
