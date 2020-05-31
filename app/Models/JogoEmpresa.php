<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JogoEmpresa extends Model {

	protected $table = 'jogo_empresa';
	protected $connection = 'icigames';
	public $timestamps = false;
	protected $guarded = [];

	public static function buscarDesenvolvedores($id_jogo) {
		return JogoEmpresa::join('empresa', 'empresa.id', 'jogo_empresa.id_empresa')
								->where('jogo_empresa.id_jogo', $id_jogo)
									->where('jogo_empresa.desenvolvedor', 1)
										->get();
	}

	public static function buscarDistribuidores($id_jogo) {
		return JogoEmpresa::join('empresa', 'empresa.id', 'jogo_empresa.id_empresa')
								->where('jogo_empresa.id_jogo', $id_jogo)
									->where('jogo_empresa.distribuidor', 1)
										->get();
	}
	
}