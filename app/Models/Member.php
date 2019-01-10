<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Member extends Model
{
	use HasApiTokens,Notifiable;


	const INTERESTED = 0;
	const COMBINE = 1;
	const COMPLICATION = 2;

	protected $fillable = ['phone', 'password'];

	protected $hidden = ['password'];

	public function findForPassport($username) {
		return $this->Where('phone', $username)->first();
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
