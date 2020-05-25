<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jogo extends Model {

	protected $table = 'jogo';
	protected $connection = 'icigames';
	public $timestamps = false;
	protected $guarded = [];
	
}