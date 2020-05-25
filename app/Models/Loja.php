<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loja extends Model {

	protected $table = 'loja';
	protected $connection = 'icigames';
	public $timestamps = false;
	protected $guarded = [];
	
}