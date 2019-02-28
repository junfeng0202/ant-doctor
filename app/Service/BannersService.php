<?php

namespace App\Service;


use App\Models\Member;
use App\Proxy\OtherService;
use App\Repository\BannersRepository;
use App\Repository\MemberRepository;
use App\Repository\OauthRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class BannersService extends Service
{
	protected $bannersRepository;


	public function __construct(BannersRepository $bannersRepository)
	{
		$this->bannersRepository = $bannersRepository;
	}

	//==================================后端接口===============================================
    //banner列表
    public function BackList($limit,$kw){
        $items = $this->bannersRepository->BackPaginate($limit,null,$kw);
        return $items;
    }

    //banner列表详情
    public function BackInfo($id){
        $item = $this->bannersRepository->BackById($id);

        if(!$item){
            throw new ModelNotFoundException();
        }

        return $item;
    }

    //更新banner列表
    public function BackUpdateOreCreate($param){
        $data = array(
            'image' => $param['image'],
            'link' => $param['link'],
            'position' => $param['position'],
            'image' => $param['image'],
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

    public function delete($id){
        return $this->bannersRepository->BackDelete($id);
    }

    //==================================后端接口===============================================


}