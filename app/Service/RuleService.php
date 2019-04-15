<?php

namespace App\Service;

use App\Repository\RuleRepository;

class RuleService extends Service
{
	protected $repository;


	public function __construct(RuleRepository $repository)
	{
		$this->repository = $repository;
	}

	public function getList()
	{
		$rules = $this->repository->getList()->toArray();
		$res = $this->arrToTree($rules);//dd($res);
		return $res;
	}

	public function save($request)
	{
		$id = $request->id;
		$data = $request->only('pid', 'name', 'icon', 'path', 'permission', 'type', 'sort');
		$data = array_filter($data, function ($v) {
			return !is_null($v);
		});
		if ($id) {
			return $this->repository->updateById($id, $data);
		} else {
			return $this->repository->create($data);
		}
	}
}