<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cpf',
    ];

    public function getClientesPesquisarNome(string $search = '')
    {
        $cliente = $this->where(function ($query) use ($search) {
            if ($search) {
                $query->where('nome', $search);
                $query->orWhere('nome', 'like', "%{$search}%");
            }
        })->get();
        return $cliente;
    }
}
