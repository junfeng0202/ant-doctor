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
use Illuminate\Http\Request;

class ArticleController extends ApiController
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;

    }

    public function list(Request $request)
    {
        $limit = $request->get('limit');
        $res =  $items = $this->articleService->BackList($limit);
        return $this->apiReturn($res);
    }

    public function info($id)
    {
        $item = $this->articleService->BackInfo($id);
        return $this->apiReturn($item);
    }

    public function create(Request $request)
    {
        $param = $request->all();
        $res = $this->articleService->BackUpdateOreCreate($param);
        return $this->apiReturn();
    }
}