<?php

namespace App\Service;

use App\Events\CourseHit;
use App\Exceptions\ApiException;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseSectionResource;
use App\Models\CollegeSection;
use App\Repository\CourseRepository;
use App\Repository\CourseSectionRepository;
use App\Repository\MemberCollegeRepository;
use App\Repository\MemberCourseRepository;
use App\Repository\MemberStudyRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class CourseService extends Service
{
	protected $courseRepository;


	public function __construct(CourseRepository $courseRepository)
	{
		$this->courseRepository = $courseRepository;
	}


	/**
	 * 课程列表
	 * @param $request
	 * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
	 */
	public function index($request)
	{
		$items = $this->courseRepository->paginate($request->get('show_num', 8), $request->get('sort', 'sort'), $request->get('disease', 0), $request->get('keyword', ''));
		return CourseResource::collection($items);
	}

	/**
	 * 课程详情
	 * @param $id
	 * @return array
	 */
	public function info($id)
	{
		$item = $this->courseRepository->getById($id);
		if (!$item) throw new ModelNotFoundException();

		event(new CourseHit($item));

		$item->chapters = $this->cacheSections($id, $item->section);//章节
		$item->buyStatus = $this->memberCourseStatus($id);
		$info = new CourseResource($item); //dd();

		$recommends = $this->courseRepository->recommend($except_id = $item->id, $item->disease_id);
		$recommends = CourseResource::collection($recommends);
		return ['info' => $info, 'recommend' => $recommends];
	}

	/**
	 * 后台课程详情
	 * @param $id
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
	 */
	public function BackInfo($id)
	{
		$item = $this->courseRepository->BackById($id);

		if (!$item) throw new ModelNotFoundException();

		return $item;
	}

	/**
	 * 更新
	 * @param Request $request
	 */
	public function BackUpdateOreCreate(Request $request)
	{
		//更新基本信息
		$course = $this->courseRepository->BackUpdateOrCreate($request->id,$request->except('id'));
		$course->doctor()->sync($request->doctor_ids);
		return;
	}


	/**
	 * 添加章节
	 * @param $course_id
	 * @param $param
	 */
	public function BackAddSection($course_id, $param)
	{
		DB::transaction(function () use ($param, $course_id) {
			$param['course_id'] = $course_id;
			$courseSection = new CourseSectionRepository();
			$courseSection->BackUpdateOreCreate($param);
			//更新章节数
			$data = array(
				'id' => $course_id,
				'audio_count' => $courseSection->sectionVideoCount($course_id)
			);
			$this->courseRepository->BackUpdateOrCreate($course_id, $data);
		});


	}

	/**
	 *  课程章节列表
	 * @param Request $request
	 * @param $id
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function BackSections(Request $request, $id)
	{
		$items = (new CourseSectionRepository())->BackById($id, $request->get('limit', 20));
		return $items;
	}


	/**
	 * 视频信息
	 * @param $audio_id
	 * @return array
	 * @throws ApiException
	 */
	public function audio($audio_id)
	{
		$audio = (new CourseSectionRepository)->getById($audio_id);
		if (!$audio) throw new ModelNotFoundException();

		if (!$audio->is_free && $audio->course->sold_price && !$this->memberCourseStatus($audio->course_id)) throw new ApiException('请先购买');

		return ['title' => $audio->title, 'fileID' => $audio->source_id, 'appID' => config('config.appID')];
	}


	/**
	 * study log
	 * @param $request
	 */
	public function study($request)
	{
		$data = $request->only('course_id', 'course_section_id', 'time', 'end');
		$data['member_id'] = JWTAuth::parseToken()->touser()->id;
		$collection = collect($data);
		$memberStudy = new MemberStudyRepository;
		$memberStudy->createStudyLog($data);
		$memberStudy->update($collection->only(['member_id', 'course_id'])->all(), $collection->except(['member_id', 'course_id'])->all());
	}

	protected function cacheSections($course_id, $section)
	{
		/*return Cache::rememberForever(config('course_section_key').$course_id,function ()use($section){
			return CourseSectionResource::collection($section);
		});*/

		//todo 开发阶段，暂时不缓存
		return CourseSectionResource::collection($section);
	}

	/**
	 * 后台列表
	 * @param $limit
	 * @param $kw
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function BackList($limit, $kw)
	{
		return $this->courseRepository->BackPaginate($limit, null, $kw);

	}

	//统计用户总数
	public function BackCount()
	{
		$res = $this->courseRepository->BackCount();
		return $res;
	}

	/**
	 * 用户购买状态
	 * @return bool
	 */
	protected function memberCourseStatus($id)
	{
		$user = Auth::user();
		if (!$user) {
			return false;

		} else if ((new MemberCourseRepository())->buyStatus($user->id, $id)) {
			return true;

		} else if ((new MemberCollegeRepository())->contentInBuyedCollege($user->id, $id, CollegeSection::COURSE)) {
			return true;

		} else {
			return false;
		}
	}

}