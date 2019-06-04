<?php

namespace App\Repository;

use App\Models\Member;

class MemberRepository
{
	/**
	 * create a member
	 * @param $data
	 * @return mixed
	 */
	public function create($data)
	{
		return Member::create($data);
	}

	/**
	 * get member info by id
	 * @param $id
	 * @return mixed
	 */
	public function getById($id)
	{
		return Member::find($id);
	}

	/**
	 * update member
	 * @param $id
	 * @param $data
	 * @return mixed
	 */
	public function update($id, $data)
	{
		return Member::whereId($id)->update($data);
	}

	/**
	 * update member info by phone
	 * @param $phone
	 * @param $data
	 * @return mixed
	 */
	public function updateByPhone($phone, $data)
	{
		return Member::where(['phone'=> $phone])->update($data);
	}

	/**
	 * check member exists by phone
	 * @param $phone
	 * @return mixed
	 */
	public function phoneExist($phone)
	{
		return Member::where('phone', $phone)->exists();
	}

	/**
	 * get member by phone
	 * @param $phone
	 * @return mixed
	 */
	public function getUserByPhone($phone)
	{
		return Member::where('phone',$phone)->first();
	}

	/**
	 * get member by wechat'openid
	 * @param $openid
	 * @return mixed
	 */
	public function getUserByOpenid($openid)
	{
		return Member::where('openid',$openid)->first();
	}


	/**
	 * member list
	 * @param int $page
	 * @param string $sort
	 * @param null $kw
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function BackPaginate($page=10, $sort='sort', $kw=null)
    {
        $query =Member::query();
        $query->latest($sort);
        //搜索条件
        //用户昵称
        if(isset($kw['kw_nickname'])){
            $query->where('nickname', 'like', '%'.$kw['kw_nickname'].'%');
        }
        //用户手机号
        if(isset($kw['kw_phone'])){
            $query->where('phone', 'like', '%'.$kw['kw_phone'].'%');
        }
        //病种
        if(isset($kw['kw_identify'])){
            $query->where('identify','=',$kw['kw_identify']);
        }
        //讲者
        if(isset($kw['kw_disease'])){
            $query->whereHas('memberDisease',
                function($query) use($kw){
                    $query->where('id', '=',$kw['kw_disease']);
                });
        }
        $users = $query->with(['city','province','memberDisease'])->paginate($page);
        return $users;
    }


	/**
	 * get count of members
	 * @return mixed
	 */
	public function BackCount(){
	    return Member::count();
    }

}