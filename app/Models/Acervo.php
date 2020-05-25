<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acervo extends Model {

	protected $table = 'acervo';
	protected $connection = 'icigames';
	public $timestamps = false;
	protected $guarded = [];
	
}