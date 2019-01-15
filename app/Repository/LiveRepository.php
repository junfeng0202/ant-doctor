<?php

namespace App\Repository;

use App\Models\Live;

class LiveRepository
{

	public function liveList()
	{
	    return Live::where('status','<',Live::END)->isIndex()->get();
	}

	public function getById($id)
	{
		return Live::find($id);
	}

}