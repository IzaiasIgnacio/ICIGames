<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Model;

class GamePlatform extends Model {

	protected $table			= 'game_platform';
	protected $connection		= 'import';
	public $timestamps 			= false;
	
}