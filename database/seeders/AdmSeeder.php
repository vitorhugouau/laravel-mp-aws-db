<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Adm;  
use Illuminate\Support\Facades\Hash;  

class AdmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Adm::create([
            'email' => 'vitor@hugo',
            'password' => Hash::make('123'),  
        ]);
    }
}
