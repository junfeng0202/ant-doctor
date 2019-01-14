<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Service\AreaService;
use App\Service\ArticleService;
use App\Service\DiseaseService;

class CommonController extends Controller
{
	public function disease(DiseaseService $diseaseService)
	{
		return $diseaseService->disease();
	}

	public function province(AreaService $areaService)
	{
		return $areaService->province();
	}

	public function articlesList(PageRequest $pageRequest,ArticleService $articleService){
        return $articleService->articleList($pageRequest);
    }
}