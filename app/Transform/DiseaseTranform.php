<?php
namespace App\Transform;

use App\Models\Disease;
use League\Fractal\TransformerAbstract;

class DiseaseTranform extends TransformerAbstract
{
	public function transform(Disease $disease)
	{
		return [
			'id'=> $disease->id,
			'disease_name'=>$disease->name,
			'parent_id'=>$disease->pid,
		];
	}
}