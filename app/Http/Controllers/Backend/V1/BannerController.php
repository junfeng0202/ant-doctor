<?php
/**
 * Created by PhpStorm.
 * User: xiatong
 * Date: 2019/1/16
 * Time: 9:37 AM
 */

namespace App\Http\Controllers\Backend\V1;


use App\Http\Controllers\ApiController;
use App\Service\ArticleService;
use App\Service\BannersService;
use Illuminate\Http\Request;

class BannerController extends ApiController
{
    protected $bannersService;

    public function __construct(BannersService $bannerService)
    {
        $this->bannersService = $bannerService;

    }

    public function list(Request $request)
    {
        $limit = $request->get('limit');
        $kw = $request->all();
        $res =  $items = $this->bannersService->BackList($limit,$kw);
        return $this->apiReturn($res);
    }

    public function info($id)
    {
        $item = $this->bannersService->BackInfo($id);
        return $this->apiReturn($item);
    }

    public function create(Request $request)
    {
        $param = $request->all();
        $res = $this->bannersService->BackUpdateOreCreate($param);
        return $this->apiReturn();
    }
}