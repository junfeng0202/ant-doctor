<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class  StudyLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
        	'course_id'=>$this->course_id,
	        $this->mergeWhen($this->studyCourse, [
		        'course_image '=> $this->studyCourse->image,
		        'course_title'=> $this->studyCourse->title,
		        'course_count'=> $this->studyCourse->audio_count,
	        ]),
	        $this->mergeWhen($this->studyCourseSection, [
		        'section_id '=> ($this->studyCourseSection->pid ? ($this->studyCourseSection->pid.'-') : '').$this->studyCourseSection->id,
		        'section_title'=> $this->studyCourseSection->title,
		        'section_timer'=> $this->studyCourseSection->duration,
	        ]),

	        'study_at'=>numberToTime($this->time),
	        'end'=>$this->end
        ];
    }
}
