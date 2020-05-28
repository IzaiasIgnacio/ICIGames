<?php

namespace App\Util;

use App\Models;

class Helper {

    public static function getDadosFormulario() {
        return [
            'plataformas' => Models\Plataforma::orderBy('ordem')->get(),
            'situacoes' => Models\Situacao::get(),
            'regioes' => Models\Regiao::get(),
            'classificacoes' => Models\Classificacao::get(),
            'formatos' => Models\Formato::get(),
            'lojas' => Models\Loja::get()
        ];
    }

}