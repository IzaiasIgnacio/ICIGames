<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classificacao extends Model {

	protected $table = 'classificacao';
	protected $connection = 'icigames';
	public $timestamps = false;
	protected $guarded = [];
	
}