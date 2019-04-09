<?php

namespace App\Service;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\BannerResource;
use App\Http\Resources\CollegeResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\LiveResource;
use App\Http\Resources\VideoResource;
use App\Repository\ArticleRepository;
use App\Repository\BannersRepository;
use App\Repository\CollegeRepository;
use App\Repository\CourseRepository;
use App\Repository\LiveRepository;
use App\Repository\MemberRepository;
use App\Repository\VideoRepository;
use Illuminate\Http\Request;

class IndexService extends Service
{

	public function index(){


		$interest = (new MemberService(new MemberRepository()))->memberInterest();
        //首页banner
        $banners = (new BannersRepository)->getBanners();
		$banners = BannerResource::collection($banners);

        //首页直播课推荐
        $lives = (new LiveRepository)->liveList();
        $lives =LiveResource::collection($lives);

        //讲堂
		$college = (new CollegeRepository())->getList(3);
		$college = CollegeResource::collection($college);

        //首页蚂蚁信息
        $articles = (new ArticleRepository)->paginate(3, $interest);
        $articles = ArticleResource::collection($articles);

        //首页课程
        $courses = (new CourseRepository)->paginate(4);
        $courses = CourseResource::collection($courses);

        //首页音频
        $videos = (new VideoRepository)->paginate(3);
        $videos = VideoResource::collection($videos);

        $res = [
	        'bannerList' => $banners,
	        'liveList' => $lives,
	        'collegeList' => $college,
	        'articleList' => $articles,
            'CourseList' =>$courses,
            'videoList' => $videos
        ];
        return $res;
    }


	/**
	 * 首页搜索
	 * @param Request $request
	 * @return array
	 */
	public function search(Request $request)
    {

    	if($disease_id = $request->disease) {
    		//资讯
		    $articles = (new ArticleRepository)->paginate(5, [], 'sort', $disease_id);//dd($articles);
		    $articles = ArticleResource::collection($articles);

		    //课程
		    $courses = (new CourseRepository)->paginate(4,'sort', $disease_id);
		    $courses = CourseResource::collection($courses);

		    //首页音频
		    $videos = (new VideoRepository)->paginate(6, $disease_id);
		    $videos = VideoResource::collection($videos);

	    } elseif($kw = $request->keyword){
			//资讯
		    $articles = (new ArticleRepository)->getListByKeyword($kw, 5);
		    $articles = ArticleResource::collection($articles);

		    //课程
		    $courses = (new CourseRepository)->getListByKeyword($kw,4);
		    $courses = CourseResource::collection($courses);

		    //首页音频
		    $videos = (new VideoRepository)->getListByKeyword($kw,6);
		    $videos = VideoResource::collection($videos);
	    }
	    return compact('videos', 'courses', 'articles');
    }
}