<?php
namespace App\Transform;

use App\Models\Disease;

class DiseaseTranform extends TranformAbstract
{
	public function item($disease)
	{
		return [
			'id'=> $disease->id,
			'disease_name'=>$disease->name,
			'parent_id'=>$disease->pid,
		];
	}
}