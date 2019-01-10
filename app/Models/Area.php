<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function children()
    {
    	return $this->hasMany(self::class, 'pid');
    }
}
