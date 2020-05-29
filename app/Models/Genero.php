<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genero extends Model {

	protected $table = 'genero';
	protected $connection = 'icigames';
	public $timestamps = false;
	protected $guarded = [];

	public static function buscarGenero($dados_igdb) {
		return Genero::firstOrCreate(['id_igdb' => $dados_igdb['id'], 'nome' => $dados_igdb['name']]);
	}
	
}