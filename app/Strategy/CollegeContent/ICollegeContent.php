<?php

namespace App\Strategy\CollegeContent;

interface ICollegeContent
{
	public function getContentList($sectionId, $sort, $size);
}
