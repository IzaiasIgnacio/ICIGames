<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JogoGenero extends Model {

	protected $table = 'jogo_genero';
	protected $connection = 'icigames';
	public $timestamps = false;
	protected $guarded = [];

	public static function buscarGeneros($id_jogo) {
		return JogoGenero::join('genero', 'genero.id', 'jogo_genero.id_genero')
								->where('jogo_genero.id_jogo', $id_jogo)
									->get();
	}
	
}