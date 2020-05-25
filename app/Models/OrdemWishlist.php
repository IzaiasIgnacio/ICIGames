<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdemWishlist extends Model {

	protected $table = 'ordem_wishlist';
	protected $connection = 'icigames';
	public $timestamps = false;
	protected $guarded = [];
	
}