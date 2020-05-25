<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Model;

class GameDeveloperPublisher extends Model {

	protected $table			= 'game_developerPublisher';
	protected $connection		= 'import';
	public $timestamps 			= false;
	
}