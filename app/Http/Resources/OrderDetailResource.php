<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return array
	 */
	public function toArray($request)
	{
		return [
			// 'id' => $this->id,
			'order_id ' => $this->order_id,
			'goods_id' => $this->goods_id,
			'title' => $this->title,
			'type' => $this->goods_type,
			'image' => $this->image,
		];
	}
}
