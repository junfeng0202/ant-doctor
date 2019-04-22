<?php

namespace App\Service;


use App\Repository\RoleRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;

class RoleService
{
	protected $repository;


	public function __construct(RoleRepository $repository)
	{
		$this->repository = $repository;
	}

	public function getList($request)
	{
		return $this->repository->getList($request->get('limit',20));
	}

	public function info($id)
	{
		return $this->repository->getById($id);
	}

	/**
	 * 角色信息保存
	 * @param $request
	 * @return $this|\Illuminate\Database\Eloquent\Model
	 */
	public function save($request)
	{
		$id = $request->id;
		$data = $request->except('id');
		if($id)
			return $this->repository->update($id, $data);
		else
			return $this->repository->create($data);
	}


	public function getRules($id)
	{
		$role = $this->repository->getById($id);
		if(!$role) throw new ModelNotFoundException();

		return $role->permissions()->pluck('id');
	}

	public function saveRules($request)
	{
		$id = $request->id;
		$rules = $request->get('rules', []);
		$role = $this->repository->getById($id);
		if(!$role) throw new ModelNotFoundException();

		$role->permissions()->sync($rules);
		Cache::tags('rules')->flush();
		return ;
	}

	public function delete($id)
	{
		return $this->repository->delete($id);
	}
}