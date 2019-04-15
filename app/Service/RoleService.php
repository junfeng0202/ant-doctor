<?php

namespace App\Service;


use App\Repository\RoleRepository;

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

	public function save($request)
	{
		$id = $request->id;
		$data = $request->except('id');
		if($id)
			return $this->repository->update($id, $data);
		else
			return $this->repository->create($data);
	}

	public function delete($id)
	{
		return $this->repository->delete($id);
	}
}