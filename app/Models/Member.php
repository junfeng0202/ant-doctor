<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Member extends Authenticatable  implements JWTSubject
{
	use Notifiable;


	const INTERESTED = 0;
	const COMBINE = 1;
	const COMPLICATION = 2;

	protected $fillable = ['phone', 'password'];

	protected $hidden = ['password'];

	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	public function getJWTCustomClaims()
	{
		return [];
	}


	/**
	 * 感兴趣的疾病
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function interest()
	{
		return $this->belongsToMany(Disease::class)->wherePivot('type', self::INTERESTED);
	}

	/**
	 * 合并症
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function combine()
	{
		return $this->belongsToMany(Disease::class)->wherePivot('type', self::COMBINE);
	}


	/**
	 * 并发症
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function complication()
	{
		return $this->belongsToMany(Disease::class)->wherePivot('type', self::COMPLICATION);
	}
}
