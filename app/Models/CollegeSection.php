<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollegeSection extends Model
{
	const COURSE = 'course';
	const VIDEO = 'video';
	const ARTICLE = 'article';

    public $timestamps = false;

	public $fillable = ['title', 'college_id', 'type', 'enable', 'sort'];

    public function content()
    {
    	return $this->hasMany(CollegeSectionContent::class);
    }

}
