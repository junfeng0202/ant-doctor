<?php

namespace App\Repository;


use Spatie\Permission\Models\Permission;

class RuleRepository
{
	public function getList()
	{
		return Permission::latest('sort')->select('id', 'pid', 'name', 'icon', 'path', 'path_name', 'rule_tag', 'api_name', 'sort')->get();
	}

	public function updateById($id, $data)
	{
		return Permission::whereId($id)->update($data);
	}

	public function create($data)
	{
		return Permission::create($data);
	}

	public function delete($id)
	{
		return Permission::destroy($id);
	}

}