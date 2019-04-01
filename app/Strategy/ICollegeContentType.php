<?php
namespace App\Strategy;

interface ICollegeContentType {
	public function getContentList($sectionId, $sort, $size);
}
