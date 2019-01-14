<?php
namespace App\Transform;

abstract class TranformAbstract
{
	public function transform($data)
	{
		return array_map([$this,'item'], $data);
	}

	public abstract function item($item);
}