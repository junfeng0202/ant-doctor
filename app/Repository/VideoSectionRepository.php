<?php

namespace App\Repository;

use App\Models\VideoSection;

class VideoSectionRepository
{

	public function getById($id)
	{
		return VideoSection::find($id);
	}

}