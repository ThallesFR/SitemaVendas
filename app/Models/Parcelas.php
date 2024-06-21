<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcelas extends Model
{
    use HasFactory;

    protected $fillable =[
        'numero_parcela',
        'venda_id',
        'valor_parcela',
        'vencimento',
    ];


    public function vendas()
    {
        return $this->belongsTo(Venda::class);
    }


}
