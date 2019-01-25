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
use App\Repository\DiseaseRepository;
use App\Repository\DoctorRepository;
use App\Service\UploadService;

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
       $item = (new DiseaseRepository())->getAll(false);
       $data = BackDiseaseResource::collection($item);
       return $this->apiReturn($data);
    }

    //获取上传的临时秘钥
    public function getTempKeys(){
       $token = (new UploadService())->getTempKeys();
       return $this->apiReturn($token);
    }
}