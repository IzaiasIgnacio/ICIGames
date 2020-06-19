<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Acervo extends Model {

	protected $table = 'acervo';
	protected $connection = 'icigames';
	public $timestamps = false;
	protected $guarded = [];

	public static function buscarAcervoSituacao($situacao) {
		$busca = Acervo::select('jogo.id', 'jogo.id_igdb_cover', 'jogo.titulo', DB::connection('icigames')->raw('group_concat(plataforma.sigla) as siglas'), 'acervo.data_lancamento')
                ->join('jogo', 'acervo.id_jogo', 'jogo.id')
                ->join('plataforma', 'acervo.id_plataforma', 'plataforma.id')
                    ->where('acervo.id_situacao', $situacao)
                        ->groupBy('jogo.id');

		// wishlist
        if ($situacao == 2) {
            return $busca->join('ordem_wishlist', 'acervo.id_jogo', 'ordem_wishlist.id_jogo')->orderBy('ordem_wishlist.ordem')->get();
        }
        else {
            return $busca->orderBy('titulo')->get();
		}
    }
    
    public static function buscarTotaisSituacao() {
        return \App\Models\Situacao::select('situacao.pagina', DB::connection('icigames')->raw('count(distinct acervo.id_jogo) as total'))
                                        ->leftJoin('acervo', 'situacao.id', 'acervo.id_situacao')
                                            ->groupBy('situacao.id')
                                                ->get()
                                                    ->pluck('total','pagina');
    }

    public static function buscarAcervoJogo($id_jogo) {
        return Acervo::select('acervo.*','plataforma.sigla as plataforma', 'situacao.nome as situacao', 'classificacao.nome as classificacao', 'regiao.nome as regiao', 'loja.nome as loja')
                        ->join('plataforma', 'acervo.id_plataforma', 'plataforma.id')
                        ->join('situacao', 'acervo.id_situacao', 'situacao.id')
                        ->LeftJoin('classificacao', 'acervo.id_classificacao', 'classificacao.id')
                        ->LeftJoin('regiao', 'acervo.id_regiao', 'regiao.id')
                        ->LeftJoin('loja', 'acervo.id_loja', 'loja.id')
                            ->where('acervo.id_jogo', $id_jogo)
                                ->get();
    }
	
}