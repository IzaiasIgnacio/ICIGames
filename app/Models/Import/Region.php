<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Model;

class Region extends Model {

	protected $table			= 'region';
	protected $connection		= 'import';
	public $timestamps 			= false;
	
}