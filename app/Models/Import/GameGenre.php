<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Model;

class GameGenre extends Model {

	protected $table			= 'game_genre';
	protected $connection		= 'import';
	public $timestamps 			= false;
	
}