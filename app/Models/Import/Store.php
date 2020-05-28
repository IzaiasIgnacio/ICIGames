<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Model;

class Store extends Model {

	protected $table			= 'store';
	protected $connection		= 'import';
	public $timestamps 			= false;
	
}