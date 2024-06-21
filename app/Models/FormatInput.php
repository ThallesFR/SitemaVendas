<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormatInput extends Model
{
    use HasFactory;

    public function MascaraDinheiroDecimal($valorParaFormatar)
    {
        $tamanho = strlen($valorParaFormatar);
        $dados = str_replace(',', '.', $valorParaFormatar);
        if ($tamanho <= 6) {
            $dados = str_replace(',', '.', $valorParaFormatar);
        } else {
            if ($tamanho >= 8 && $tamanho <= 10) {
                $retiraVirgulaPorPonto = str_replace(',', '.', $valorParaFormatar);
                $separaPorIndice = explode('.', $retiraVirgulaPorPonto);
                $dados = $separaPorIndice[0] . $separaPorIndice[1];
            }
        }

        return $dados;
    }
}
