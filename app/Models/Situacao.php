<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Situacao extends Model {

	protected $table = 'situacao';
	protected $connection = 'icigames';
	public $timestamps = false;
	protected $guarded = [];
	
}