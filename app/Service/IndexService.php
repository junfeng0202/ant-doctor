<?php

namespace App\Service;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\BannerResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\LiveResource;
use App\Http\Resources\VideoResource;
use App\Repository\ArticleRepository;
use App\Repository\BannersRepository;
use App\Repository\CourseRepository;
use App\Repository\LiveRepository;
use App\Repository\VideoRepository;

class IndexService extends Service
{

	public function index(){

        //首页banner
        $banners = (new BannersRepository)->getBanners();
		$banners = BannerResource::collection($banners);

        //首页直播课推荐
        $lives = (new LiveRepository)->liveList();
        $lives =LiveResource::collection($lives);

        //首页蚂蚁信息

        $articles = (new ArticleRepository)->paginate(3);
        $articles = ArticleResource::collection($articles);

        //首页课程
        $courses = (new CourseRepository)->paginate(4);
        $courses = CourseResource::collection($courses);

        //首页音频
        $videos = (new VideoRepository)->paginate(3);
        $videos = VideoResource::collection($videos);

        $res = [
            'mimeInfoList' => $articles,
            'indexBanner' => $banners,
            'mimeLiveList' => $lives,
            'mimeVideoList' =>$courses,
            'mimeAudioList' => $videos
        ];
        return $res;
    }

}