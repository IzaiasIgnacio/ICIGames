<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plataforma extends Model {

	protected $table = 'plataforma';
	protected $connection = 'icigames';
	public $timestamps = false;
	protected $guarded = [];
	
}