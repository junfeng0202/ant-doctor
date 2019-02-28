<?php
/**
 * Created by PhpStorm.
 * User: xiatong
 * Date: 2019/1/16
 * Time: 9:37 AM
 */

namespace App\Http\Controllers\Backend\V1;


use App\Http\Controllers\ApiController;
use App\Http\Resources\BackDiseaseResource;
use App\Http\Resources\BackDoctorResource;
use App\Models\MemberStudy;
use App\Repository\ArticleRepository;
use App\Repository\CourseRepository;
use App\Repository\DiseaseRepository;
use App\Repository\DoctorRepository;
use App\Repository\LiveRepository;
use App\Repository\MemberRepository;
use App\Repository\VideoRepository;
use App\Service\ArticleService;
use App\Service\CourseService;
use App\Service\LiveService;
use App\Service\MemberService;
use App\Service\UploadService;
use App\Service\VideoService;

class CommonController extends ApiController
{
    //获取所有医生
   public function doctor(){
        $item = (new DoctorRepository())->getAll();
        $data = BackDoctorResource::collection($item);
        return $this->apiReturn($data);
   }

   //获取所有疾病
    public function disease(){
       $item = (new DiseaseRepository())->getAll(false,0);
       $data = BackDiseaseResource::collection($item);
       return $this->apiReturn($data);
    }

    //获取上传的临时秘钥
    public function getTempKeys(){
       $token = (new UploadService())->getTempKeys();
       return $this->apiReturn($token);
    }

    //首页获取相关统计数据
    public function indexData(){
       //获取总的用户数
        $user = (new MemberService(new MemberRepository()))->BackUserCount();
        //统计素材数
        $courseNum = (new CourseService(new CourseRepository()))->BackCount();//课程
        $audio = (new VideoService(new VideoRepository()))->BackCount();//音频
        $lives = (new ArticleService(new ArticleRepository()))->BackCount();//直播
        //学习总时长
        $studyTimes = MemberStudy::sum('time') / 60;
        $res = [
            'userNum' => $user,
            'sucai' => $courseNum+$audio+$lives,
            'studyTimes' => (int)$studyTimes
        ];
       return $this->apiReturn($res);
    }
}