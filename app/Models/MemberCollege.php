<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberCollege extends Model
{
    protected $dates = ['expired_at'];

    protected $fillable = ['college_id', 'member_id', 'expired_at'];
}
