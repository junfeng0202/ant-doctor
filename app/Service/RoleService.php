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

	/**
	 * 角色列表
	 * @param $request
	 * @return mixed
	 */
	public function getList($request)
	{
		return $this->repository->getList($request->get('limit',20));
	}

	/**
	 * 角色信息
	 * @param $id
	 * @return mixed
	 */
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


	/**
	 * 角色权限
	 * @param $id
	 * @return mixed
	 */
	public function getRules($id)
	{
		$role = $this->repository->getById($id);
		if(!$role) throw new ModelNotFoundException();

		return $role->permissions()->pluck('id');
	}

	/**
	 * 保存角色权限
	 * @param $request
	 */
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

	/**
	 * 删除角色
	 * @param $id
	 * @return int
	 */
	public function delete($id)
	{
		return $this->repository->delete($id);
	}
}