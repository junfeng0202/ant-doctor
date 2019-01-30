<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Member extends Authenticatable  implements JWTSubject
{
	use Notifiable;

	//疾病类型
	const INTERESTED = 0;
	const COMBINE = 1;
	const COMPLICATION = 2;

	//身份 1.患者 2.家属 3.医疗从业者 4.非医疗从业者
	const PATIENT = 1;
	const FAMILY = 2;
	const PRACTITIONER = 3;
	const UNPRACTITIONER = 4;

	protected $fillable = ['phone', 'password', 'avatar', 'nickname', 'identify', 'gender','birth', 'diagnosis_at', 'province_id', 'city_id', 'company'];

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
	 * 用户关注的疾病
	 * @param $type 0.感兴趣 1.合并症 2.并发症
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function disease($type)
	{
		return $this->belongsToMany(Disease::class)->wherePivot('type', $type);
	}

	public function province()
	{
		return $this->belongsTo(Area::class,'province_id');
	}

	public function city()
	{
		return $this->belongsTo(Area::class,'city_id');
	}


}
