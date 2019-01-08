<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{

	protected $fillable = ['name', 'identify', 'hospital', 'depart', 'job', 'mime_id', 'brief', 'sort', 'enable'];
}
