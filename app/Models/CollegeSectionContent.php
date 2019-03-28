<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollegeSectionContent extends Model
{
    protected $fillable = ['college_section_id', 'college_id', 'contentable_id', 'contentable_type', 'sort'];

    public $timestamps =false;

    public function contentable()
    {
    	return $this->morphTo();
    }
}
