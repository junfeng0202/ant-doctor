<?php

namespace App\Repository;

use App\Models\Banner;


class BannersRepository
{

	/**
	 * get frontend banners
	 * @param int $position
	 * @return mixed
	 */
	public function getBanners($position = 0)
	{
		return Banner::enable()->latest('sort')->position($position)->get();
	}

	/**
	 * get banner list with paginate
	 * @param int $page
	 * @param string $sort
	 * @param $kw
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function BackPaginate($page = 10, $sort = 'sort', $kw)
	{
		$query = Banner::query();
		$query->latest($sort);
		return $query->paginate($page);
	}


	/**
	 * get banner info
	 * @param $id
	 * @return mixed
	 */
	public function BackById($id)
	{
		return Banner::find($id);
	}


	/**
	 * edit banner info
	 * @param $data
	 * @return mixed
	 */
	public function BackUpdateOreCreate($data)
	{
		return Banner::updateOrCreate(['id' => $data['id']], $data);
	}

	/**
	 * delete banner by id
	 * @param $id
	 * @return int
	 */
	public function BackDelete($id)
	{
		return Banner::destroy($id);
	}


}