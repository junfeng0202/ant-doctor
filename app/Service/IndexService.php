<?php

namespace App\Service;


use App\Models\Article;
use App\Models\Banner;
use App\Models\Course;
use App\Models\Live;
use App\Models\Member;
use App\Models\Video;
use App\Proxy\ProxyService;
use App\Repository\ArticleRepository;
use App\Repository\BannersRepository;
use App\Repository\CourseRepository;
use App\Repository\LiveRepository;
use App\Repository\MemberRepository;
use App\Repository\OauthRepository;
use App\Repository\VideoRepository;
use App\Transform\BannersTranform;
use Illuminate\Support\Facades\Auth;

class IndexService extends Service
{


    public function __construct()
    {
    }

    public function index()
    {
        //首页数据
        //首页banner
        $bannersRep = new BannersRepository();
        $banners = $bannersRep->getBanners()->get();
        $banners = Banner::parseRow($banners);

        //首页直播课推荐
        $liveRep = new LiveRepository();
        $lives = $liveRep->livesOfIndex();
        $lives = Live::parseRow($lives);

        //首页蚂蚁信息
        $articleRep = new ArticleRepository();
        $articles = $articleRep->articleList()->limit(3)->orderBy('created_at', 'desc')->get();
        $articles = Article::parseRow($articles);

        //首页课程
        $courseRep = new CourseRepository();
        $courses = $courseRep->listOfItem();
        $courses = Course::parseRow($courses);


        //首页音频
        $vedioRep = new VideoRepository();
        $video = $vedioRep->listOfIndex();
        $video = Video::parseRow($video);

        $res = [
            'mimeInfoList' => $articles,
            'indexBanner' => $banners,
            'mimeLiveList' => $lives,
            'mimeVideoList' => $courses,
            'mimeAudioList' => $video
        ];
        return $this->response->array($res);
    }

}