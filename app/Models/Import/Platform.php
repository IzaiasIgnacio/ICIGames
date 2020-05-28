<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model {

	protected $table			= 'platform';
	protected $connection		= 'import';
	public $timestamps 			= false;
	
}