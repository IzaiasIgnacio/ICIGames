<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Model;

class Game extends Model {

	protected $table			= 'game';
	protected $connection		= 'import';
	public $timestamps 			= false;
	
}