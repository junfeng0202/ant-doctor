<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    public function disease(){
        return $this->hasOne(Disease::class,'id','disease_id');
    }

    //格式化数据
    public static function parseRow($item){
        $res = [];
        foreach ($item as $k=>$v){
            $res[] = [
                'article_id' =>$v->id,
                'infoTitle' => $v->title,
                'infoImg' =>$v->image,
                'infoCount' =>$v->hits
            ];
        }
        return $res;
    }
}
