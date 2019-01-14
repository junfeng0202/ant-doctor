<?php

namespace App\Repository;


use App\Models\Article;
use App\Models\Live;

class CourseRepository
{
    //首页课程
	public function listOfItem()
	{
	    $live = Live::query();
	    $live = $live->limit(4);
	    $live = $live->orderBy('created_at');
        return $live->get();
	}

}