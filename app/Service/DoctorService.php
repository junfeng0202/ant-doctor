<?php

namespace App\Service;


use App\Repository\DoctorRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DoctorService extends Service
{
	protected $doctorRepository;


	public function __construct(DoctorRepository $doctorRepository)
	{
		$this->doctorRepository = $doctorRepository;
	}


	/**
	 * 讲者列表
	 * @param $limit
	 * @param $kw
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function BackList($limit, $kw){
        $items = $this->doctorRepository->BackPaginate($limit,null,$kw);
        return $items;
    }


	/**
	 * 讲者详情
	 * @param $id
	 * @return mixed
	 */
	public function BackInfo($id){
        $item = $this->doctorRepository->BackById($id);

        if(!$item){
            throw new ModelNotFoundException();
        }

        return $item;
    }


	/**
	 * 更新讲者
	 * @param $param
	 */
	public function BackUpdateOreCreate($param){
        $data = array(
            'name' => $param['name'],
            'identify' => $param['identify'],
            'hospital' => $param['hospital'],
            'depart' => $param['depart'],
            'job' => $param['job'],
            'mime_id' => $param['mime_id'],
            'brief' => $param['brief'],
            'enable' => isset($param['enable'])?$param['enable']:1,
        );
        if(isset($param['id']) && $param['id'] != ''){
            $data['id'] = $param['id'];
        }else{
            $data['id'] = 0;
        }
        //更新基本信息
       $this->doctorRepository->BackUpdateOreCreate($data);
    }


}