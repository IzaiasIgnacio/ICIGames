<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Model;

class WishlistOrder extends Model {

	protected $table			= 'wishlist_order';
	protected $connection		= 'import';
	public $timestamps 			= false;
	
}