<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Model;

class Status extends Model {

	protected $table			= 'status';
	protected $connection		= 'import';
	public $timestamps 			= false;
	
}