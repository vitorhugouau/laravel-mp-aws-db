<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Desconto;

class DescontoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Adicionar 20 registros com valores aleatórios entre 100 e 280
        for ($i = 0; $i < 20; $i++) {
            Desconto::create([
                'valores' => rand(100, 280), // Gera um valor aleatório entre 100 e 280
            ]);
        }
    }
}
