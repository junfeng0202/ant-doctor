<?php

namespace App\Repository;


use App\Models\Article;
use App\Models\Live;
use App\Models\Video;

class VideoRepository
{
    //首页音频
	public function listOfIndex()
	{
	    $query = Video::query();
        $query = $query->limit(3);
        $query = $query->orderBy('created_at','acs');
        return $query->get();
	}

}