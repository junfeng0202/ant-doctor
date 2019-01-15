<?php
namespace App\Transform;

use App\Models\Area;
use League\Fractal\TransformerAbstract;

class AreaTranform extends TransformAbstract
{
	public function transform($area)
	{
		return $area->toArray();
	}
}