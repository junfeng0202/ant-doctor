<?php
namespace App\Strategy\OrderSuccess;

interface IOrderSuccess
{
	public function addMemberOrder($member_id, $goods_id);
}

