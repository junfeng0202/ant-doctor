<?php

namespace App\Repository;

use App\Models\Video;

class VideoRepository
{

	public function paginate($page=10)
	{
		return Video::enable()->sort()->isIndex()->paginate($page);
	}

	public function getById($id)
	{
		return Video::enable()->with('section')->find($id);
	}

}