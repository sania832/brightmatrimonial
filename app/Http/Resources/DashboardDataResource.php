<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\QuestionAnswer;

class DashboardDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
		// return parent::toArray($request);
        return [
			'profile'				=> $this->profile ? $this->profile : null,
            'daily_matches'			=> $this->daily_matches ? $this->daily_matches : null,
            'question_matches'		=> $this->question_matches ? $this->question_matches : null,
            'just_joined'			=> $this->just_joined ? $this->just_joined : null,
        ];
    }
}
