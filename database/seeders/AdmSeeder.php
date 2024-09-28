<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Adm;  // Certifique-se de importar o modelo Adm
use Illuminate\Support\Facades\Hash;  // Para fazer o hash da senha

class AdmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Cria um administrador
        Adm::create([
            'email' => 'admin',
            'password' => Hash::make('123'),  // Hash da senha
        ]);
    }
}
