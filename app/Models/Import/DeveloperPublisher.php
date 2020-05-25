<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Model;

class DeveloperPublisher extends Model {

	protected $table			= 'developerPublisher';
	protected $connection		= 'import';
	public $timestamps 			= false;
	
}