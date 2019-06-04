<?php

namespace App\Service;


use App\Repository\BannersRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BannersService extends Service
{
	protected $bannersRepository;


	public function __construct(BannersRepository $bannersRepository)
	{
		$this->bannersRepository = $bannersRepository;
	}


	/**
	 * banner列表
	 * @param $limit
	 * @param $kw
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function BackList($limit, $kw){
        $items = $this->bannersRepository->BackPaginate($limit,null,$kw);
        return $items;
    }


	/**
	 * banner详情
	 * @param $id
	 * @return mixed
	 */
	public function BackInfo($id){
        $item = $this->bannersRepository->BackById($id);

        if(!$item){
            throw new ModelNotFoundException();
        }

        return $item;
    }

	/**
	 * 更新banner
	 * @param $param
	 */
	public function BackUpdateOreCreate($param){
        $data = array(
            'image' => $param['image'],
            'link' => $param['link']?$param['link']:'',
            'position' => $param['position'],
            'sort' => $param['sort'],
            'enable' => isset($param['enable'])?$param['enable']:1,
        );
        if(isset($param['id']) && $param['id'] != ''){
            $data['id'] = $param['id'];
        }else{
            $data['id'] = 0;
        }
        //更新基本信息
       $this->bannersRepository->BackUpdateOreCreate($data);


    }

	/**
	 * delete banner
	 * @param $id
	 * @return int
	 */
	public function delete($id){
        return $this->bannersRepository->BackDelete($id);
    }


}