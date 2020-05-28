<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model {

	protected $table			= 'genre';
	protected $connection		= 'import';
	public $timestamps 			= false;
	
}