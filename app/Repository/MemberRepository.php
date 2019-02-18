<?php

namespace App\Repository;

use App\Models\Member;
use App\Models\back\Member as BackMember;

class MemberRepository
{
	public function create($data)
	{
		return Member::create($data);
	}

	public function getById($id)
	{
		return Member::find($id);
	}

	public function update($id, $data)
	{
		return Member::whereId($id)->update($data);
	}

	public function updateByPhone($phone, $data)
	{
		return Member::where(['phone'=> $phone])->update($data);
	}

	public function phoneExist($phone)
	{
		return Member::where('phone', $phone)->exists();
	}

	public function getUserByPhone($phone)
	{
		return Member::where('phone',$phone)->first();
	}

	public function getUserByOpenid($openid)
	{
		return Member::where('openid',$openid)->first();
	}

//=============================================后台=====================================================
    //后台-用户列表
    public function BackPaginate($page=10, $sort='sort',$kw=null)
    {
        $query =BackMember::query();
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
//=============================================后台=====================================================

}