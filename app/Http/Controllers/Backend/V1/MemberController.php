<?php
/**
 * Created by PhpStorm.
 * User: xiatong
 * Date: 2019/1/16
 * Time: 9:37 AM
 */

namespace App\Http\Controllers\Backend\V1;


use App\Http\Controllers\ApiController;
use App\Service\MemberService;
use Illuminate\Http\Request;

class MemberController extends ApiController
{
    protected $mamberService;

    public function __construct(MemberService $memberService)
    {
        $this->mamberService = $memberService;

    }

    public function list(Request $request)
    {
        $limit = $request->get('limit');
        $kw = $request->all();
        $res =  $items = $this->mamberService->BackList($limit,$kw);
        return $this->apiReturn($res);
    }
}