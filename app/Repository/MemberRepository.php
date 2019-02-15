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

//=============================================后台=====================================================
    //后台-用户列表
    public function BackPaginate($page=10, $sort='sort',$kw=null)
    {
        $query =BackMember::query();
        $query->latest($sort);
        //搜索条件
        //标题
        if(isset($kw['kw_title'])){
            $query->where('title', 'like', '%'.$kw['kw_title'].'%');
        }
        //病种
        if(isset($kw['kw_disease'])){
            $query->where('disease_id','=',$kw['kw_disease']);
        }
        //讲者
        if(isset($kw['kw_doctor'])){
            $query->whereHas('doctor',
                function($query) use($kw){
                    $query->where('id', '=',$kw['kw_doctor']);
                });
        }
        $users = $query->with(['city','province','memberDisease'])->paginate($page);
        return $users;
    }
//=============================================后台=====================================================

}