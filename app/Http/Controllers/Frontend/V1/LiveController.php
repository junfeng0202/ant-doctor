<?php
namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Service\LiveService;
use Illuminate\Http\Request;

class LiveController extends ApiController
{
	protected $liveService;

	public function __construct(LiveService $liveService)
	{
		$this->liveService = $liveService;

	}

	public function info($id)
	{
        $info = $this->liveService->info($id);
        $res = [
            'msg'=>'success',
            'code' =>200,
            'data' =>$info->toArray()
        ];
        return json_encode($res);
	}



}
