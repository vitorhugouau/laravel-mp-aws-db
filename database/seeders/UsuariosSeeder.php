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
            'name' => 'Teste',
            'email' => 'teste@teste',
            'password' => Hash::make('123'),
        ]);
    }
}
