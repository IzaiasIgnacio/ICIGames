<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GGDeals extends Model {

	protected $table = 'ggdeals';
	protected $connection = 'icigames';
	public $timestamps = false;
	protected $guarded = [];
	
}