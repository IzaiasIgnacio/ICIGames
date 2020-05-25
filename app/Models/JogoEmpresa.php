<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JogoEmpresa extends Model {

	protected $table = 'jogo_empresa';
	protected $connection = 'icigames';
	public $timestamps = false;
	protected $guarded = [];
	
}