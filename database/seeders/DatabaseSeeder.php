<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run0(): void
    {
       

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
    public function run()
    {
        
        $this->call(AdmSeeder::class);
        $this->call(UsuariosSeeder::class);
        $this->call(DescontoSeeder::class);
    }
}
