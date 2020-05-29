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
		$busca = Acervo::select('jogo.id', 'jogo.id_igdb_cover', 'jogo.titulo', DB::connection('icigames')->raw('group_concat(plataforma.sigla) as siglas'))
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
	
}