<?php
namespace App\Transform;

abstract class TransformAbstract
{
	public function transformCollection($data)
	{
		return array_map([$this,'item'], $data);
	}

	public abstract function transform($item);
}