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

	/**
	 * 权限列表
	 * @return array
	 */
	public function getList()
	{
		$rules = $this->repository->getList()->toArray();
		$res = $this->arrToTree($rules);//dd($res);
		return $res;
	}

	/**
	 * 保存
	 * @param $request
	 * @return $this|\Illuminate\Database\Eloquent\Model
	 */
	public function save($request)
	{
		$id = $request->id;
		$data = $request->only('pid', 'name', 'icon', 'path', 'path_name', 'rule_tag', 'api_name', 'sort');
		$data = array_filter($data, function ($v) {
			return !is_null($v);
		});
		if ($id) {
			return $this->repository->updateById($id, $data);
		} else {
			return $this->repository->create($data);
		}
	}

	/**
	 * 删除
	 * @param $id
	 * @return int
	 */
	public function delete($id)
	{
		return $this->repository->delete($id);
	}
}