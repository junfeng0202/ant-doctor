<?php

namespace App\Repository;


use Spatie\Permission\Models\Role;

class RoleRepository
{
	public function getList($size = 20)
	{
		return Role::select('id', 'name', 'remark')->paginate($size);
	}

	public function getById($id)
	{
		return Role::find($id);
	}

	public function update($id, $data)
	{
		return Role::whereId($id)->update($data);
	}

	public function create($data)
	{
		return Role::create($data);
	}

	public function delete($id)
	{
		return Role::destroy($id);
	}


	public function saveRules()
	{
		return ;
	}
}