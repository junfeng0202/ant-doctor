<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Banner extends Model
{
    use SoftDeletes;

    protected $fillable = ['image', 'link', 'position', 'image', 'sort', 'enable'];
    protected $dates = ['deleted_at'];

}
