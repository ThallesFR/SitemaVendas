<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientesSeeder extends Seeder
{
    public function run(): void
    {
        Cliente::create(
            [
                'nome' => 'Cliente 1',
                'cpf' => '922.404.155-55',
            ]
        );
        Cliente::create(
            [
                'nome' => 'Cliente 2',
                'cpf' => '922.404.155-55',
            ]
        );
    }
}
