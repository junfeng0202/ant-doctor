<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberVideo extends Model
{
	protected $dates = ['expired_at'];

	protected $fillable = ['video_id', 'member_id', 'expired_at'];
}
