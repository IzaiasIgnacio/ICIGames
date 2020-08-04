<?php

namespace App\Util;

use App\Models;

class Helper {

    public static function getDadosFormulario() {
        return [
            'plataformas' => Models\Plataforma::orderBy('ordem')->get(),
            'situacoes' => Models\Situacao::orderBy('ordem')->get(),
            'regioes' => Models\Regiao::get(),
            'classificacoes' => Models\Classificacao::get(),
            'formatos' => Models\Formato::get(),
            'lojas' => Models\Loja::select('loja.*')
                        ->join('acervo', 'acervo.id_loja', 'loja.id')
                            ->where('acervo.id_situacao', 1)
                                ->groupBy('loja.id')
                                    ->orderByDesc(\Illuminate\Support\Facades\DB::connection('icigames')->raw('count(acervo.id)'))
                                        ->get()
        ];
    }

    public static function formatarDataExibicao($data) {
        if (empty($data)) {
            return null;
        }

        return date('d/m/Y', \strtotime($data));
    }

    public static function formatarPrecoExibicao($preco) {
        if (empty($preco)) {
            return null;
        }

        return \number_format($preco, 2, ',', '');
    }

    public static function possuoJogo($id_jogo) {
        return Models\Acervo::where('id_jogo', $id_jogo)->whereIn('id_situacao', [1, 4, 5])->exists();
    }

}