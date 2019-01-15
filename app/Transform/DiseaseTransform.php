<?php
namespace App\Transform;

class DiseaseTransform extends TransformAbstract
{
	public function transform($disease)
	{
		return [
			'id'=> $disease->id,
			'disease_name'=>$disease->name,
			'parent_id'=>$disease->pid,
		];
	}
}