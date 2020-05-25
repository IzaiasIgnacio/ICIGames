<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JogoGenero extends Model {

	protected $table = 'jogo_genero';
	protected $connection = 'icigames';
	public $timestamps = false;
	protected $guarded = [];
	
}