<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keyshop extends Model {

	protected $table = '_keyshop';
	protected $connection = 'icigames';
	public $timestamps = false;
	protected $guarded = [];
	
}