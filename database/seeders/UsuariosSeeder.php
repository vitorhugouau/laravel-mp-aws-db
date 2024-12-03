<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UsuariosSeeder extends Seeder
{
    public function run()
    {
        Usuarios::create([
            'name' => 'Admin',
            'email' => 'admin@teste.com',
            'password' => Hash::make('123'),
            'role' => 'admin',
            'email_verified_at' => Carbon::now(), 
        ]);
    }
}
