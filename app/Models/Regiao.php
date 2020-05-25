<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regiao extends Model {

	protected $table = 'regiao';
	protected $connection = 'icigames';
	public $timestamps = false;
	protected $guarded = [];
	
}