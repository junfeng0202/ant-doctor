<?php

namespace App\Repository;


use App\Models\Doctor;

class DoctorRepository
{

	public function getAll()
	{
		$disease = Doctor::query();
		return $disease->get();
	}
}