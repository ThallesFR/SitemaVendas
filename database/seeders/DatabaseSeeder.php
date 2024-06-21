<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Venda;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
   
    public function run(): void
    {
        $this->call([
            ProdutosSeeder::class,
            ClientesSeeder::class,
            UsuarioSeeder::class,
            VendasSeeder::class,
        ]);
    }
}
