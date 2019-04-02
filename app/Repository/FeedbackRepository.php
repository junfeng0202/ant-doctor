<?php

namespace App\Repository;

use App\Models\Feedback;

class FeedbackRepository
{

	public function getList($limit = 20)
	{
		return Feedback::with(['member:id,phone,nickname','images:id,feedback_id,image'])->paginate($limit);
	}

	public function create($data)
	{
		$feedback = Feedback::create($data);
		if(isset($data['images']) && count($data['images'])){
			$images = array_map(function ($v) {return ['image'=>$v];}, $data['images']);
			$feedback->images()->createMany($images);
		}
	}
}