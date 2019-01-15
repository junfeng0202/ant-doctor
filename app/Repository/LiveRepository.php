<?php

namespace App\Repository;

use App\Models\Live;

class LiveRepository
{

	public function liveList()
	{
	    return Live::where('created_at','>',now()->subDays(2))->get();
	}

}