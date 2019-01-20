<?php

namespace App\Repository;

use App\Models\Live;

class LiveRepository
{

	public function liveList($page)
	{
	    return Live::where('status','<',Live::END)->isIndex()->paginate($page);
	}

	public function getById($id)
	{
		return Live::find($id);
	}

}