<?php
namespace App\Transform;

use App\Models\Area;
use League\Fractal\TransformerAbstract;

class AreaTranform extends TransformerAbstract
{
	public function transform(Area $area)
	{
		return $area->toArray();
	}
}