<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model {

	protected $table = 'empresa';
	protected $connection = 'icigames';
	public $timestamps = false;
	protected $guarded = [];
	
	public static function buscarEmpresa($dados_igdb) {
		return Empresa::firstOrCreate(['id_igdb' => $dados_igdb['id'], 'nome' => $dados_igdb['name']]);
	}

}