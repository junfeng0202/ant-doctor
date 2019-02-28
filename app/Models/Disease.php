<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disease extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    //疾病类型
	const INTERESTED = 0;
	const COMBINE = 1;
	const COMPLICATION = 2;
    protected $fillable = ['id', 'name', 'pid', 'sort', 'enable', 'type'];

	public function scopeSort($query)
	{
		return $query->orderByDesc('sort');
	}
}
