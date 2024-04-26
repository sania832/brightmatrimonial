<?php

namespace App\Http\Resources;
use App\Models\City;
use App\Models\Country;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionMatchesListResource extends JsonResource
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
            'id'            => (string) $this->id,
            'image'       	=> $this->profile_image ? (string) asset('data/public/'. $this->profile_image) : asset('public/'. config('constants.DEFAULT_THUMBNAIL')),
            'name'       	=> $this->name ? (string) $this->name : '',
            'question_match' => $this->question_match ? (string) $this->question_match : '0',
            'bio'   		=> $this->bio ? new BioDataResource($this->bio) : null,
        ];
    }
}
