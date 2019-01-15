<?php

namespace App\Repository;

use App\Models\Video;

class VideoRepository
{
    //首页音频
	public function paginate($page=10)
	{
		return Video::enable()->sort()->paginate($page);
	}

}