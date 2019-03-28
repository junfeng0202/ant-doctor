<?php

namespace App\Repository;

use App\Models\Feedback;

class FeedbackRepository
{

	public function getList($limit = 20)
	{
		return Feedback::with(['member:id,phone,nickname','images:id,feedback_id,image'])->paginate($limit);
	}
}