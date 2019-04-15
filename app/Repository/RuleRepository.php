<?php

namespace App\Repository;


use Spatie\Permission\Models\Permission;

class RuleRepository
{
	public function getList()
	{
		return Permission::latest('sort')->select('id', 'pid', 'name', 'icon', 'path', 'permission', 'type', 'sort')->get();
	}

	public function updateById($id, $data)
	{
		return Permission::whereId($id)->update($data);
	}

	public function create($data)
	{
		return Permission::create($data);
	}

}