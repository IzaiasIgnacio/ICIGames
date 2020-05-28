<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formato extends Model {

	public static function get() {
        return [
            'Digital',
            'Físico'
        ];
    }
	
}